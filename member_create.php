<?php require_once 'application/functions.php'; ?>
<!-- Page de création de compte --> 
<?php
    // initialisation des messages d'erreurs
    $errorMessage = array();
    $successMessage = "";

    include 'application/bdd_connection.php';

    if(!empty($_POST['createMember']))
    {        
        // Champ "firstName" à remplir correctement
        if(empty($_POST['firstname']))
        {
            $errorMessage['firstname'] = "Please enter your firstname in the field";
        }
        else 
        {
            $firstName = htmlspecialchars(ucfirst(strtolower(trim($_POST['firstname']))));
        }
        
        // Champ "lastName" à remplir correctement
        if(empty($_POST['lastname']))
        {
            $errorMessage['lastname'] = "Please enter your lastname in the field";
        }
        else 
        {
            $lastName = htmlspecialchars(ucfirst(strtolower(trim($_POST['lastname']))));
        }
                
        // Champ "familyName" à remplir correctement
        if(empty($_POST['familyname']) || !preg_match('/^[a-zA-Z0-9]+$/', $_POST['familyname'])) // en coordination avec les caractères possibles dans BDO
        {
            $errorMessage['familyname'] = "Please enter a valid familyname in the field"; 
        }
        else 
        {
            $familyName = htmlspecialchars(ucfirst(trim($_POST['familyname'])));
            
             // Vérifions s'il y a un utilisateur avec l'adresse e-mail spécifiée.
            $query =
            '
                SELECT
                    Id
                FROM
                    Member
                WHERE
                    FamilyName = ?
            ';          
            
            $resultSet = $pdo->prepare($query);    
            $resultSet->execute([$familyName]);
            $member = $resultSet->fetch();
            //var_dump($member);

            // Est-ce qu'on a bien trouvé un utilisateur ?
            if(empty($member) == false)
            {
                $errorMessage['familyname'] = "FamilyName already used by a bdo player & zk member";
                //printErr($errorMessage['familyName']);

                // Go à la page de connection si le compte a déjà été crée.
                header('refresh:4; url=member_login.php');                
            }
        }
        
        // Champ "characterName" à remplir correctement
        if(empty($_POST['charactername']) || !preg_match('/^[a-zA-Z0-9]+$/', $_POST['charactername'])) // en coordination avec les caractères possibles dans BDO
        {
            $errorMessage['charactername'] = "Please enter a valid characterName in the field"; 
        }
        else 
        {
            $characterName = htmlspecialchars(ucfirst(trim($_POST['charactername'])));           
            
            // Vérifions s'il y a un utilisateur avec l'adresse e-mail spécifiée.
            $query =
            '
                SELECT Id
                FROM Member
                WHERE CharacterName = ?
            ';          
            
            $resultSet = $pdo->prepare($query);    
            $resultSet->execute([$characterName]);
            $member = $resultSet->fetch();
            //var_dump($member);

            // Est-ce qu'on a bien trouvé un utilisateur ?
            if(empty($member) == false)
            {
                $errorMessage['charactername'] = "CharacterName already used by a bdo player & zk member";
                //printErr($errorMessage['characterName']);

                // Go à la page de connection si le compte a déjà été crée.
                header('refresh:4; url=member_login.php');                
            }
        }
        
        // Champ "characterClass" à remplir correctement
        if(empty($_POST['characterclass']))
        {
            $errorMessage['characterclass'] = "Please choose your characterClass!";
        }
        else
        {
            $characterClass = $_POST['characterclass']; // pas besoin d'htmlspecialchars normalement sur un select
        }
        
        // Champ "characterLevel" à remplir correctement
        if(empty($_POST['characterlevel']))
        {
            $errorMessage['characterlevel'] = "Please select your characterLevel!";
        }
        else
        {
            $characterLevel = $_POST['characterlevel']; // idem
        }
        
        // Champ "statusInGuild" à remplir correctement
        if(empty($_POST['statusinguild']))
        {
            $errorMessage['statusinguild'] = "Please select your statusInGuild!";
        }
        else
        {
            $statusInGuild = $_POST['statusinguild']; // idem
        }
        
        // Champ "email" à remplir correctement
        if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {
            $errorMessage['email'] = "Please enter a valid email";
        }
        else
        {
            $email = htmlspecialchars(strtolower(trim($_POST['email'])));
            
            // Vérifions s'il y a un utilisateur avec l'adresse e-mail spécifiée.
            $query =
            '
                SELECT Id
                FROM Member
                WHERE Email = ?
            ';          
            
            $resultSet = $pdo->prepare($query);    
            $resultSet->execute([$email]);
            $member = $resultSet->fetch();
            //var_dump($member);

            // Est-ce qu'on a bien trouvé un utilisateur ?
            if(empty($member) == false)
            {
                $errorMessage['email'] = "Email already used";
                //printErr($errorMessage['email']);

                // Go à la page de connection si le compte a déjà été crée.
                header('refresh:4; url=member_login.php');                                   
            }
        }
        
        // Champ "password" à remplir correctement
        if(empty($_POST['password']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['password'])) 
        {
            $errorMessage['password'] = "Please enter a valid password in the field"; 
        }
        else
        {                    
            // Encrytage/Hashage du mot de passe
            $salt = '$2y$11$'.substr(bin2hex(openssl_random_pseudo_bytes(32)), 0, 22);
            $cryptPass = crypt(htmlspecialchars(trim($_POST['password'])), $salt);
        }

        // Champs "birthDate" à remplir correctement
        if(empty($_POST['birthyear'] || $_POST['birthmonth'] || $_POST['birthday']))
        {
            $errorMessage['birthdate'] = "Please choose your birth date..";
        }
        else
        {
            $birthDate = $_POST['birthyear'].'-'.$_POST['birthmonth'].'-'.$_POST['birthday'];
        }
        
        // Champ "address" à remplir correctement
        if(empty($_POST['address']))
        {
            $errorMessage['address'] = "Please enter your address in the field";
        }
        elseif(strlen($_POST['address']) > 150)
        {
            $errorMessage['address'] = "Your address is too long..";
        }
        else
        {
            $address = htmlspecialchars(ucfirst(strtolower($_POST['address'])));
        }
        
        // Champ "city" à remplir correctement
        if(empty($_POST['city']) || !preg_match('/^[a-zA-Z]+$/', $_POST['city']))
        {
            $errorMessage['city'] = "Please enter your city in the field";
        }
        elseif(strlen($_POST['city']) > 40)
        {
            $errorMessage['city'] = "Your city is too long..";
        }
        else
        {
            $city = htmlspecialchars(ucfirst(strtolower(trim($_POST['city']))));
        }
        
        // Champ "zipCode" à remplir correctement
        if(empty($_POST['zipcode']) || !preg_match('/^[0-9]+$/', $_POST['zipcode']))
        {
            $errorMessage['zipcode'] = "Please enter your zipCode in the field";
        }
        else
        {
            $zipCode = htmlspecialchars(trim($_POST['zipcode']));
        }
        
        // Champ "country" à remplir correctement
        if(empty($_POST['country']) || !preg_match('/^[a-zA-Z]+$/', $_POST['country']))
        {
            $errorMessage['country'] = "Please enter a valid country name in the field";
        }
        else
        {
            $country = htmlspecialchars(ucfirst(strtolower(trim($_POST['country']))));
        }
        
        // Champ "phone" à remplir correctement
        if(empty($_POST['phone']) || !preg_match('/^[0-9]+$/', $_POST['phone']))
        {
            $errorMessage['phone'] = "Please enter a valid phone number in the field";
        }
        elseif(strlen($_POST['phone']) > 10)
        {
            $errorMessage['phone'] = "Your phone number is too long";
        }
        else
        {
            $phone = htmlspecialchars(trim($_POST['phone']));
        }
        
        if(!empty($errorMessage))
        {
            printEach($errorMessage);
            unset($member);
        }
        else
        {
            // Requête d'ajout d'utilisateur à la bdd
            $query = "INSERT INTO Member
                (           
                    FirstName,
                    LastName,
                    FamilyName,
                    CharacterName,
                    CharacterClass,
                    CharacterLevel,
                    StatusInGuild,
                    Email,
                    Password,
                    BirthDate,
                    CreationTimestamp,
                    Address,
                    City,
                    Country,
                    ZipCode,
                    Phone,
                    Admin
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?, 0)";

            // Ajout par la requête
            $resultSet = $pdo->prepare($query);

            $resultSet->execute([
                $firstName,
                $lastName,
                $familyName,
                $characterName,
                $characterClass,
                $characterLevel,
                $statusInGuild,
                $email,
                $cryptPass,
                $birthDate,
                $address,
                $city,
                $country,
                $zipCode,
                $phone
            ]);

            $successMessage = "Your account has just been created with that email";
            printSuc($successMessage);

            // Go à la page de connection une fois le nouveau membre ajouté.
            header('refresh:4; url=member_login.php');            
        }
    }

    // Sélection et affichage du template PHTML.
    $template = 'member_create';
    include 'layout.phtml';
?>