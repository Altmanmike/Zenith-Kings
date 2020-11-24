<!-- Page d'administration: ajout d'un nouveau produit dans la base de données -->
<?php require_once 'application/functions.php'; ?>
<?php

    if(getAdmin() == null)
    {        
        // Redirection vers l'acceuil.
        header('Location: index.php');
        exit();
    }

    include 'application/bdd_connection.php';

    // initialisation des messages d'erreurs.
    $errorMessage = array();    
    $successMessage = "";

    if(isset($_FILES['addPhoto']))
    {
        $file_name = $_FILES['addPhoto']['name'];
        $file_size = $_FILES['addPhoto']['size'];
        $file_tmp  = $_FILES['addPhoto']['tmp_name'];
        $file_type = $_FILES['addPhoto']['type'];
        $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        list($width, $height, $type, $attr) = getimagesize($file_tmp);
        
        if(file_exists("img/products/".$file_name))
        {
            $productPic = $file_name; 
        }
        
        $extension = "png";

        if($file_ext != $extension)
        {
            $errorMessage[] = "extension not allowed, please choose a PNG file.";
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
        $productPic = "";
    }

    if(isset($_POST['addProduct']) && empty($errorMessage))
    {        
        // Ajout d'un nouveau produit de la liste du catalogue.
        $query =
        '
            INSERT INTO
                Product
                (Name, Photo, Description, QuantityInStock, BuyPrice, SalePrice)
            VALUES
                (?, ?, ?, ?, ?, ?)
        ';
        $resultSet = $pdo->prepare($query);
        $resultSet->execute([ $_POST['name'], $productPic, $_POST['description'], $_POST['quantityInStock'], $_POST['buyPrice'], $_POST['salePrice'] ]);

        $successMessage = "Le produit a bien été ajouté à notre catalogue!";        

        // Retour à la page d'administration des produits une fois que le nouveau produit a été ajouté.
        header('refresh:5; url=admin_products.php');
    }

    // Sélection et affichage du template PHTML.
    $template = 'admin_product_add';
    include 'layout.phtml';
?>