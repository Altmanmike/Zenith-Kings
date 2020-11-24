<!-- Page d'administration: édition d'un article (titre + contenu) -->
<?php require_once 'application/functions.php'; ?>
<?php

    if(getAdmin() == null)
    {        
        // Redirection vers l'acceuil.
        header('Location: index.php');
        exit();
    }

    // initialisation des messages d'erreurs
    $errorMessage = array();    
    $successMessage = "";

    include 'application/bdd_connection.php';

    if(empty($_POST['editPost']))
    {        
        // Validation de la query string dans l'URL.
        if(!array_key_exists('id', $_GET) OR !ctype_digit($_GET['id']))
        {
            // Redirection vers l'acceuil.
            header('Location: index.php');
            exit();
        }

        // Récupération d'un article du blog.
        $query =
        '
            SELECT
                Id,
                Title,
                Picture,
                Contents
            FROM
                Post
            WHERE
                Id = ?
        ';
        $resultSet = $pdo->prepare($query);
        $resultSet->execute([$_GET['id']]);        
        $post = $resultSet->fetch();
        //var_dump($post);
    }
    else   
    {
        // Champ "Picture" à remplir correctement
        if(isset($_FILES['picture']))
        {                                       
            $file_name = $_FILES['picture']['name'];
            $file_size = $_FILES['picture']['size'];
            $file_tmp  = $_FILES['picture']['tmp_name'];
            $file_type = $_FILES['picture']['type'];
            //$file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            list($width, $height, $type, $attr) = getimagesize($file_tmp);                         

            if(file_exists("img/posts/".$file_name))
            {
                $postPic = $file_name; 
            }

            //$extension = 'jpg';

            if($file_type != 'image/jpeg') 
            {
                $errorMessage[] = 'extension not allowed, please choose a JPG/JPEG file.';
            }

            if($file_size > 4194304)
            {
                $errorMessage[] = 'File size must be < 4 Mo';
            }

            if(($width > 2000 ) && ($height > 1200))
            {
                $errorMessage[] = 'File pixels width x height must be < 2000 x 1200';    
            }

            if(empty($errorMessage) == true)
            {
                move_uploaded_file($file_tmp, "img/posts/".$file_name);                
            }

            $postPic = $file_name;                          
        }
        else
        {
            $postPic = $post['Picture'];
        }
        
        // Edition d'un article du blog.
        $query =
        '
            UPDATE
                Post
            SET
                Title = ?,
                Picture = ?,
                Contents = ?,
                Member_Id = ?,
                Category_Id = ?
            WHERE
                Id = ?
        ';
        $resultSet = $pdo->prepare($query);
        $resultSet->execute([$_POST['title'], $postPic, $_POST['contents'], $_POST['memberId'], $_POST['categoryId'], $_GET['id']]);
        
        $successMessage = "Les données de l'article n°".$_GET['id']." ont bien été mises à jour.";
        
        // Retour au panneau d'administration des articles.
        header('refresh:5; url=admin_posts.php');
    }

    // Sélection et affichage du template PHTML.
    $template = 'admin_post_edit';
    include 'layout.phtml';
?>