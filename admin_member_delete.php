<!-- Page d'administration: suppression d'un membre -->
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

    // Suppression d'un membre de la bdd.
    $query =
    '
        DELETE FROM
            Member
        WHERE
            Id = ?
    ';
    $resultSet = $pdo->prepare($query);
    $resultSet->execute([$_GET['id']]);

    // Redirection vers le panneau d'administration de la liste des membres.
    header('refresh:0; url=admin_members.php');
?>
