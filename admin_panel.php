<!-- Page de panneau d'administration: -->
<?php require_once 'application/functions.php'; ?>
<?php

    if(getAdmin() == null)
    {        
        // Redirection vers l'acceuil.
        header('Location: index.php');
        exit();
    }
    
    // Sélection et affichage du template PHTML.
    $template = 'admin_panel';
    include 'layout.phtml';
?>