<!-- Page d'administration: édition/rédaction des articles (titre + contenu) -->
<?php require_once 'application/functions.php'; ?>
<?php

    if(getAdmin() == null)
    {        
        // Redirection vers l'acceuil.
        header('Location: index.php');
        exit();
    }

    include 'application/bdd_connection.php';

    // Récupération de tous les articles du blog classés par ordre antéchronologique.
    $query =
    '
        SELECT
            Post.Id,
            Title,
            Contents,
            Post.CreationTimestamp,
            FirstName,
            LastName,
            Category.Name AS Category_Name
        FROM
            Post
        INNER JOIN
            Member
        ON
            Post.Member_Id = Member.Id
        INNER JOIN
            Category
        ON
            Post.Category_Id = Category.Id
        ORDER BY
            Post.CreationTimestamp DESC
    ';
    $resultSet = $pdo->query($query);
    $posts = $resultSet->fetchAll();
    //var_dump($posts);

    // Sélection et affichage du template PHTML.
    $template = 'admin_posts';
    include 'layout.phtml';
?>