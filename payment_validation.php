<!-- Validation de paiement d'une commande -->
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

    // Mise à jour de CompleteTimestamp pour finaliser le paiement de la commande.  
    $query =
    '
        UPDATE
            `Order`
        SET
            CompleteTimestamp = NOW()
        WHERE
            Id = ? 
    ';

    $resultSet = $pdo->prepare($query);
    $resultSet->execute([ $_GET['id'] ]);

    // Message de succès si le paiement a été effectué
    $successMessage = "Payment done!!!";

    // Sélection et affichage du template PHTML.
    $template = 'payment_validation';
    include 'layout.phtml';

    // Redirection vers la page d'acceuil.   
    header('refresh:3; url=index.php');
?>