<!-- Page d'administration: édition d'un membre -->
<?php require_once 'application/functions.php'; ?>
<?php
    include 'application/bdd_connection.php';

    if(getAdmin() == null)
    {        
        // Redirection vers l'acceuil.
        header('Location: index.php');
        exit();
    }

    if(empty($_POST['editMember']))
    {       
        // Validation de la query string dans l'URL.
        if(!array_key_exists('id', $_GET) OR !ctype_digit($_GET['id']))
        {
            // Redirection vers l'acceuil.
            header('Location: index.php');
            exit();
        }

        // Récupération d'un membre.
        $query =
        '
            SELECT
                FirstName,
                LastName,
                FamilyName,
                CharacterName,
                CharacterClass,
                CharacterLevel,
                StatusInGuild
            FROM
                Member
            WHERE
                Id = ?
        ';
        $resultSet = $pdo->prepare($query);
        $resultSet->execute([$_GET['id']]);        
        $member = $resultSet->fetch();
        //var_dump($member);
    }
    else   
    {        
        // Edition des informations d'un membre.
        $query =
        '
            UPDATE
                Member
            SET
                FirstName = ?,
                LastName = ?,
                FamilyName = ?,
                CharacterName = ?,
                CharacterClass = ?,
                CharacterLevel = ?,
                StatusInGuild = ?
            WHERE
                Id = ?
        ';
        $resultSet = $pdo->prepare($query);
        $resultSet->execute([ $_POST['firstname'], $_POST['lastname'], $_POST['familyname'], $_POST['charactername'], $_POST['characterclass'], $_POST['characterlevel'], $_POST['statusinguild'], $_GET['id'] ]);           
        
        // Retour au panneau d'administration.
        header('refresh:0; url=admin_members.php');
    }

    // Sélection et affichage du template PHTML.
    $template = 'admin_member_edit';
    include 'layout.phtml';
?>