<?php
    if(session_status() == PHP_SESSION_NONE) {
        // Démarrage du module PHP de gestion des sessions.
        session_start();        
    }

// Ensemble des fonctions utiles

// GESTION DES ERREURS OU DES SUCCES
function printErr($variable)
{
    echo '<p class="danger">' . $variable . '</p><br>';    
}

function printEach($variable)
{
    foreach($variable as $key => $value):
    {
        printErr($variable[$key]);                  
    }
    endforeach;    
}

function printSuc($variable)
{
    echo '<p class="bravo">' . $variable . '</p><br>';    
}

// GESTION DES STATUTS DES MEMBRES 
function isAuth()
{
    if(array_key_exists('member', $_SESSION) == true)
    {
        if($_SESSION['member'] == 33)
        {
            return 33;
        }
        elseif (empty($_SESSION['member']) == false) {
            return true;
        }
    }
    return false;
}

function getAdmin()
{
    if(isAuth() == false) {
        return null;
    }
    return $_SESSION['member']['Admin'];
}

// GESTION DES PRIX ET DES ARRONDIS
function floordec($price, $decimals=2)
{    
    return floor($price*pow(10,$decimals))/pow(10,$decimals);
}
