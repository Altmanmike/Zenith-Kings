<!-- Page d'administration: édition/suppression de produits du catalogue -->
<?php require_once 'application/functions.php'; ?>
<?php

    if(getAdmin() == null)
    {        
        // Redirection vers l'acceuil.
        header('Location: index.php');
        exit();
    }

    include 'application/bdd_connection.php';
    
    // Récupération de tous les produits en vente et de leurs infos
    $query =
    '
        SELECT
            * 
        FROM
            Product
    ';

    $resultSet = $pdo->prepare($query);
    $resultSet->execute();
    $products = $resultSet->fetchAll();
    //var_dump($products);

    // Sélection et affichage du template PHTML.
    $template = 'admin_products';
    include 'layout.phtml';
?>
