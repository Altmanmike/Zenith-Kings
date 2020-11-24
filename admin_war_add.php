<!-- Page d'administration: ajout d'un nouveau géoconflit (noms de guildes + logos) -->
<?php require_once 'application/functions.php'; ?>
<?php

    if(getAdmin() == null)
    {        
        // Redirection vers l'acceuil.
        header('Location: index.php');
        exit();
    }

    include 'application/bdd_connection.php';

    // initialisation des messages d'erreurs
    $errorMessage = array();    
    $successMessage = "";

    if(isset($_FILES['usLogo']))
    {
        $file_name = $_FILES['usLogo']['name'];
        $file_size = $_FILES['usLogo']['size'];
        $file_tmp  = $_FILES['usLogo']['tmp_name'];
        $file_type = $_FILES['usLogo']['type'];
        $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        //var_dump("file_name: ".$file_name, "file_size: ".$file_size, "file_tmp: ".$file_tmp, "file_type: ".$file_type, "file_ext: ".$file_ext);
        
        $extension = "jpg";

        if($file_ext != $extension)
        {
             $errorMessage[] = "extension not allowed, please choose a JPG file.";
        }

        if($file_size > 2500000)
        {
             $errorMessage[] = "File size must be < 25 ko";
        }

        if(empty($errorUpload) == true)
        {
             move_uploaded_file($file_tmp, "img/wars/".$file_name);             
        }
        
        //var_dump($file_name." is_uploaded_file ? : ".is_uploaded_file($file_tmp));
    }    

    if(isset($_FILES['opponentLogo']))
    {
        $file_name = $_FILES['opponentLogo']['name'];
        $file_size = $_FILES['opponentLogo']['size'];
        $file_tmp  = $_FILES['opponentLogo']['tmp_name'];
        $file_type = $_FILES['opponentLogo']['type'];
        $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));    

        //var_dump("file_name: ".$file_name, "file_size: ".$file_size, "file_tmp: ".$file_tmp, "file_type: ".$file_type, "file_ext: ".$file_ext);
        
        $extension = "jpg";

        if($file_ext != $extension)
        {
             $errorMessage[] = "extension not allowed, please choose a JPG file.";
        }

        if($file_size > 2500000)
        {
             $errorMessage[] = "File size must be < 25 ko";
        }

        if(empty($errorMessage) == true)
        {
             move_uploaded_file($file_tmp, "img/wars/".$file_name);             
        }
        
        //var_dump($file_name." is_uploaded_file ? : ".is_uploaded_file($file_tmp));
    } 

    if(isset($_POST['addWar']) && empty($errorMessage))
    {
        // Ajout d'un nouveau match de la liste des géoconflits.
        $query =
        '
            INSERT INTO
                War
                (Us, UsLogo, Opponent, OpponentLogo, Day, Node, Tier, Score, CreationTimestamp)
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ';
        $resultSet = $pdo->prepare($query);
        $resultSet->execute([ $_POST['us'], $_POST['us'], $_POST['opponent'], $_POST['opponent'], $_POST['day'], $_POST['node'], $_POST['tier'], $_POST['score'] ]);

        $successMessage = "Le match a bien été ajouté..";        

        // Retour à la page d'administration des géoconflits une fois que le nouveau match a été ajouté.
        header('refresh:4; url=admin_wars.php');
    }

    // Sélection et affichage du template PHTML.
    $template = 'admin_war_add';
    include 'layout.phtml';
?>