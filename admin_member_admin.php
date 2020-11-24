<!-- Page d'administration: édition statut ADMIN des membres -->
<?php require_once 'application/functions.php'; ?>
<?php
    include 'application/bdd_connection.php';

    if(getAdmin() == null)
    {        
        // Redirection vers l'acceuil.
        header('Location: index.php');
        exit();
    }

    if(!isset($_GET['id']) OR !ctype_digit($_GET['id']))
    {
        // Redirection vers le panneau d'administration de la liste des membres.
        header('refresh:0; url=admin_members.php');  
    }
    else
    {
        $query = 
        '
            SELECT Admin
            FROM Member
            WHERE Id = ?
        ';
        $resultSet = $pdo->prepare($query);
        $resultSet->execute([ $_GET['id'] ]);
        $member = $resultSet->fetch();
        $admin = $member['Admin'];
        //var_dump($admin);
        
        if(isset($admin))
        {
            if($admin == 0)
            {
                $admin = 1;
            }
            else
            {
                $admin = 0;
            }   

            // Récupération de 
            $query =
            '
                UPDATE Member 
                SET Admin = '.$admin.'
                WHERE Id = ?
            ';

            $resultSet = $pdo->prepare($query);
            $resultSet->execute([ $_GET['id'] ]);
            
            // Redirection vers le panneau d'administration de la liste des membres.
            header('refresh:0; url=admin_members.php');
        }
    }
?>