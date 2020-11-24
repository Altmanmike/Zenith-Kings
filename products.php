<?php
    include 'application/bdd_connection.php';

    // Récupération de tous les produits (détails + photo)
    $query =
    '
        SELECT
            * 
        FROM
            Product
    ';

    $resultSet = $pdo->query($query);
    $products = $resultSet->fetchAll();
    //var_dump($products);

    // Sélection et affichage du template PHTML.
    $template = 'products';
    include 'layout.phtml';
?>
