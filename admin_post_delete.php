<!-- Page d'administration: suppression d'un article (titre + contenu) -->
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

    // Suppression d'un article du blog.
    $query =
    '
        DELETE FROM
            Post
        WHERE
            Id = ?
    ';
    $resultSet = $pdo->prepare($query);
    $resultSet->execute([ $_GET['id'] ]);

    // Redirection vers le panneau d'administration des articles.
    //header('Location: admin_posts.php');
    //exit();    
    header('refresh:0; url=admin_posts.php');
?>
