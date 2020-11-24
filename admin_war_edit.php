<!-- Page d'administration: édition d'un géoconflit (noms de guildes + logos) -->
<?php require_once 'application/functions.php'; ?>
<?php

    if(getAdmin() == null)
    {        
        // Redirection vers l'acceuil.
        header('Location: index.php');
        exit();
    }

    include 'application/bdd_connection.php';

    if(empty($_POST['editWar']))
    {        
        // Validation de la query string dans l'URL.
        if(!array_key_exists('id', $_GET) OR !ctype_digit($_GET['id']))
        {
            // Redirection vers l'acceuil.
            header('Location: index.php');
            exit();
        }

        // Récupération des informations d'un match en particulier..
        $query =
        '
            SELECT
                Id,
                Us,
                UsLogo,
                Opponent,
                OpponentLogo,
                Day,
                Node,
                Tier,
                Score
            FROM
                War
            WHERE
                Id = ?
        ';
        $resultSet = $pdo->prepare($query);
        $resultSet->execute([$_GET['id']]);        
        $war = $resultSet->fetch();
        //var_dump($war);
    }
    else   
    {        
        // Edition d'un match en particulier.
        $query =
        '
            UPDATE
                War
            SET
                Us = ?,
                UsLogo = ?,
                Opponent = ?,
                OpponentLogo = ?,
                Day = ?,
                Node = ?,
                Tier = ?,
                Score = ?
            WHERE
                Id = ?
        ';
        $resultSet = $pdo->prepare($query);
        $resultSet->execute([ $_POST['us'], $_POST['us'], $_POST['opponent'], $_POST['opponent'], $_POST['day'], $_POST['node'], $_POST['tier'], $_POST['score'], $_GET['id'] ]);        
        
        // Retour au panneau d'administration des géoconflits.
        header('refresh:0; url=admin_wars.php');
    }

    // Sélection et affichage du template PHTML.
    $template = 'admin_war_edit';
    include 'layout.phtml';
?>