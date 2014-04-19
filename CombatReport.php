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

define('INSIDE' , true);
define('INSTALL' , false);
require_once dirname(__FILE__) .'/common.php';

includeLang('tech');
$Page .= "<div id=\"content\">";

$raportrow 	= doquery("SELECT * FROM {{table}} WHERE `rid` = '".(mysql_real_escape_string($_GET["raport"]))."';", 'rw', true);


$owners	= explode(",", $raportrow["owners"]);

if (($owners[0] == $user["id"]) && ($raportrow["a_zestrzelona"] == 1))
{
	$Page .= "<td>".$lang['cr_lost_contact']."<br>";
	$Page .= $lang['cr_first_round']."</td>";
}
else
{
	$report = stripslashes($raportrow["raport"]);
	foreach ($lang['tech_rc'] as $id => $s_name)
	{
		$str_replace1  	= array("[ship[".$id."]]");
		$str_replace2  	= array($s_name);
		$report 		= str_replace($str_replace1, $str_replace2, $report);
	}
	$no_fleet 		= "<table border=1 align=\"center\"><tr><th>".$lang['cr_type']."</th></tr><tr><th>".$lang['cr_total']."</th></tr><tr><th>".$lang['cr_weapons']."</th></tr><tr><th>".$lang['cr_shields']."</th></tr><tr><th>".$lang['cr_armor']."</th></tr></table>";
	$destroyed 		= "<table border=1 align=\"center\"><tr><th><font color=\"red\"><strong>".$lang['cr_destroyed']."</strong></font></th></tr></table>";
	$str_replace1  	= array($no_fleet);
	$str_replace2  	= array($destroyed);
	$report 		= str_replace($str_replace1, $str_replace2, $report);
	$Page 		   .= $report;
}

display($Page, false, '', false, false);
?>