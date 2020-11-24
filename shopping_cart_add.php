<!-- Page de gestion de commande: ajout d'un produit ajouté au panier -->
<?php

    // Validation de la query string dans l'URL.
    if(!array_key_exists('id', $_GET) OR !ctype_digit($_GET['id']))
    {
        // Redirection vers la page de création de compte.
        header('Location: member_create.php');
        exit();
    }

    // initialisation des messages d'erreurs
    $errorMessage = array();
    $successMessage = "";

    include 'application/bdd_connection.php';

    //$_SESSION['member']['Id'] = $_GET['memberId'];    
    $memberId = $_GET['memberId']; 

    // Récupérons le prix de vente du produit concerné dès le départ..
    $query =
    '
        SELECT
            Name,
            SalePrice
        FROM
            Product 
        WHERE
           Id = ?
    ';
    $resultSet = $pdo->prepare($query);
    $resultSet->execute([ $_GET['id'] ]);
    $product = $resultSet->fetch();
    //var_dump($product);

    // Informations de notre commande
    $query =
    '
        SELECT
            *
        FROM
            `Order`
        WHERE
           Member_Id = ? && CompleteTimestamp IS NULL
    ';
    $resultSet = $pdo->prepare($query);
    $resultSet->execute([ $memberId ]);
    $order = $resultSet->fetch();
    //var_dump($order);

    // Y a-t-il déjà eu un ajout de ce produit à la bdd pour une commande non finalisée..
    $query =
    '
        SELECT
            *
        FROM
            Orderline 
        WHERE
            Product_Id = ? && Order_Id = ?
    ';
    $resultSet = $pdo->prepare($query);
    $resultSet->execute([ $_GET['id'], $order['Id'] ]);
    $orderLine = $resultSet->fetch();
    //var_dump($orderLine);

    if(empty($orderLine))
    {        
        //Première insertion de la sélection de ce produit pour commande.
        // S'il n'y a pas eu de ligne de commande pour cette commande, alors insérons celle pour ce produit-ci, avec une quantité de base:
        $query =
        '
            INSERT INTO
                Orderline (QuantityOrdered, Product_Id, Order_Id, PriceEach)
            VALUES
                (1, ?, ?, ?)
        ';
        $resultSet = $pdo->prepare($query);
        $resultSet->execute([ $_GET['id'], $order['Id'], $product['SalePrice'] ]);
    }
    else
    {
        // Autre insertion de la sélection de ce produit pour commande (incrémentation).
        $orderLine['QuantityOrdered']++;
        $query =
        '
            UPDATE
                Orderline
            SET
                QuantityOrdered = ?
            WHERE
                Product_Id = ? && Order_Id = ? 
        ';

        $resultSet = $pdo->prepare($query);
        $resultSet->execute([ $orderLine['QuantityOrdered'], $_GET['id'], $orderLine['Order_Id'] ]);
    }

    // Message de succès si le produit a bien été ajouté au panier.
    $successMessage = $product['Name']."The product has been correctly added to the cart!";
    //printSuc($successMessage);

    // Sélection et affichage du template PHTML.
    $template = 'shopping_cart_add';
    include 'layout.phtml';

    // Redirection vers le panier: liste des produits sélectionnés pour commande.
    $href = "product_infos.php?id=".$_GET['id'];
    header('refresh:2; url='.$href);
?>