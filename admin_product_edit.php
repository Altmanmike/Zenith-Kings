<!-- Page d'administration: édition d'un produit du catalogue (infos et image) -->
<?php require_once 'application/functions.php'; ?>
<?php

    if(getAdmin() == null)
    {        
        // Redirection vers l'acceuil.
        header('Location: index.php');
        exit();
    }

    // initialisation des messages d'erreurs
    $errorMessage = array();    
    $successMessage = "";

    include 'application/bdd_connection.php';

    if(empty($_POST['editProduct']))
    {        
        // Validation de la query string dans l'URL.
        if(!array_key_exists('id', $_GET) OR !ctype_digit($_GET['id']))
        {
            header('Location: index.php');
            exit();
        }

        // Récupération des informations d'un produit en particulier..
        $query =
        '
            SELECT
                *
            FROM
                Product
            WHERE
                Id = ?
        ';
        $resultSet = $pdo->prepare($query);
        $resultSet->execute([$_GET['id']]);        
        $product = $resultSet->fetch();
        //var_dump($product);
    }
    else   
    {
        // Champ "Picture" à remplir correctement
        if(isset($_FILES['picture']))
        {                                       
            $file_name = $_FILES['picture']['name'];
            $file_size = $_FILES['picture']['size'];
            $file_tmp  = $_FILES['picture']['tmp_name'];
            $file_type = $_FILES['picture']['type'];
            //$file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            list($width, $height, $type, $attr) = getimagesize($file_tmp);                           

            if(file_exists("img/products/".$file_name))
            {
                $productPic = $file_name; 
            }

            //$extension = 'png';

            if($file_type != 'image/png')  // $file_ext != $extension
            {
                $errorMessage[] = 'extension not allowed, please choose a PNG file.';
            }

            if($file_size > 25000000)
            {
                $errorMessage[] = 'File size must be < 250 ko';
            }

            if(($width > 420 ) && ($height > 420))
            {
                $errorMessage[] = 'File pixels width x height must be < 420 x 420';    
            }

            if(empty($errorMessage) == true)
            {
                move_uploaded_file($file_tmp, "img/products/".$file_name);                
            }

            $productPic = $file_name;                          
        }
        else
        {
            $productPic = $post['Picture'];
        }
        
        // Edition d'un produit en particulier.
        $query =
        '
            UPDATE
                Product
            SET
                Name = ?,
                Photo = ?,
                Description = ?,
                QuantityInStock = ?,
                BuyPrice = ?,
                SalePrice = ?
            WHERE
                Id = ?
        ';
        $resultSet = $pdo->prepare($query);
        $resultSet->execute([ $_POST['name'], $productPic, $_POST['description'], $_POST['quantityInStock'], $_POST['buyPrice'], $_POST['salePrice'], $_GET['id'] ]);        
        
        $successMessage = "Les informations du produit n°".$_GET['id']." ont bien été mises à jour.";
        
        // Retour à la page d'administration des produits une fois que le nouveau produit a été édité.
        //header('Location: admin_products.php');
        //exit();
        header('refresh:3; url=admin_products.php');
    }

    // Sélection et affichage du template PHTML.
    $template = 'admin_product_edit';
    include 'layout.phtml';
?>