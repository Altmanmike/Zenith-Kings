<!-- Page de gestion de commande: suppression d'un produit ajouté au panier -->
<?php

    // Validation de la query string dans l'URL.
    if(!array_key_exists('id', $_GET) OR !ctype_digit($_GET['id']))
    {
        // Redirection vers la page de création de compte.
        header('Location: member_create.php');
        exit();
    }

    include 'application/bdd_connection.php';

    //$_SESSION['member']['Id'] = $_GET['memberId'];    
    $memberId = $_GET['memberId'];
    
    // Retrouvons le numéro de la commande en cours
    $query =
    '
        SELECT
            Id
        FROM
            `Order`
        WHERE
           Member_Id = ? && CompleteTimestamp IS NULL
    ';
    $resultSet = $pdo->prepare($query);
    $resultSet->execute([ $memberId ]);
    $order = $resultSet->fetch();
    //var_dump($order);

    // Suppression de la bdd d'un produit sélectionné pour le panier.
    $query =
    '
        DELETE FROM
            Orderline
        WHERE
            Id = ?
    ';
    $resultSet = $pdo->prepare($query);
    $resultSet->execute([ $_GET['id'] ]);

    // Redirection vers le panier: liste des produits sélectionnés pour commande.
    $href = "shopping_cart.php?id=".$order['Id'];
    header('refresh:0; url='.$href);
?>
