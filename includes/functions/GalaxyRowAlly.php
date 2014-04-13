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

function GalaxyRowAlly ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowUser, $Galaxy, $System, $Planet, $PlanetType ) {
	global $lang, $user;

	// Alliances
	$Result  = "<th width=80>";
	if ($GalaxyRowUser['ally_id'] && $GalaxyRowUser['ally_id'] != 0) {
		$allyquery = doquery("SELECT * FROM {{table}} WHERE id=" . $GalaxyRowUser['ally_id'], "alliance", true);
		if ($allyquery) {
			$members_count = doquery("SELECT COUNT(DISTINCT(id)) FROM {{table}} WHERE ally_id=" . $allyquery['id'] . ";", "users", true);

			if ($members_count[0] > 1) {
				$add = "s";
			} else {
				$add = "";
			}

			$Result .= "<a style=\"cursor: pointer;\"";
			$Result .= " onmouseover='return overlib(\"";
			$Result .= "<table width=240>";
			$Result .= "<tr>";
			$Result .= "<td class=c>".$lang['Alliance']." ". $allyquery['ally_name'] ." ".$lang['gl_with']." ". $members_count[0] ." ". $lang['gl_membre'] . $add ."</td>";
			$Result .= "</tr>";
			$Result .= "<th>";
			$Result .= "<table>";
			$Result .= "<tr>";
			$Result .= "<td><a href=alliance.php?mode=ainfo&a=". $allyquery['id'] .">".$lang['gl_ally_internal']."</a></td>";
			$Result .= "</tr><tr>";
			$Result .= "<td><a href=stat.php?start=101&who=ally>".$lang['gl_stats']."</a></td>";
			if ($allyquery["ally_web"] != "") {
				$Result .= "</tr><tr>";
				$Result .= "<td><a href=". $allyquery["ally_web"] ." target=_new>".$lang['gl_ally_web']."</td>";
			}
			$Result .= "</tr>";
			$Result .= "</table>";
			$Result .= "</th>";
			$Result .= "</table>\"";
			$Result .= ", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );'";
			$Result .= " onmouseout='return nd();'>";
			if ($user['ally_id'] == $GalaxyRowPlayer['ally_id']) {
				$Result .= "<span class=\"allymember\">". $allyquery['ally_tag'] ."</span></a>";
			} else {
				$Result .= $allyquery['ally_tag'] ."</a>";
			}
		}
	}
	$Result .= "</th>";

	return $Result;
}

?>