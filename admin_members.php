<?php require_once 'application/functions.php'; ?>
<!-- Page d'administration: édition/suppression de membres -->
<?php
    include 'application/bdd_connection.php';
    
    if(getAdmin() == null)
    {        
        // Redirection vers l'acceuil.
        header('Location: index.php');
        exit();
    }

    // Récupération de tous membres et de leurs infos.
    $query =
    '
        SELECT * 
        FROM Member
    ';
    $resultSet = $pdo->prepare($query);
    $resultSet->execute();
    $members = $resultSet->fetchAll();
    //var_dump($members);

    // Sélection et affichage du template PHTML.
    $template = 'admin_members';
    include 'layout.phtml';
?>
