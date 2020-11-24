<!-- Page d'accueil du site web -->
<?php
    if(session_status() == PHP_SESSION_NONE)
    {
        // Démarrage du module PHP de gestion des sessions.
        session_start();
        //$_SESSION['member'] = FALSE;
    }

    include 'application/bdd_connection.php';

    //  Sélection de la catégorie des articles à afficher via boutons href
    // et dont le nombre d'articles affichés est limité par page.
   
    if(empty($_GET['category']))
    {
        $inner_join_and_where = "";
        $where_category_name = ""; 
    }       
    elseif(($_GET['category'] === 'BDO'))
    {
        // Récupération de tous les articles du blog classés par ordre antéchronologique
        // issue de la catégorie "Black Desert Online"
        $inner_join_and_where = "INNER JOIN Category ON Post.Category_Id = Category.Id WHERE Category.Name = 'Black Desert Online'";
        $where_category_name = "WHERE Category.Name = 'Black Desert Online'";
    }
    elseif(($_GET['category'] == 'ENHANCING'))
    {
        // Récupération de tous les articles du blog classés par ordre antéchronologique
        // issue de la catégorie "Enhancing"
        $inner_join_and_where = "INNER JOIN Category ON Post.Category_Id = Category.Id WHERE Category.Name = 'Enhancing'";
        $where_category_name = "WHERE Category.Name = 'Enhancing'";
    }
    elseif(($_GET['category'] == 'EVENT'))
    {        
        // Récupération de tous les articles du blog classés par ordre antéchronologique
        // issue de la catégorie "Event"
        $inner_join_and_where = "INNER JOIN Category ON Post.Category_Id = Category.Id WHERE Category.Name = 'Event'";
        $where_category_name = "WHERE Category.Name = 'Event'";      
    }
    elseif(($_GET['category'] == 'TOURNAMENT'))
    {
        // Récupération de tous les articles du blog classés par ordre antéchronologique 
        // issue de la catégorie "Tournament"
        $inner_join_and_where = "INNER JOIN Category ON Post.Category_Id = Category.Id WHERE Category.Name = 'Tournament'";
        $where_category_name = "WHERE Category.Name = 'Tournament'";
    }
    elseif(($_GET['category'] == 'ALL'))
    {
        // Récupération de tous les articles du blog classés par ordre antéchronologique 
        // issue de toutes les catégories, comme par défaut
        $inner_join_and_where = "";
        $where_category_name = "";        
    }

    // Pagination: issue de chacunes des catégories.
    // Récupération du nombre total d'articles dans la bdd.
    $sqlPages = 
    '
        SELECT Post.Id
        AS countPosts
        FROM Post
        '.$inner_join_and_where
    ;

    $query = $pdo->prepare($sqlPages);
    $query->execute();
    $countPosts = $query->rowCount();

    // D'après l'allure du site web et de la taille d'un article, on imposera 4 articles maximum par pages.
    $limit = 4;
    // Calcul du nombre de pages nécessaires en fonction du nombre total d'articles + limitation par page.
    $nbPages = ceil($countPosts/$limit);            

    if( isset($_GET['page']) && !empty($_GET['page']) && ctype_digit($_GET['page']) && ($_GET['page'] > 0) && ($_GET['page'] <= $nbPages) )
    {
        $currentPage = intval($_GET['page']);
    }
    else {
        $currentPage = 1;
    }
    // Pagination: fin calcul

    // Requête SQL à founir pour l'affichage des articles
    // en fonction de leur catégorie respective ou pas.
    $sql = 
    '   
        SELECT
            Post.Id,
            Category.Name,
            Title,
            Picture,
            Contents,
            Post.CreationTimestamp,
            FamilyName,
            CharacterName
        FROM
            Post
        INNER JOIN
            Member
        ON
            Post.Member_Id = Member.Id
        INNER JOIN
            Category
        ON
            Post.Category_Id = Category.Id
        '.$where_category_name.'
        ORDER BY
            Post.CreationTimestamp DESC LIMIT '.(($currentPage - 1) * $limit).','.$limit
    ; 

    $query = $pdo->prepare($sql);
    $query->execute(); 
    $postLimits = $query->fetchAll();
    //var_dump($postLimits);

    // Sélection et affichage du template PHTML.
    $template = 'index';
    include 'layout.phtml';
?>