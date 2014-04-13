<?php

/**
 * logout.php
 *
 * @version 1.0
 * @copyright 2008 by ?????? for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
require_once dirname(__FILE__) .'/common.php';

    includeLang('logout');
    
    $parse = array();
    $second = 5; // Nombre de secondes qui doivent s'écouler avant la redirection
    
    $parse['session_close'] = $lang['see_you'];
    $parse['mes_session_close'] = $lang['session_closed'];
    $parse['tps_seconds'] = $second; // On indique au script le nombre de secondes pour le compte à rebours
    
    setcookie($game_config['COOKIE_NAME'], "", time()-100000, "/", "", 0);

    $page = parsetemplate(gettemplate('logout'), $parse);
    
    header("Refresh: ".$second."; Url = login.php");
    
	display( $page, $lang['session_closed'],false);


// -----------------------------------------------------------------------------------------------------------
// History version
//
// 1.0   : Version Originale de ?????? pour Xnova
// 1.1   : Redirection et affichage d'un compte à rebours de Winjet
// 1.11 : Ajout d'un lien pour effectuer la redirection tout de suite 
//          et éviter d'attendre la fin du compte à rebours
?>