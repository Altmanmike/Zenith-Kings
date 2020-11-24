<!-- Page des membres -->
<?php
    include 'application/bdd_connection.php';    

    // Gestion de l'affichage des données avec boutons
    if(isset($_GET['btn1']))
    {
        if($_GET['btn1'] == 'ASC') //$_GET['btn1'] == 'ASC'
        {
            $query1 = 'SELECT * FROM Member ORDER BY CharacterLevel ASC';
            $sort = "DESC";
        }
        else
        {
            $query1 = 'SELECT * FROM Member ORDER BY CharacterLevel DESC';
            $sort = "ASC";
        }
        
        //var_dump($_GET['btn1'], $query1);
        $resultSet = $pdo->prepare($query1);        
    }
    elseif(isset($_GET['btn2']))
    {
        if($_GET['btn2'] == 'ASC')
        {            
            $query2 = 'SELECT * FROM Member ORDER BY StatusInGuild ASC';
            $sort = "DESC";
        }
        else
        {
            $query2 = 'SELECT * FROM Member ORDER BY StatusInGuild DESC';
            $sort = "ASC";
        }        
        
        //var_dump($_GET['btn2'], $query2);
        $resultSet = $pdo->prepare($query2);
    }
    elseif(isset($_GET['btn3']))
    {
        if($_GET['btn3'] == 'ASC')
        {
            $query3 = 'SELECT * FROM Member ORDER BY CharacterClass ASC';
            $sort = "DESC";
        }
        else
        {
            $query3 = 'SELECT * FROM Member ORDER BY CharacterClass DESC';
            $sort = "ASC";
        }
        
        //var_dump($_GET['btn3'], $query3);
        $resultSet = $pdo->prepare($query3);
    }
    else
    {
        $sort = "ASC";
        
        // Récupération de tous membres et de leurs infos.
        $query =
        '
            SELECT
                * 
            FROM
                Member
            ORDER BY
                CreationTimestamp ASC 
        ';
        $resultSet = $pdo->prepare($query);
    }

    $resultSet->execute();
    $members = $resultSet->fetchAll();
    //var_dump($members);

    // Sélection et affichage du template PHTML.
    $template = 'members';
    include 'layout.phtml';
?>
