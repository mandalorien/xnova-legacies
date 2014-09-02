<?php
/**
 * This file is part of XNova:Legacies
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @see http://www.xnova-ng.org/
 *
 * Copyright (c) 2009-Present, XNova Support Team <http://www.xnova-ng.org>
 * All rights reserved.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *                                --> NOTICE <--
 *  This file is part of the core development branch, changing its contents will
 * make you unable to use the automatic updates manager. Please refer to the
 * documentation for further information about customizing XNova.
 *
 */

session_start();
ini_set('display_errors', false);
ini_set('date.timezone','Europe/Paris'); # fuseau horaire de paris

define('ROOT_PATH', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
define('PHPEXT', require 'extension.inc');

define('VERSION', '2009.2.1');

$RequestUrl = substr($_SERVER['REQUEST_URI'], 0);
$fragment = explode ("/",$RequestUrl);
$var = count($fragment);
unset($fragment[intval(0)]);
unset($fragment[intval($var - 1)]);
if(defined('IN_ADMIN'))
{
	if($_SERVER['HTTP_HOST'] == "127.0.0.1" || $_SERVER['HTTP_HOST'] == "localhost"){
		unset($fragment[intval(2)]); # on enleve /admin/
	}else{
		unset($fragment[intval($var - 2)]); # on enleve /admin/
	}
}
$baseUrl = implode("/",$fragment);

if($_SERVER['HTTP_HOST'] == "127.0.0.1" || $_SERVER['HTTP_HOST'] == "localhost"){
	define("WEB_URL","http://".$_SERVER['HTTP_HOST'] ."/".$baseUrl."/");
}else{
	define("WEB_URL","http://".$_SERVER['HTTP_HOST'] ."/".$baseUrl."/");
}

if (0 === filesize(ROOT_PATH . 'config.php') /*&& !defined('IN_INSTALL')*/) {
    header('Location: install/');
    die();
}

/*include(ROOT_PATH . 'github.class.' . PHPEXT);
$github = new github();
$fil = $github->Rootfile(dirname(__FILE__));
var_dump($fil);*/
$game_config   = array();
$user          = array();
$lang          = array();
$IsUserChecked = false;

define('DEFAULT_SKINPATH','skins/xnova/');
define('TEMPLATE_DIR', realpath(ROOT_PATH . '/templates/'));
define('TEMPLATE_NAME', 'OpenGame');
define('DEFAULT_LANG', 'fr');

include(ROOT_PATH . 'includes/debug.class.'.PHPEXT);
$debug = new Debug();

include(ROOT_PATH . 'includes/constants.' . PHPEXT);
include(ROOT_PATH . 'includes/functions.' . PHPEXT);
include(ROOT_PATH . 'includes/unlocalised.' . PHPEXT);
include(ROOT_PATH . 'includes/todofleetcontrol.' . PHPEXT);
include(ROOT_PATH . 'language/' . DEFAULT_LANG . '/lang_info.cfg');
include(ROOT_PATH . 'includes/vars.' . PHPEXT);
include(ROOT_PATH . 'includes/db.' . PHPEXT);
include(ROOT_PATH . 'includes/strings.' . PHPEXT);

$query = doquery('SELECT * FROM {{table}}', 'config');
while($row = mysql_fetch_assoc($query)) {
    $game_config[$row['config_name']] = $row['config_value'];
}

if (!defined('DISABLE_IDENTITY_CHECK')) {
    $Result        = CheckTheUser ( $IsUserChecked );
    $IsUserChecked = $Result['state'];
    $user          = $Result['record'];
} else if (!defined('DISABLE_IDENTITY_CHECK') && $game_config['game_disable'] && $user['authlevel'] < 1) {
    message(stripslashes($game_config['close_reason']), $game_config['game_name']);
}

includeLang('system');
includeLang('tech');

if (empty($user) && !defined('DISABLE_IDENTITY_CHECK')) {
    $parse = array();
    $Logout = parsetemplate(gettemplate('redirect_login'), $parse);
    display($Logout, 'Deconnexion');
}
$_fleets = doquery('SELECT * FROM {{table}} WHERE `fleet_start_time` <= UNIX_TIMESTAMP()', 'fleets'); //  OR fleet_end_time <= ".time()
while ($row = mysql_fetch_array($_fleets)) {
    $array                = array();
    $array['galaxy']      = $row['fleet_start_galaxy'];
    $array['system']      = $row['fleet_start_system'];
    $array['planet']      = $row['fleet_start_planet'];
    $array['planet_type'] = $row['fleet_start_type'];

    $temp = FlyingFleetHandler($array);
}

$_fleets = doquery('SELECT * FROM {{table}} WHERE `fleet_end_time` <= UNIX_TIMESTAMP()', 'fleets'); //  OR fleet_end_time <= ".time()
while ($row = mysql_fetch_array($_fleets)) {
    $array                = array();
    $array['galaxy']      = $row['fleet_end_galaxy'];
    $array['system']      = $row['fleet_end_system'];
    $array['planet']      = $row['fleet_end_planet'];
    $array['planet_type'] = $row['fleet_end_type'];

    $temp = FlyingFleetHandler($array);
}

unset($_fleets);

include(ROOT_PATH . 'rak.'.PHPEXT);
$dpath = DEFAULT_SKINPATH;


SetSelectedPlanet($user);

$planetrow = doquery("SELECT * FROM {{table}} WHERE `id` = '".$user['current_planet']."';", 'planets', true);
$galaxyrow = doquery("SELECT * FROM {{table}} WHERE `id_planet` = '".$planetrow['id']."';", 'galaxy', true);

CheckPlanetUsedFields($planetrow);
