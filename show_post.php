<!-- Page d'affichage d'un article en particulier -->
<?php require_once 'application/functions.php'; ?>
<?php
    // Validation de la query string dans l'URL de l'article.
    if(!array_key_exists('id', $_GET) OR !ctype_digit($_GET['id']))
    {        
        // Redirection vers la page d'acceuil.
        header('Location: index.php');
        exit();       
    }
      
    include 'application/bdd_connection.php';
        
    // Récupération d'un article du blog.
    $query =
    '
        SELECT
            Post.Id,
            Title,
            Picture,
            Contents,
            Post.CreationTimestamp,
            FamilyName,
            CharacterName
        FROM
            Post
        INNER JOIN
            Member
        ON
            Post.Member_Id = Member.Id
        WHERE
            Post.Id = ?
    ';
    $resultSet = $pdo->prepare($query);
    $resultSet->execute([$_GET['id']]);
    $post = $resultSet->fetch();
    //var_dump($post);

    // Récupération de tous les commentaires de l'article du blog.
    $query =
    '
        SELECT
            Comment.Id,            
            Contents,
            Comment.CreationTimestamp,
            Avatar,
            FamilyName,
            CharacterName
        FROM
            Comment
        INNER JOIN
            Member
        ON
            Comment.Member_Id = Member.Id
        WHERE
            Post_Id = ?
    ';
    $resultSet = $pdo->prepare($query);
    $resultSet->execute([ $_GET['id'] ]);
    $comments = $resultSet->fetchAll();
    //var_dump($comments);

    // Récupération du nombre des commentaires postés
    $query = 
    '
        SELECT
            COUNT(Id)
        AS
            nbcommentaires
        FROM
            Comment
        WHERE
            Post_Id = ?
    ';
    $resultSet = $pdo->prepare($query);
    $resultSet->execute([ $_GET['id'] ]);
    $nbComments = $resultSet->fetch();
    //var_dump($nbComments);

    // Gestion des likes:
    //      
    // Récupération du nombre total de likes pour cet article là
    $query =
    '
        SELECT
            COUNT(Post_Id)
        AS
            nblikesarticles
        FROM
            Likes
        WHERE
            Value = 1 && Post_Id = ? && Comment_Id IS NULL             
    ';
    $resultSet = $pdo->prepare($query);
    $resultSet->execute([ $_GET['id'] ]);    
    $nbLikesPost = $resultSet->fetch();
    //var_dump($nbLikesPost);

    // Récupération du nombre de likes pour chacun des commentaires liés à l'article    
    if($nbComments > 0)
    {
        $nbLikesComment = array();
        $LikesCommentId = array();
        
        foreach($comments as $comment):
        {
            $query =
            '
                SELECT
                    COUNT(Comment_Id)
                AS  
                    nbLikesCommentaires
                FROM
                    Likes
                WHERE
                    Value = 1 && Post_Id = ? && Comment_Id = ?           
            ';
            $resultSet = $pdo->prepare($query);
            $resultSet->execute([ $_GET['id'], $comment['Id'] ]);
            $nbLikesCom = $resultSet->fetch();            
            
            // stockage du nombre de like pour le commentaire d'id $comment['Id']
            array_push($nbLikesComment, array($nbLikesCom));
            array_push($LikesCommentId, array($comment['Id']));           
        }
        endforeach;
    }
    else
    {
        $nbLikesComment = 0; // ou en array
    }

    if(isAuth())
    {
        // récupération de l'id membre à partir de la variable de session
        $member['Id'] = $_SESSION['member']['Id'];
    }
    else
    {
        $member['Id'] = "";
    }

    // Récupération de la valeur "s'il y a un like ou pas" (cas de l'article)
    $query = 
    '
        SELECT
            Value 
        FROM
            Likes 
        WHERE
            Post_Id = ? && Member_Id = ? && Comment_Id IS NULL
    ';

    $resultSet = $pdo->prepare($query);
    $resultSet->execute([ $_GET['id'], $member['Id'] ]);
    $LikePostVal = $resultSet->fetch();
    $LikePostVal = $LikePostVal['Value'];
    //var_dump($LikePostVal);


    // Récupération de la valeur "s'il y a un like ou pas" selon le commentaire!
    $LikeCommentVal = array();
    for($i = 0; $i < COUNT($LikesCommentId); $i++):
    {
        //var_dump($LikesCommentId[$i][0]);
        
        $query = 
        '
            SELECT
                Value 
            FROM
                Likes 
            WHERE
                Post_Id = ? && Member_Id = ? && Comment_Id = '.$LikesCommentId[$i][0]
        ;
        $resultSet = $pdo->prepare($query);
        $resultSet->execute([ $_GET['id'], $member['Id'] ]);
        $LikeComVal = $resultSet->fetch();
        //var_dump($LikeComVal);        
        // stockage des valeurs de like pour le commentaire d'id $LikesCommentId[$i]
        array_push($LikeCommentVal, array($LikeComVal['Value'])); 
    }
    endfor;

    if(isset($_GET['btn-lkd']))
    {
        if($_GET['commentId'] == "NULL")
        {
            if($LikePostVal == "")
            {
                // Insertion du premier j'aime de l'article dans la bdd
                $query =
                '
                    INSERT INTO
                        Likes (Post_Id, Member_Id, Comment_Id, Value)
                    VALUES
                         (?, ?, NULL, 1)
                ';
                $resultSet = $pdo->prepare($query);
                $resultSet->execute([ $_GET['id'], $member['Id'] ]);
                //var_dump($resultSet);

                $LikePostVal = 1;

            }
            elseif($LikePostVal == 1)
            {
                $LikePostVal = 0;            
            }
            elseif($LikePostVal == 0)
            {
                $LikePostVal = 1;           
            }

            // Ajout ou retrait du j'aime de l'article dans la bdd
            $query =
            '
                UPDATE
                    Likes
                SET
                    Value = '.$LikePostVal.' 
                WHERE
                    Post_Id = ? && Member_Id = ? && Comment_Id IS NULL'
            ;
            $resultSet = $pdo->prepare($query);
            $resultSet->execute([ $_GET['id'], $member['Id'] ]);
            //var_dump($resultSet);

            // on revient sur la page après avoir MODIFIE le j'aime
            header('refresh:0; url=show_post.php?id='.intval($_GET['id'])); 
        }
        else
        {
            // $_GET['commentId'] est un chiffre/nombre, donc pour un commentaire et plus un article       {
            if($_GET['btn-lkd'] == "")    // c'est $LikeCommentVal[$cpt][0]
            {
                // Insertion du premier j'aime du commentaire de l'article dans la bdd
                $query =
                '
                    INSERT INTO
                        Likes (Post_Id, Member_Id, Comment_Id, Value)
                    VALUES
                         (?, ?, ?, 1)
                ';
                $resultSet = $pdo->prepare($query);
                $resultSet->execute([ $_GET['id'], $member['Id'], $_GET['commentId'] ]);
                //var_dump($resultSet);

                $LikeCommentVal = 1;

            }
            elseif($_GET['btn-lkd'] == 1)
            {
                $LikeCommentVal = 0;            
            }
            elseif($_GET['btn-lkd'] == 0)
            {
                $LikeCommentVal = 1;           
            }

            // Ajout ou retrait du j'aime du commentaire de l'article dans la bdd
            $query =
            '
                UPDATE
                    Likes
                SET
                    Value = '.$LikeCommentVal.' 
                WHERE
                    Post_Id = ? && Member_Id = ? && Comment_Id = ?'
            ;
            $resultSet = $pdo->prepare($query);
            $resultSet->execute([ $_GET['id'], $member['Id'], $_GET['commentId'] ]);
            //var_dump($resultSet);

            // on revient sur la page après avoir MODIFIE le j'aime
            header('refresh:0; url=show_post.php?id='.intval($_GET['id']));
        }
    }    
        
    if(isset($_POST['addComment']))
    {
        // Ajout d'un commentaire à un article du blog.
        $query =
        '
            INSERT INTO
                Comment
                (Member_Id, Contents, Post_Id, CreationTimestamp)
            VALUES
                (?, ?, ?, NOW())
        ';
        $resultSet = $pdo->prepare($query);
        $resultSet->execute([ $member['Id'], $_POST['contents'], $_POST['postId'] ]);

        // Retour à l'article détaillé une fois que le nouveau commentaire a été ajouté.
        header('refresh:0; url=show_post.php?id='.$_POST['postId']);
    }

    // Sélection et affichage du template PHTML.
    $template = 'show_post';
    include 'layout.phtml';
?>