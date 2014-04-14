<?php
/**
 * Tis file is part of XNova:Legacies
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

define('INSIDE' , true);
define('INSTALL' , false);
define('DISABLE_IDENTITY_CHECK', true);

$XNova_Host    = $_SERVER['HTTP_HOST'];
$XNova_Script  = $_SERVER['SCRIPT_NAME'];
$Uri_Array     = explode ('/', $XNova_Script);
// On vire le script
array_pop($Uri_Array);
$XNova_URI     = implode ('/', $Uri_Array);

$XNovaRootURL  = "http://". $XNova_Host ."/". $XNova_URI ."/";

require_once dirname(__FILE__) .'/common.php';

$page  = "<html>\n";
$page .= "	<head>\n";
$page .= '		<!--<meta name="viewport" content="width=device-width, target-densitydpi=device-dpi"/> pourle mobile-->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta http-equiv="content-language" content="fr" />
		<meta name="language" content="fr" />
		<meta content="Mandalorien" name="author"/>
		<meta content="index,follow,all" name="robots" />
		<meta content="Xnova" name="copyright"/>
		<meta content="xnova,xnova-legacies,wootook ,wargame,game,jeu" name="keywords" />
		<meta content="xnova-legacies::2009.2" name="description"/>
		<meta content="never" name="Expires"/>
		<meta content="Tous public" name="rating"/>
		<meta content="Xnova-legacies" name="subject"/>
		<link rel="shortcut icon" href="favicon.ico">';
$page .= "\n";
$page .= "		<title>". $game_config['game_name'] ."</title>\n";
$page .= "	</head>\n";
$page .= "		<frameset framespacing=\"0\" border=\"0\" cols=\"190,*\" frameborder=\"0\">\n";
$page .= "			<frame name=\"LeftMenu\" target=\"Mainframe\" src=\"leftmenu.php\" noresize scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\">\n";
$page .= "			<frame name=\"Hauptframe\" src=\"overview.php\">\n";
$page .= "			<noframes>\n";
$page .= "				<p>Votre navigateur ne gère pas les frames.</p>\n";
$page .= "			</noframes>\n";
$page .= "		</frameset>\n";
$page .= "</html>\n";

echo $page;

