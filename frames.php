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

$parse['meta-charset'] = "utf-8";
$parse['meta-language'] = "fr";
$parse['meta-author'] = "wootook";
$parse['meta-robots'] = "index,follow,all";
$parse['meta-copyright'] = "wootook/xnova";
$parse['meta-keywords'] = "xnova,xnova-legacies,wootook ,wargame,game,jeu";
$parse['meta-description'] = "univers dans lesquel vous construisez un empire!";
$parse['meta-Expires'] = "never";
$parse['meta-rating'] = "Tous public";
$parse['meta-subject'] = "Xnova-legacies";


$page = parsetemplate(gettemplate('frame'), $parse);
echo $page;
?>