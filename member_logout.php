<?php require_once 'application/functions.php'; ?>
<!-- Page de déconnexion de compte -->

<!-- DISCONNECTION PAGE -->
<?php
    // Destruction de l'ensemble de la session (cs header.php)
    $_SESSION = array();
    session_destroy();

    $successMessage = "You are successfully disconnected.";    
    //var_dump($_SESSION);

    // Sélection et affichage du template PHTML.
    $template = 'member_logout';
    include 'layout.phtml';

    // Retour à la page d'accueil une fois déconnecté.
    header('refresh:4; url=index.php');
?>

<!-- END DISCONNECTION PAGE -->