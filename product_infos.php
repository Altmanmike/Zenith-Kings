<?php
    // Validation de la query string dans l'URL.
    if(!array_key_exists('id', $_GET) OR !ctype_digit($_GET['id']))
    {
        // Redirection vers la page de liste des produits.
        header('Location: products.php');
        exit();
    }

    include 'application/bdd_connection.php';

    // Récupération d'un produit en particulier (détails + photo)
    $query =
    '
        SELECT
            Name, Photo, Description, SalePrice 
        FROM
            Product
        WHERE
            Id = ?
    ';

    $resultSet = $pdo->prepare($query);
    $resultSet->execute([ $_GET['id'] ]);
    $product = $resultSet->fetch();
    //var_dump($product);

    // Sélection et affichage du template PHTML.
    $template = 'product_infos';
    include 'layout.phtml';
?>