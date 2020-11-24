<!-- Page d'administration: édition/suppression de géoconflits -->
<?php require_once 'application/functions.php'; ?>
<?php

    if(getAdmin() == null)
    {        
        // Redirection vers l'acceuil.
        header('Location: index.php');
        exit();
    }

    include 'application/bdd_connection.php';
    
    // Récupération de tous membres et de leurs infos
    $query =
    '
        SELECT
            * 
        FROM
            War
        ORDER BY
            CreationTimestamp DESC
    ';

    $resultSet = $pdo->prepare($query);
    $resultSet->execute();
    $wars = $resultSet->fetchAll();
    //var_dump($wars);

    // Sélection et affichage du template PHTML.
    $template = 'admin_wars';
    include 'layout.phtml';
?>