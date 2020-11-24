<?php
	//	Connexion à la base de données
	$pdo = new PDO
	(
		'mysql:host=xxxxxxx;dbname=xxxxxx;charset=UTF8',
		'',
		'',
	    [
	    	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	    ]
    );