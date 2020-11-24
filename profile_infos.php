<!-- Page de profile de membre -->
<?php
    if(session_status() == PHP_SESSION_NONE) {
        // Démarrage du module PHP de gestion des sessions.
        session_start();        
    }
?>
<?php require_once 'application/functions.php'; ?>
<?php
    include 'application/bdd_connection.php';
?>
<!-- Page d'édition de compte -->
<?php

    // initialisation des messages d'erreurs
    $errorUpload = array();

    //var_dump($_SESSION['member']['Id']);
    $memberId = $_SESSION['member']['Id'];

    // Récupération de l'ensemble des infos du compte associé
    $sql = 
    '
        SELECT
            *
        FROM
            Member
        WHERE
            Id = ?
    ';

    $resultSet = $pdo->prepare($sql);
    $resultSet->execute([ $memberId ]);
    $member = $resultSet->fetch();
    //var_dump($member);

    // Champ "characterPic" à remplir correctement
    if(isset($_FILES['characterPic']))
    {
        $file_name = $_FILES['characterPic']['name'];
        $file_size = $_FILES['characterPic']['size'];
        $file_tmp  = $_FILES['characterPic']['tmp_name'];
        $file_type = $_FILES['characterPic']['type'];
        $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        //var_dump("file_name: ".$file_name, "file_size: ".$file_size, "file_tmp: ".$file_tmp, "file_type: ".$file_type, "file_ext: ".$file_ext);

        $extension = "jpg";

        if($file_ext != $extension)
        {
            $errorUpload[] = "extension not allowed, please choose a JPG file.";
        }

        if($file_size > 1048576)
        {
            $errorUpload[] = 'File size must be < 1 Mo';
        }

        if($file_name != ($member['CharacterName']."(".$member['FamilyName'].").jpg")) // ce format aura dû être utilisé CharacterName(FamilyName).jpg 
        {
            $errorUpload[] = 'Your entered a wrong file name.. right format is "CharacterName(FamilyName).jpg"';   
        }

        if(empty($errorUpload) == true)
        {
             move_uploaded_file($file_tmp, "img/members_icons/".$file_name);
             echo "Success <br>";
        }
        else
        {
            printEach($errorUpload);
            unset($errorUpload);
        }

        $characterPic = $file_name;   
    }
    elseif($member['CharacterPic'])
    {
        $characterPic = $member['CharacterPic'];
    }
    else
    {
       $characterPic = "noatm.jpg";
    }


    if(!empty($_POST['editAccount']))   
    {        
        // Champ "firstName" à remplir correctement
        if($_POST['firstname'])
        {
            $firstName = htmlspecialchars(ucfirst(strtolower(trim($_POST['firstname']))));
        }
        else
        {
            $firstName = $member['FirstName'];
        }

        // Champ "lastName" à remplir correctement
        if($_POST['lastname'])
        {
            $lastName = htmlspecialchars(ucfirst(strtolower(trim($_POST['lastname']))));
        }
        else
        {
            $lastName = $member['LastName'];
        }

        // Champ "avatar" à remplir correctement
        if(isset($_POST['avatarRadio']))
        {
            $avatar = htmlspecialchars(ucfirst(strtolower(trim($_POST['avatarRadio']))));
        }
        else
        {
            $avatar = $member['Avatar'];
        }

        // Champ "familyName" à remplir correctement
        if($_POST['familyname'] && preg_match('/^[a-zA-Z0-9_]+$/', $_POST['familyname'])) // en coordination avec les caractères possibles dans BDO
        {
            $familyName = htmlspecialchars(ucfirst(trim($_POST['familyname']))); 
        }
        else
        {
            $familyName = $member['FamilyName'];
        }

        // Champ "characterName" à remplir correctement
        if($_POST['charactername'] && preg_match('/^[a-zA-Z0-9_]+$/', $_POST['charactername']) ) // en coordination avec les caractères possibles dans BDO
        {
            $characterName = htmlspecialchars(ucfirst(trim($_POST['charactername'])));
        }
        else
        {
            $characterName = $member['CharacterName'];
        }

        // Champ "characterClass" à remplir correctement
        if($_POST['characterclass'])
        {
            $characterClass = $_POST['characterclass']; // pas besoin d'htmlspecialchars normalement sur un select
        }
        else
        {
            $characterClass = $member['CharacterClass'];
        }

        // Champ "characterLevel" à remplir correctement
        if($_POST['characterlevel'])
        {
            $characterLevel = $_POST['characterlevel']; // idem
        }
        else
        {
            $characterLevel = $member['CharacterLevel'];
        }

        // Champ "statusInGuild" à remplir correctement
        if($_POST['statusinguild'])
        {
            $statusInGuild = $_POST['statusinguild']; // idem
        }
        else
        {
            $statusInGuild = $member['StatusInGuild'];
        }

        // Champ "email" à remplir correctement
        if($_POST['email'] && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {
            $email = htmlspecialchars(strtolower(trim($_POST['email'])));            
        }
        else
        {
            $email = $member['Email'];
        }

        // Champ "password" à remplir correctement
        if($_POST['password'] && preg_match('/^[a-zA-Z0-9_]+$/', $_POST['password'])) 
        {                    
            // Encrytage/Hashage du mot de passe
            $salt = '$2y$11$'.substr(bin2hex(openssl_random_pseudo_bytes(32)), 0, 22);
            $cryptPass = crypt(htmlspecialchars(trim($_POST['password'])), $salt);
        }
        else
        {
            $cryptPass = $member['Password'];
        }        

        // Champs "birthDate" à remplir correctement
        //
        if($_POST['birthyear'])
        {
            $birthYear = $_POST['birthyear'];
        }
        else
        {
            $birthYear = substr($member['BirthDate'], 0, 4);
        }

        if($_POST['birthmonth'] )
        {
            $birthMonth = $_POST['birthmonth'];
        }
        else
        {
            $birthMonth = substr($member['BirthDate'], 5, 2);
        }

        if($_POST['birthday'])
        {
            $birthDay = $_POST['birthday'];
        }
        else
        {
            $birthDay = substr($member['BirthDate'], 8, 2);
        }
        // attention concatenation des valeurs pour le format de la date
        $birthDate = $birthYear.'-'.$birthMonth.'-'.$birthDay;

        // Champ "address" à remplir correctement
        if($_POST['address'] && strlen($_POST['address']) < 251) 
        {
            $address = htmlspecialchars(ucfirst(strtolower($_POST['address'])));                
        }
        else
        {
            $address = $member['Address'];
        }

        // Champ "city" à remplir correctement
        if($_POST['city'] && preg_match('/^[a-zA-Z]+$/', $_POST['city']) && (strlen($_POST['city']) < 41))
        {
            $city = htmlspecialchars(ucfirst(strtolower(trim($_POST['city']))));
        }        
        else
        {
            $city = $member['City'];
        }

        // Champ "country" à remplir correctement
        if($_POST['country'] && preg_match('/^[a-zA-Z]+$/', $_POST['country']) && (strlen($_POST['country']) < 41))
        {
            $country = htmlspecialchars(ucfirst(strtolower(trim($_POST['country']))));
        }        
        else
        {
            $country = $member['Country'];
        }

        // Champ "zipCode" à remplir correctement
        if($_POST['zipcode'] && preg_match('/^[0-9]+$/', $_POST['zipcode']) && (strlen($_POST['zipcode']) < 6))
        {
            $zipCode = htmlspecialchars(trim($_POST['zipcode']));
        }        
        else
        {
            $zipCode = $member['ZipCode'];
        }

        // Champ "phone" à remplir correctement
        if($_POST['phone'] && preg_match('/^[0-9]+$/', $_POST['phone']) && (strlen($_POST['phone']) < 11))
        {
            $phone = htmlspecialchars(trim($_POST['phone']));
        }
        else
        {
            $phone = $member['Phone'];
        }        

        // Edition des ses informations.
        $query =
        '
            UPDATE
                Member
            SET
                FirstName = ?,
                LastName = ?,
                Avatar = ?,
                FamilyName = ?,
                CharacterName = ?,
                CharacterClass = ?,
                CharacterPic = ?,
                CharacterLevel = ?,
                StatusInGuild = ?,
                Email = ?,             
                Password = ?,
                BirthDate = ?,
                Address = ?,
                City = ?,
                Country = ?,
                ZipCode = ?,
                Phone = ?
            WHERE
                Id = ?
        ';
        $resultSet = $pdo->prepare($query);
        $resultSet->execute([ $firstName, $lastName, $avatar, $familyName, $characterName, $characterClass, $characterPic, $characterLevel, $statusInGuild, $email, $cryptPass, $birthDate, $address, $city, $country, $zipCode, $phone, $memberId ]);        

        // On reste sur la page d'édition.
        header('refresh:0; url=profile_infos.php');        
    }

    // Sélection et affichage du template PHTML.
    $template = 'profile_infos';
    include 'layout.phtml';
?>