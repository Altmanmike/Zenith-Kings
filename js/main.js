//'use strict';   // Mode strict du JavaScript

/***********************************************************************************/
/************************* DONNEES DU PROGRAMME PRINCIPAL **************************/
/***********************************************************************************/


/***********************************************************************************/
/************************* FONCTIONS DU PROGRAMME PRINCIPAL ************************/
/***********************************************************************************/


/*--- FONCTIONS GESTION TRI BOUTONS ---*/

function onBTN1Toggle()
{
    var icon;

    // Modification de l'icône du bouton pour inverser l'affichage de la query SQL.    
    icon = document.querySelector('#btn-one i');

    icon.classList.toggle('fa-sort-up');
    icon.classList.toggle('fa-sort-down');
}

function onBTN2Toggle()
{
    var icon;

    // Modification de l'icône du bouton pour inverser l'affichage de la query SQL.    
    icon = document.querySelector('#btn-two i');

    icon.classList.toggle('fa-sort-up');
    icon.classList.toggle('fa-sort-down');
}

function onBTN3Toggle()
{
    var icon;

    // Modification de l'icône du bouton pour inverser l'affichage de la query SQL.    
    icon = document.querySelector('#btn-three i');

    icon.classList.toggle('fa-sort-up');
    icon.classList.toggle('fa-sort-down');
}

/***********************************************************************************/
/*************************** FONCTIONS DU MENU MOBIL FIRST *************************/
/***********************************************************************************/
/*
function onULToggle()
{
	var menu;

	// Afficher/Dérouler le menu mobil first et l'inverse en recliquant.
	menu = document.querySelector('.first');

	menu.classList.toggle('dspl');
}
*/

/***********************************************************************************/
/* ******************************** CODE PRINCIPAL *********************************/
/***********************************************************************************/

btn1 = document.getElementById('btn-one');
btn2 = document.getElementById('btn-two');
btn3 = document.getElementById('btn-three');/*
a1 = document.getElementById('start');*/

btn1.addEventListener('click', onBTN1Toggle);
btn2.addEventListener('click', onBTN2Toggle);
btn3.addEventListener('click', onBTN3Toggle);/*
a1.addEventListener('click', onULToggle);*/