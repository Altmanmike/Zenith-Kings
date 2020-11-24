<?php require_once 'application/functions.php'; ?>
<!-- Page de connexion de compte -->
<?php
	// Vérifions si l'utilisateur est encore connecté
	if(isAuth())
	{
        // Redirection vers la page d'acceuil.
        header('refresh:0; url=index.php');       
	}

    // initialisation des messages d'erreurs
    $errorMessage = array();
    $successMessage = "";

    include 'application/bdd_connection.php';

	// Définition et initialisation des variables 
	$email = "";
	$password = "";
	
	// Traitement des données du formulaire lors de la soumission du formulaire
	if(isset($_POST['loginMember'])) //$_SERVER["REQUEST_METHOD"] == "POST"
	{ 
	    // Vérifions si le champ email a bien été rempli
	    if(empty(trim($_POST['email'])))
	    {
	        $errorMessage['email'] = "Please enter your email";            
	    }
	    else
	    {
	        $email = htmlspecialchars(trim($_POST['email']));
	    }
	    
	    // Vérifions si le champ password a bien été rempli
	    if(empty($_POST['password']))
	    {
	        $errorMessage['password'] = "Please enter your password";
	    }
	    else
	    {
	        $password = htmlspecialchars(trim($_POST['password']));
	    }
	    
	    // Validation des identifiants.
	    if(empty($errorMessage))
	    {
	        // Récupération du compte associé.
	        $query = 
            '
                SELECT
                    *
                FROM
                    Member
                WHERE
                    email = :email
            ';
	        
	        if($resultSet = $pdo->prepare($query))
	        {
	            // Bind du paramètre de la requête.
	            $resultSet->bindParam(":email", $param_email, PDO::PARAM_STR);
	            
	            // Paramètre.
	            $param_email = htmlspecialchars(trim($_POST['email']));
	            
	            // Exécution de la requête préparée.
	            if($resultSet->execute())
	            {
	                // Vérification de l'existence du mail dans la base, si oui vérifions le mot de passe..
	                if($resultSet->rowCount() == 1)
	                {
	                    if($row = $resultSet->fetch())
	                    {
	                        //var_dump($row);
	                        $memberId   = $row['Id'];
	                        $email      = $row['Email'];
	                        $hashed_password = $row['Password'];
	                        $firstName  = $row['FirstName'];
	                        $lastName   = $row['LastName'];
	                        $admin      = $row['Admin'];

	                        if(password_verify($password, $hashed_password))
	                        {	                            
	                            // Assignation des données aux variables de session.
	                            $_SESSION['member'] = Array (
	                                'Id' => $memberId,
	                                'FirstName' => $firstName,
	                                'LastName' => $lastName,
	                                'Email' => $email,
	                                'Admin' => $admin
	                            );                        

	                            // Mise à jour de date de dernière connexion.
	                            $query = 
                                '
                                    UPDATE Member
                                    SET LastLoginTimestamp = :lastLoginTimestamp                                            
                                    WHERE Id = :memberId
                                ';

	                            $resultSet = $pdo->prepare($query);

	                            // Bind des paramètre de la requête
	                            $resultSet->bindParam(":lastLoginTimestamp", $param_lastLogin, PDO::PARAM_STR);
	                            $resultSet->bindParam(":memberId", $param_memberId, PDO::PARAM_INT);

	                            // Paramètres
	                            $param_lastLogin = date("Y-m-d H:i:s");
	                            $param_memberId = $memberId;                            

	                            // Exécution de la requête préparée
	                            $resultSet->execute();
                                
                                $successMessage = "You are connected";
                                //printSuc($successMessage);
                                
	                            // Redirection vers la page d'accueil.
                                header('refresh:2; url=index.php');                                
	                        }
	                        else
	                        {
	                            // Message d'erreur si le mot de passe entré n'est pas valide.
	                            $errorMessage['password'] = "The password you entered was not valid";
	                        }
	                    }
	                }
	                else
	                {
	                    // Message d'erreur si l'email entrée n'existe pas dans la bdd.
	                    $errorMessage['email'] = "No account found with this email";
	                }
	            }
	            else
	            {
	                // Ou bien..
	                $errorMessage['fatal'] = "Aïe! Something happened. Please retry later..";
	            }
	        }	        
	    }
        //printEach($errorMessage);        
	}

    // Sélection et affichage du template PHTML.
    $template = 'member_login';
    include 'layout.phtml';
?>