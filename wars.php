<!-- Page des géoconflits -->
<?php
    include 'application/bdd_connection.php';

    // Récupération de tous les géoconflits et de leurs infos
    $query =
    '
        SELECT
            * 
        FROM
            War
        ORDER BY
            CreationTimestamp DESC 
    ';
    $resultSet = $pdo->prepare($query);
    $resultSet->execute();
    $wars = $resultSet->fetchAll();
    //var_dump($wars);

    // Sélection et affichage du template PHTML.
    $template = 'wars';
    include 'layout.phtml';
?>
