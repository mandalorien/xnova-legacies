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

function GalaxyRowPlanetName ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowUser, $Galaxy, $System, $Planet, $PlanetType ) {
	global $lang, $user, $HavePhalanx, $CurrentSystem, $CurrentGalaxy;

	// Planete (Nom)
	$Result  = "<th style=\"white-space: nowrap;\" width=130>";

	if ($GalaxyRowUser['ally_id'] == $user['ally_id'] AND
		$GalaxyRowUser['id']      != $user['id']      AND
		$user['ally_id']          != '') {
		$TextColor = "<font color=\"green\">";
		$EndColor  = "</font>";
	} elseif ($GalaxyRowUser['id'] == $user['id']) {
		$TextColor = "<font color=\"red\">";
		$EndColor  = "</font>";
	} else {
		$TextColor = '';
		$EndColor  = "";
	}

	if ($GalaxyRowPlanet['last_update'] > (time()-59 * 60) AND
		$GalaxyRowUser['id'] != $user['id']) {
		$Inactivity = pretty_time_hour(time() - $GalaxyRowPlanet['last_update']);
	}
	if ($GalaxyRow && $GalaxyRowPlanet["destruyed"] == 0) {
		if ($HavePhalanx <> 0) {
			if ($GalaxyRowPlanet["galaxy"] == $CurrentGalaxy) {
				$Range = GetPhalanxRange ( $HavePhalanx );
				if ($CurrentGalaxy + $Range <= $CurrentSystem AND
					$CurrentSystem >= $CurrentGalaxy - $Range) {
					$PhalanxTypeLink = "<a href=# onclick=fenster('phalanx.php?galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType."')  title=\"".$lang['gl_phalanx']."\">".$GalaxyRowPlanet['name']."</a><br />";
				} else {
					$PhalanxTypeLink = stripslashes($GalaxyRowPlanet['name']);
				}
			} else {
				$PhalanxTypeLink = stripslashes($GalaxyRowPlanet['name']);
			}
		} else {
			$PhalanxTypeLink = stripslashes($GalaxyRowPlanet['name']);
		}

		$Result .= $TextColor . $PhalanxTypeLink . $EndColor;

		if ($GalaxyRowPlanet['last_update']  > (time()-59 * 60) AND
			$GalaxyRowUser['id']            != $user['id']) {
			if ($GalaxyRowPlanet['last_update']  > (time()-10 * 60) AND
				$GalaxyRowUser['id']            != $user['id']) {
				$Result .= "(*)";
			} else {
				$Result .= " (".$Inactivity.")";
			}
		}
	} elseif ($GalaxyRowPlanet["destruyed"] != 0) {
		$Result .= $lang['gl_destroyedplanet'];
	}

	$Result .= "</th>";

	return $Result;
}

?>