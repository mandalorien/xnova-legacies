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

function GalaxyRowActions ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowPlayer, $Galaxy, $System, $Planet, $PlanetType ) {
	global $lang, $user, $dpath, $CurrentMIP, $CurrentSystem, $CurrentGalaxy;
	// Icones action
	$Result  = "<th style=\"white-space: nowrap;\" width=125>";
	if ($GalaxyRowPlayer['id'] != $user['id']) {

		if ($CurrentMIP <> 0) {
			if ($GalaxyRowUser['id'] != $user['id']) {
				if ($GalaxyRowPlanet["galaxy"] == $CurrentGalaxy) {
					$Range = GetMissileRange();
					$SystemLimitMin = $CurrentSystem - $Range;
					if ($SystemLimitMin < 1) {
						$SystemLimitMin = 1;
					}
					$SystemLimitMax = $CurrentSystem + $Range;
					if ($System <= $SystemLimitMax) {
						if ($System >= $SystemLimitMin) {
							$MissileBtn = true;
						} else {
							$MissileBtn = false;
						}
					} else {
						$MissileBtn = false;
					}
				} else {
					$MissileBtn = false;
				}
			} else {
				$MissileBtn = false;
			}
		} else {
			$MissileBtn = false;
		}

		if ($GalaxyRowPlayer && $GalaxyRowPlanet["destruyed"] == 0) {
			if ($user["settings_esp"] == "1" &&
				$GalaxyRowPlayer['id']) {
				$Result .= "<a href=# onclick=\"javascript:doit(6, ".$Galaxy.", ".$System.", ".$Planet.", 1, ".$user["spio_anz"].");\" >";
				$Result .= "<img src=". $dpath ."img/e.gif alt=\"".$lang['gl_espionner']."\" title=\"".$lang['gl_espionner']."\" border=0></a>";
                $Result .= "&nbsp;";
			}
			if ($user["settings_wri"] == "1" &&
				$GalaxyRowPlayer['id']) {
				$Result .= "<a href=messages.php?mode=write&id=".$GalaxyRowPlayer["id"].">";
				$Result .= "<img src=". $dpath ."img/m.gif alt=\"".$lang['gl_sendmess']."\" title=\"".$lang['gl_sendmess']."\" border=0></a>";
                $Result .= "&nbsp;";
			}
			if ($user["settings_bud"] == "1" &&
				$GalaxyRowPlayer['id']) {
				$Result .= "<a href=buddy.php?a=2&amp;u=".$GalaxyRowPlayer['id']." >";
				$Result .= "<img src=". $dpath ."img/b.gif alt=\"".$lang['gl_buddyreq']."\" title=\"".$lang['gl_buddyreq']."\" border=0></a>";
                $Result .= "&nbsp;";
			}
			if ($user["settings_mis"] == "1" AND
				$MissileBtn == true          &&
				$GalaxyRowPlayer['id']) {
				$Result .= "<a href=galaxy.php?mode=2&galaxy=".$Galaxy."&system=".$System."&planet=".$Planet."&current=".$user['current_planet']." >";
				$Result .= "<img src=". $dpath ."img/r.gif alt=\"".$lang['gl_mipattack']."\" title=\"".$lang['gl_mipattack']."\" border=0></a>";
			}
		}
	}
	$Result .= "</th>";

	return $Result;
}

?>