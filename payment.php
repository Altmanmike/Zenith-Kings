<!-- Page de paiment d'une commande -->
<?php

    // Validation de la query string dans l'URL.
    if(!array_key_exists('id', $_GET) OR !ctype_digit($_GET['id']))
    {
        header('Location: member_create.php');
        exit();
    }

    include 'application/bdd_connection.php';
        
    // Récupération de tous les produits ajoutés au panier ainsi que leurs infos
    $query =
    '
        SELECT
            Orderline.Id,
            QuantityOrdered,
            Product_Id,
            Order_Id,
            PriceEach,
            Name,
            Photo,
            Description,
            QuantityInStock,
            BuyPrice,
            SalePrice
        FROM
            Orderline
        INNER JOIN
            Product
        ON
            Orderline.Product_Id = Product.Id            
        WHERE
            Order_Id = ?
    ';

    $resultSet = $pdo->prepare($query);
    $resultSet->execute([ $_GET['id'] ]);
    $prodsInCarts = $resultSet->fetchAll();
    //var_dump($prodsInCarts);

    // Récupération des informations et calculs des prix totaux hors taxes et frais de port puis avec..
    $query =
    '
        SELECT
            *
        FROM
            `Order`
        WHERE
            Id = ?
    ';

    $resultSet = $pdo->prepare($query);
    $resultSet->execute([ $_GET['id'] ]);
    $orders = $resultSet->fetch();
    //var_dump($orders);

    // Sélection et affichage du template PHTML.
    $template = 'payment';
    include 'layout.phtml';
?>