<!-- Page d'administration: suppression d'un produit en particulier -->
<?php require_once 'application/functions.php'; ?>
<?php

    if(getAdmin() == null)
    {        
        // Redirection vers l'acceuil.
        header('Location: index.php');
        exit();
    }

    // Validation de la query string dans l'URL.
    if(!array_key_exists('id', $_GET) OR !ctype_digit($_GET['id']))
    {
        // Redirection vers l'acceuil.
        header('Location: index.php');
        exit();
    }

    include 'application/bdd_connection.php';

    // Suppression d'un produit de la liste du catalogue.
    $query =
    '
        DELETE FROM
            Product
        WHERE
            Id = ?
    ';
    $resultSet = $pdo->prepare($query);
    $resultSet->execute([$_GET['id']]);

    // Redirection vers le panneau d'administration des produits.
    //header('Location: admin_products.php');
    //exit();
    header('refresh:0; url=admin_products.php');
?>
