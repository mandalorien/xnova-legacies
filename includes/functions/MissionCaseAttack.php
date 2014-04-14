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

function MissionCaseAttack ($FleetRow)
{
    global $pricelist, $lang, $resource, $CombatCaps, $user;

 		if ($FleetRow['fleet_mess'] == 0 && $FleetRow['fleet_start_time'] <= time())
		{
			$targetPlanet = doquery("SELECT * FROM {{table}} WHERE `galaxy` = ". intval($FleetRow['fleet_end_galaxy']) ." AND `system` = ". intval($FleetRow['fleet_end_system']) ." AND `planet_type` = ". intval($FleetRow['fleet_end_type']) ." AND `planet` = ". intval($FleetRow['fleet_end_planet']) .";",'planets', true);

			if ($FleetRow['fleet_group'] > 0)
			{
				doquery("DELETE FROM {{table}} WHERE id =".intval($FleetRow['fleet_group']),'aks');
				doquery("UPDATE {{table}} SET fleet_mess=1 WHERE fleet_group=".$FleetRow['fleet_group'],'fleets');
			}
			else
			{
				doquery("UPDATE {{table}} SET fleet_mess=1 WHERE fleet_id=".intval($FleetRow['fleet_id']),'fleets');
			}

			$targetGalaxy = doquery('SELECT * FROM {{table}} WHERE `galaxy` = '. intval($FleetRow['fleet_end_galaxy']) .' AND `system` = '. intval($FleetRow['fleet_end_system']) .' AND `planet` = '. intval($FleetRow['fleet_end_planet']) .';','galaxy', true);
			$targetUser   = doquery('SELECT * FROM {{table}} WHERE id='.intval($targetPlanet['id_owner']),'users', true);

			PlanetResourceUpdate ( $targetUser, $targetPlanet, time() );

			$targetGalaxy = doquery('SELECT * FROM {{table}} WHERE `galaxy` = '. intval($FleetRow['fleet_end_galaxy']) .' AND `system` = '. intval($FleetRow['fleet_end_system']) .' AND `planet` = '. intval($FleetRow['fleet_end_planet']) .';','galaxy', true);
			$targetUser   = doquery('SELECT * FROM {{table}} WHERE id='.intval($targetPlanet['id_owner']),'users', true);

			$TargetUserID = $targetUser['id'];
			$attackFleets = array();

			if ($FleetRow['fleet_group'] != 0)
			{
				$fleets = doquery('SELECT * FROM {{table}} WHERE fleet_group='.$FleetRow['fleet_group'],'fleets');
				while ($fleet = mysql_fetch_assoc($fleets))
				{
					$attackFleets[$fleet['fleet_id']]['fleet'] = $fleet;
					$attackFleets[$fleet['fleet_id']]['user'] = doquery('SELECT * FROM {{table}} WHERE id ='.intval($fleet['fleet_owner']),'users', true);
					$attackFleets[$fleet['fleet_id']]['detail'] = array();
					$temp = explode(';', $fleet['fleet_array']);
					foreach ($temp as $temp2)
					{
						$temp2 = explode(',', $temp2);

						if ($temp2[0] < 100) continue;

						if (!isset($attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]]))
							$attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]] = 0;

						$attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]] += $temp2[1];
					}
				}

			}
			else
			{
				$attackFleets[$FleetRow['fleet_id']]['fleet'] = $FleetRow;
				$attackFleets[$FleetRow['fleet_id']]['user'] = doquery('SELECT * FROM {{table}} WHERE id='.intval($FleetRow['fleet_owner']),'users', true);
				$attackFleets[$FleetRow['fleet_id']]['detail'] = array();
				$temp = explode(';', $FleetRow['fleet_array']);
				foreach ($temp as $temp2)
				{
					$temp2 = explode(',', $temp2);

					if ($temp2[0] < 100) continue;

					if (!isset($attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]]))
						$attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]] = 0;

					$attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]] += $temp2[1];
				}
			}
			$defense = array();

			$def = doquery('SELECT * FROM {{table}} WHERE `fleet_end_galaxy` = '. intval($FleetRow['fleet_end_galaxy']) .' AND `fleet_end_system` = '. intval($FleetRow['fleet_end_system']) .' AND `fleet_end_type` = '. intval($FleetRow['fleet_end_type']) .' AND `fleet_end_planet` = '. intval($FleetRow['fleet_end_planet']) .' AND fleet_start_time<'.time().' AND fleet_end_stay>='.time(),'fleets');
			while ($defRow = mysql_fetch_assoc($def))
			{
				$defRowDef = explode(';', $defRow['fleet_array']);
				foreach ($defRowDef as $Element)
				{
					$Element = explode(',', $Element);

					if ($Element[0] < 100) continue;

					if (!isset($defense[$defRow['fleet_id']]['def'][$Element[0]]))
						$defense[$defRow['fleet_id']][$Element[0]] = 0;

					$defense[$defRow['fleet_id']]['def'][$Element[0]] += $Element[1];
					$defense[$defRow['fleet_id']]['user'] = doquery('SELECT * FROM {{table}} WHERE id='.intval($defRow['fleet_owner']),'users', true);
				}
			}

			$defense[0]['def'] = array();
			$defense[0]['user'] = $targetUser;
			for ($i = 200; $i < 500; $i++)
			{
				if (isset($resource[$i]) && isset($targetPlanet[$resource[$i]]))
				{
					$defense[0]['def'][$i] = $targetPlanet[$resource[$i]];
				}
			}
			$start 		= microtime(true);
			$result 	= calculateAttack($attackFleets, $defense);
			$totaltime 	= microtime(true) - $start;

			$QryUpdateGalaxy = "UPDATE {{table}} SET ";
			$QryUpdateGalaxy .= "`metal` = `metal` +'".($result['debree']['att'][0]+$result['debree']['def'][0]) . "', ";
			$QryUpdateGalaxy .= "`crystal` = `crystal` + '" .($result['debree']['att'][1]+$result['debree']['def'][1]). "' ";
			$QryUpdateGalaxy .= "WHERE ";
			$QryUpdateGalaxy .= "`galaxy` = '" . intval($FleetRow['fleet_end_galaxy']) . "' AND ";
			$QryUpdateGalaxy .= "`system` = '" . intval($FleetRow['fleet_end_system']) . "' AND ";
			$QryUpdateGalaxy .= "`planet` = '" . intval($FleetRow['fleet_end_planet']) . "' ";
			$QryUpdateGalaxy .= "LIMIT 1;";
			doquery($QryUpdateGalaxy , 'galaxy');

			$totalDebree = $result['debree']['def'][0] + $result['debree']['def'][1] + $result['debree']['att'][0] + $result['debree']['att'][1];

			$steal = array('metal' => 0, 'crystal' => 0, 'deuterium' => 0);

			if ($result['won'] == "a")
			{
				$steal = calculateAKSSteal($attackFleets, $targetPlanet);
			}

			foreach ($attackFleets as $fleetID => $attacker)
			{
				$fleetArray = '';
				$totalCount = 0;
				foreach ($attacker['detail'] as $element => $amount)
				{
					if ($amount)
						$fleetArray .= $element.','.$amount.';';

					$totalCount += $amount;
				}

				if ($totalCount <= 0)
				{
					doquery ('DELETE FROM {{table}} WHERE `fleet_id`='.intval($fleetID),'fleets');
				}
				else
				{
					doquery ('UPDATE {{table}} SET fleet_array="'.substr($fleetArray, 0, -1).'", fleet_amount='.$totalCount.', fleet_mess=1 WHERE fleet_id='.intval($fleetID),'fleets');
				}
			}

			foreach ($defense as $fleetID => $defender)
			{
				if ($fleetID != 0)
				{
					$fleetArray = '';
					$totalCount = 0;

					foreach ($defender['def'] as $element => $amount)
					{
						if ($amount) $fleetArray .= $element.','.$amount.';';
						$totalCount += $amount;
					}

					if ($totalCount <= 0)
					{
						doquery ('DELETE FROM {{table}} WHERE `fleet_id`='.intval($fleetID),'fleets');

					}
					else
					{
						doquery('UPDATE {{table}} SET fleet_array="'.$fleetArray.'", fleet_amount='.$totalCount.', fleet_mess=1 WHERE fleet_id='.$fleetID,'fleets');
					}

				}
				else
				{
					$fleetArray = '';
					$totalCount = 0;

					foreach ($defender['def'] as $element => $amount)
					{
						$fleetArray .= '`'.$resource[$element].'`='.$amount.', ';
					}

					$QryUpdateTarget  = "UPDATE {{table}} SET ";
					$QryUpdateTarget .= $fleetArray;
					$QryUpdateTarget .= "`metal` = `metal` - '". $steal['metal'] ."', ";
					$QryUpdateTarget .= "`crystal` = `crystal` - '". $steal['crystal'] ."', ";
					$QryUpdateTarget .= "`deuterium` = `deuterium` - '". $steal['deuterium'] ."' ";
					$QryUpdateTarget .= "WHERE ";
					$QryUpdateTarget .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
					$QryUpdateTarget .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
					$QryUpdateTarget .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
					$QryUpdateTarget .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."' ";
					$QryUpdateTarget .= "LIMIT 1;";
					doquery( $QryUpdateTarget , 'planets');
				}
			}

			$FleetDebris      = $result['debree']['att'][0] + $result['debree']['def'][0] + $result['debree']['att'][1] + $result['debree']['def'][1];
			$StrAttackerUnits = sprintf ($lang['sys_attacker_lostunits'], $result['lost']['att']);
			$StrDefenderUnits = sprintf ($lang['sys_defender_lostunits'], $result['lost']['def']);
			$StrRuins         = sprintf ($lang['sys_gcdrunits'], $result['debree']['def'][0] + $result['debree']['att'][0], $lang['Metal'], $result['debree']['def'][1] + $result['debree']['att'][1], $lang['Crystal']);
			$DebrisField      = $StrAttackerUnits ."<br />". $StrDefenderUnits ."<br />". $StrRuins;
			$MoonChance       = $FleetDebris / 100000;

			if($FleetDebris > 2000000)
			{
				$MoonChance = 20;
				$UserChance = mt_rand(1, 100);
				$ChanceMoon = sprintf ($lang['sys_moonproba'], $MoonChance);
			}
			elseif($FleetDebris < 100000)
			{
				$UserChance = 0;
				$ChanceMoon = sprintf ($lang['sys_moonproba'], $MoonChance);
			}
			elseif($FleetDebris >= 100000)
			{
				$UserChance = mt_rand(1, 100);
				$ChanceMoon = sprintf ($lang['sys_moonproba'], $MoonChance);
			}

			if (($UserChance > 0) && ($UserChance <= $MoonChance) && ($targetGalaxy['id_luna'] == 0))
			{
				$TargetPlanetName = CreateOneMoonRecord ( $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'], $TargetUserID, $FleetRow['fleet_start_time'], '', $MoonChance );
				$GottenMoon       = sprintf ($lang['sys_moonbuilt'], $TargetPlanetName, $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']);
				$GottenMoon .= "<br />";
			}
			elseif ($UserChance = 0 or $UserChance > $MoonChance)
			{
				$GottenMoon = "";
			}

			$formatted_cr 	= formatCR($result,$steal,$MoonChance,$GottenMoon,$totaltime);
			$raport 		= $formatted_cr['html'];


			$rid   = md5($raport);
			$QryInsertRapport  = 'INSERT INTO {{table}} SET ';
			$QryInsertRapport .= '`time` = UNIX_TIMESTAMP(), ';

			foreach ($attackFleets as $fleetID => $attacker)
			{
				$users2[$attacker['user']['id']] = $attacker['user']['id'];
			}

			foreach ($defense as $fleetID => $defender)
			{
				$users2[$defender['user']['id']] = $defender['user']['id'];
			}

			$QryInsertRapport .= '`owners` = "'.implode(',', $users2).'", ';
			$QryInsertRapport .= '`rid` = "'. $rid .'", ';
			$QryInsertRapport .= '`a_zestrzelona` = "'.$formatted_cr['destroyed'].'", ';
			$QryInsertRapport .= '`raport` = "'. mysql_escape_string( $raport ) .'"';
			doquery($QryInsertRapport,'rw') or die("Error inserting CR to database".mysql_error()."<br /><br />Trying to execute:".mysql_query());

			if($result['won'] == "a")
			{
				$style = "green";
			}
			elseif ($result['won'] == "w")
			{
				$style = "orange";
			}
			elseif ($result['won'] == "r")
			{
				$style = "red";
			}

            // Colorisation du résumé de rapport pour l'attaquant
            $raport = "<a href # OnClick=\"f( 'CombatReport.php?raport=" . $rid . "', '');\" >";
            $raport .= "<center>";
            if ($result['won'] == "a") {
                $raport .= "<font color=\"green\">";
            } elseif ($result['won'] == "r") {
                $raport .= "<font color=\"orange\">";
            } elseif ($result['won'] == "w") {
                $raport .= "<font color=\"red\">";
            }
            $raport .= $lang['sys_mess_attack_report'] . " [" . $FleetRow['fleet_end_galaxy'] . ":" . $FleetRow['fleet_end_system'] . ":" . $FleetRow['fleet_end_planet'] . "] </font></a><br /><br />";
            $raport .= "<font color=\"red\">" . $lang['sys_perte_attaquant'] . ": " . pretty_number ($result['lost']['att']) . "</font>";
            $raport .= "<font color=\"green\">   " . $lang['sys_perte_defenseur'] . ":" . pretty_number ($result['lost']['def']) . "</font><br />" ;
            $raport .= $lang['sys_gain'] . " " . $lang['Metal'] . ":<font color=\"#adaead\">" . pretty_number ($steal['metal']) . "</font>   " . $lang['Crystal'] . ":<font color=\"#ef51ef\">" . pretty_number ($steal['crystal']) . "</font>   " . $lang['Deuterium'] . ":<font color=\"#f77542\">" . pretty_number ($steal['deuterium']) . "</font><br />";
            $raport .= $lang['sys_debris'] . " " . $lang['Metal'] . ":<font color=\"#adaead\">" . pretty_number ($result['debree']['def'][0] + $result['debree']['att'][0]) . "</font>   " . $lang['Crystal'] . ":<font color=\"#ef51ef\">" . pretty_number ($result['debree']['def'][1] + $result['debree']['att'][1]) . "</font><br /></center>";

			SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_attack_report'], $raport);

			if($result['won'] == "a")
			{
				$style = "red";
			}
			elseif ($result['won'] == "w")
			{
				$style = "orange";
			}
			elseif ($result['won'] == "r")
			{
				$style = "green";
			}

			$raport2  = "<a href=\"#\" style=\"color:".$style.";\" OnClick='f(\"CombatReport.php?raport=". $rid ."\", \"\");' >" . $lang['sys_mess_attack_report'] ." [". $FleetRow['fleet_end_galaxy'] .":". $FleetRow['fleet_end_system'] .":". $FleetRow['fleet_end_planet'] ."]</a>";

			foreach ($users2 as $id)
			{
				if ($id != $FleetRow['fleet_owner'] && $id != 0)
				{
					SendSimpleMessage ( $id, '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_attack_report'], $raport2);
				}
			}
		}
		elseif ($FleetRow['fleet_end_time'] <= time())
		{
			$Message         = sprintf( $lang['sys_fleet_won'],
						$TargetName, GetTargetAdressLink($FleetRow, ''),
						pretty_number($FleetRow['fleet_resource_metal']), $lang['Metal'],
						pretty_number($FleetRow['fleet_resource_crystal']), $lang['Crystal'],
						pretty_number($FleetRow['fleet_resource_deuterium']), $lang['Deuterium'] );
			// SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_fleetback'], $Message);
			RestoreFleetToPlanet($FleetRow);
			doquery ('DELETE FROM {{table}} WHERE `fleet_id`='.intval($FleetRow['fleet_id']),'fleets');
		}
}

?>