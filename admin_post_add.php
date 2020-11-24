<!-- Page d'administration: ajout d'un nouvel article (titre + contenu) -->
<?php require_once 'application/functions.php'; ?>
<?php

    if(getAdmin() == null)
    {        
        // Redirection vers l'acceuil.
        header('Location: index.php');
        exit();
    }

    include 'application/bdd_connection.php';

    // initialisation des messages d'erreurs.
    $errorMessage = array();    
    $successMessage = "";

    // Champ "Picture" à remplir correctement.
    if(isset($_FILES['picture']))
    {
        $file_name = $_FILES['picture']['name'];
        $file_size = $_FILES['picture']['size'];
        $file_tmp  = $_FILES['picture']['tmp_name'];
        $file_type = $_FILES['picture']['type'];
        $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));        
        list($width, $height, $type, $attr) = getimagesize($file_tmp);
        
        if(file_exists("img/posts/".$file_name))
        {
            $postPic = $file_name; 
        }
        
        $extension = "jpg";

        if($file_ext != $extension)
        {
            $errorMessage[] = "extension not allowed, please choose a JPG file.";
        }

        if($file_size > 4194304)
        {
            $errorMessage[] = 'File size must be < 4 Mo';
        }

        if(($width > 1920 ) && ($height > 1080))
        {
            $errorMessage[] = 'File pixels width x height must be < 1920 x 1080';    
        }
        
        if(empty($errorMessage) == true)
        {
            move_uploaded_file($file_tmp, "img/posts/".$file_name);            
        }

        $postPic = $file_name;       
    }
    else
    {
        $postPic = "";
    }

    if(isset($_POST['addPost']) && empty($errorMessage))    
    {       
        // Ajout d'un nouvel article pour le blog.
        $query =
        '
            INSERT INTO
                Post
                (Title, Picture, Contents, Member_Id, Category_Id, CreationTimestamp)
            VALUES
                (?, ?, ?, ?, ?, NOW())
        ';
        $resultSet = $pdo->prepare($query);
        $resultSet->execute([ $_POST['title'], $postPic, $_POST['contents'], $_POST['memberId'], $_POST['categoryId'] ]);

        $successMessage = "L'article a bien été ajouté au blog!";
        
        // Retour à la page d'administration des articles une fois que le nouvel article du blog a été ajouté.
        header('refresh:3; url=admin_posts.php');
    }

    // Sélection et affichage du template PHTML.
    $template = 'admin_post_add';
    include 'layout.phtml';
?>