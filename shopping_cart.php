<!-- Page de gestion d'une commande -->
<?php

    // Validation de la query string dans l'URL.
    if(!array_key_exists('id', $_GET) OR !ctype_digit($_GET['id']))
    {
        // Redirection vers la page de création de compte.
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
    
    $sumOrder = 0;    
    foreach($prodsInCarts as $prodsInCart):
    {
        $sumOrderLine  = $prodsInCart['QuantityOrdered'] * $prodsInCart['SalePrice'];
        $sumOrder = $sumOrder + $sumOrderLine;
    }
    endforeach;
    $orders['SumPrices'] = $sumOrder;
   
    // Opérations sur les prix des produits ajouté
    $totalHTHP  = $orders['SumPrices'];    
    $totalTTCHP = $orders['SumPrices'] + ($orders['SumPrices'] * $orders['Taxes'])/100;
    $totalTTC = $totalTTCHP + ($totalTTCHP * $orders['CostOfPortage'])/100;
    $orders['Total'] = $totalTTC;

    // Insertion des valeurs totaux hors taxes et frais de port de la commande en cours, puis avec..    
    $query =
    '
        UPDATE
            `Order`
        SET
            SumPrices = ?,
            Total = ?
        WHERE
            Id = ? 
    ';

    $resultSet = $pdo->prepare($query);
    $resultSet->execute([ $orders['SumPrices'], $orders['Total'], $_GET['id'] ]);

    // Sélection et affichage du template PHTML.
    $template = 'shopping_cart';
    include 'layout.phtml';
?>