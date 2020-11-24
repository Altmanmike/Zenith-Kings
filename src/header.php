<?php require_once 'application/functions.php'; ?>
<?php if(session_status() == PHP_SESSION_NONE) {
        // Démarrage du module PHP de gestion des sessions.
        session_start();        
    }
?>
<?php ob_start(); ?>
<?php
    include 'application/bdd_connection.php';
?>
<?php
    if(isAuth())
    {
        $memberId = $_SESSION['member']['Id'];
        
        // Récupérons, après insertion, l'id de la commande
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
        
        if(empty($order))
        {
            // On créer une commande et on génére un id
            $query =
            '
                INSERT INTO
                    `Order` (Member_Id, SumPrices, Taxes, CostOfPortage, Total, CreationTimestamp)
                VALUES
                    (?, 0, 20, 11, 0, NOW())
            ';

            $resultSet = $pdo->prepare($query);
            $resultSet->execute([ $memberId ]);
            
            // Redirection vers la page d'accueil après création d'un panier vide.
            //header('Location: index.php');
            //exit();
            header('refresh:0, url=index.php');
        }
    }
?>