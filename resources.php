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
require_once dirname(__FILE__) .'/common.php';


function BuildRessourcePage ( $CurrentUser, $CurrentPlanet ) {
	global $lang, $ProdGrid, $resource, $reslist, $game_config, $_POST;

	includeLang('resources');

	$RessBodyTPL = gettemplate('resources');
	$RessRowTPL  = gettemplate('resources_row');

	// Si c'est une lune ... pas de ressources produites
	if ($CurrentPlanet['planet_type'] == 3) {
		$game_config['metal_basic_income']     = 0;
		$game_config['crystal_basic_income']   = 0;
		$game_config['deuterium_basic_income'] = 0;
	}

	$ValidList['percent'] = array (  0,  10,  20,  30,  40,  50,  60,  70,  80,  90, 100 );
	$SubQry               = "";
	if ($_POST) {
		foreach($_POST as $Field => $Value) {
			$FieldName = $Field."_porcent";
			if ( isset( $CurrentPlanet[ $FieldName ] ) ) {
				if ( ! in_array( $Value, $ValidList['percent']) ) {
					header("Location: overview.php");
					exit;
				}

				$Value                        = $Value / 10;
				$CurrentPlanet[ $FieldName ]  = $Value;
				$SubQry                      .= ", `".$FieldName."` = '".$Value."'";
			}
		}
	}

	$parse  = $lang;

	$parse['production_level'] = 100;
	if       ($CurrentPlanet['energy_max'] == 0 &&
		$CurrentPlanet['energy_used'] > 0) {
		$post_porcent = 0;
	} elseif ($CurrentPlanet['energy_max'] >  0 &&
		($CurrentPlanet['energy_used'] + $CurrentPlanet['energy_max']) < 0 ) {
		$post_porcent = floor(($CurrentPlanet['energy_max']) / $CurrentPlanet['energy_used'] * 100);
	} else {
		$post_porcent = 100;
	}
	if ($post_porcent > 100) {
		$post_porcent = 100;
	}

	// -------------------------------------------------------------------------------------------------------
	// Mise a jour de l'espace de stockage
	$CurrentPlanet['metal_max']     = (floor (BASE_STORAGE_SIZE * pow (1.5, $CurrentPlanet[ $resource[22] ] ))) * (1 + ($CurrentUser['rpg_stockeur'] * 0.5));
	$CurrentPlanet['crystal_max']   = (floor (BASE_STORAGE_SIZE * pow (1.5, $CurrentPlanet[ $resource[23] ] ))) * (1 + ($CurrentUser['rpg_stockeur'] * 0.5));
	$CurrentPlanet['deuterium_max'] = (floor (BASE_STORAGE_SIZE * pow (1.5, $CurrentPlanet[ $resource[24] ] ))) * (1 + ($CurrentUser['rpg_stockeur'] * 0.5));

	// -------------------------------------------------------------------------------------------------------
	$parse['resource_row']               = "";
	$CurrentPlanet['metal_perhour']      = 0;
	$CurrentPlanet['crystal_perhour']    = 0;
	$CurrentPlanet['deuterium_perhour']  = 0;
	$CurrentPlanet['energy_max']         = 0;
	$CurrentPlanet['energy_used']        = 0;
	$BuildTemp                           = $CurrentPlanet[ 'temp_max' ];
	foreach($reslist['prod'] as $ProdID) {
		if ($CurrentPlanet[$resource[$ProdID]] > 0 && isset($ProdGrid[$ProdID])) {
			$BuildLevelFactor                    = $CurrentPlanet[ $resource[$ProdID]."_porcent" ];
			$BuildLevel                          = $CurrentPlanet[ $resource[$ProdID] ];
			$metal     = floor( eval ( $ProdGrid[$ProdID]['formule']['metal']     ) * ( $game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_geologue']  * 0.05 ) ) );
			$crystal   = floor( eval ( $ProdGrid[$ProdID]['formule']['crystal']   ) * ( $game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_geologue']  * 0.05 ) ) );
			$deuterium = floor( eval ( $ProdGrid[$ProdID]['formule']['deuterium'] ) * ( $game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_geologue']  * 0.05 ) ) );
			$energy    = floor( eval ( $ProdGrid[$ProdID]['formule']['energy']    ) * ( $game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_ingenieur'] * 0.05 ) ) );
			if ($energy > 0) {
				$CurrentPlanet['energy_max']    += $energy;
			} else {
				$CurrentPlanet['energy_used']   += $energy;
			}
			$CurrentPlanet['metal_perhour']     += $metal;
			$CurrentPlanet['crystal_perhour']   += $crystal;
			$CurrentPlanet['deuterium_perhour'] += $deuterium;

			$metal                               = $metal     * 0.01 * $post_porcent;
			$crystal                             = $crystal   * 0.01 * $post_porcent;
			$deuterium                           = $deuterium * 0.01 * $post_porcent;
			$energy                              = $energy    * 0.01 * $post_porcent;
			$Field                               = $resource[$ProdID] ."_porcent";
			$CurrRow                             = array();
			$CurrRow['name']                     = $resource[$ProdID];
			$CurrRow['porcent']                  = $CurrentPlanet[$Field];
			for ($Option = 10; $Option >= 0; $Option--) {
				$OptValue = $Option * 10;
				if ($Option == $CurrRow['porcent']) {
					$OptSelected    = " selected=selected";
				} else {
					$OptSelected    = "";
				}
				$CurrRow['option'] .= "<option value=\"".$OptValue."\"".$OptSelected.">".$OptValue."%</option>";
			}
			$CurrRow['type']                     = $lang['tech'][$ProdID];
			$CurrRow['level']                    = ($ProdID > 200) ? $lang['quantity'] : $lang['level'];
			$CurrRow['level_type']               = $CurrentPlanet[ $resource[$ProdID] ];
			$CurrRow['metal_type']               = pretty_number ( $metal     );
			$CurrRow['crystal_type']             = pretty_number ( $crystal   );
			$CurrRow['deuterium_type']           = pretty_number ( $deuterium );
			$CurrRow['energy_type']              = pretty_number ( $energy    );
			$CurrRow['metal_type']               = colorNumber ( $CurrRow['metal_type']     );
			$CurrRow['crystal_type']             = colorNumber ( $CurrRow['crystal_type']   );
			$CurrRow['deuterium_type']           = colorNumber ( $CurrRow['deuterium_type'] );
			$CurrRow['energy_type']              = colorNumber ( $CurrRow['energy_type']    );

			$parse['resource_row']              .= parsetemplate ( $RessRowTPL, $CurrRow );
		}
	}

	$parse['Production_of_resources_in_the_planet'] =
	str_replace('%s', $CurrentPlanet['name'], $lang['Production_of_resources_in_the_planet']);
	if       ($CurrentPlanet['energy_max'] == 0 &&
		$CurrentPlanet['energy_used'] > 0) {
		$parse['production_level'] = 0;
	} elseif ($CurrentPlanet['energy_max']  > 0 &&
		abs($CurrentPlanet['energy_used']) > $CurrentPlanet['energy_max']) {
		$parse['production_level'] = floor(($CurrentPlanet['energy_max']) / $CurrentPlanet['energy_used'] * 100);
	} elseif ($CurrentPlanet['energy_max'] == 0 &&
		abs($CurrentPlanet['energy_used']) > $CurrentPlanet['energy_max']) {
		$parse['production_level'] = 0;
	} else {
		$parse['production_level'] = 100;
	}
	if ($parse['production_level'] > 100) {
		$parse['production_level'] = 100;
	}

	$parse['metal_basic_income']     = $game_config['metal_basic_income']     * $game_config['resource_multiplier'];
	$parse['crystal_basic_income']   = $game_config['crystal_basic_income']   * $game_config['resource_multiplier'];
	$parse['deuterium_basic_income'] = $game_config['deuterium_basic_income'] * $game_config['resource_multiplier'];
	$parse['energy_basic_income']    = $game_config['energy_basic_income']    * $game_config['resource_multiplier'];

	if ($CurrentPlanet['metal_max'] < $CurrentPlanet['metal']) {
		$parse['metal_max']         = "<font color=\"#ff0000\">";
	} else {
		$parse['metal_max']         = "<font color=\"#00ff00\">";
	}
	$parse['metal_max']            .= pretty_number($CurrentPlanet['metal_max'] / 1000) ." ". $lang['k']."</font>";

	if ($CurrentPlanet['crystal_max'] < $CurrentPlanet['crystal']) {
		$parse['crystal_max']       = "<font color=\"#ff0000\">";
	} else {
		$parse['crystal_max']       = "<font color=\"#00ff00\">";
	}
	$parse['crystal_max']          .= pretty_number($CurrentPlanet['crystal_max'] / 1000) ." ". $lang['k']."</font>";

	if ($CurrentPlanet['deuterium_max'] < $CurrentPlanet['deuterium']) {
		$parse['deuterium_max']     = "<font color=\"#ff0000\">";
	} else {
		$parse['deuterium_max']     = "<font color=\"#00ff00\">";
	}
	$parse['deuterium_max']        .= pretty_number($CurrentPlanet['deuterium_max'] / 1000) ." ". $lang['k']."</font>";

	$parse['metal_total']           = colorNumber( pretty_number( floor( ( $CurrentPlanet['metal_perhour']     * 0.01 * $parse['production_level'] ) + $parse['metal_basic_income'])));
	$parse['crystal_total']         = colorNumber( pretty_number( floor( ( $CurrentPlanet['crystal_perhour']   * 0.01 * $parse['production_level'] ) + $parse['crystal_basic_income'])));
	$parse['deuterium_total']       = colorNumber( pretty_number( floor( ( $CurrentPlanet['deuterium_perhour'] * 0.01 * $parse['production_level'] ) + $parse['deuterium_basic_income'])));
	$parse['energy_total']          = colorNumber( pretty_number( floor( ( $CurrentPlanet['energy_max'] + $parse['energy_basic_income']    ) + $CurrentPlanet['energy_used'] ) ) );

	$parse['daily_metal']           = floor($CurrentPlanet['metal_perhour']     * 24      * 0.01 * $parse['production_level'] + $parse['metal_basic_income']     * 24      );
	$parse['weekly_metal']          = floor($CurrentPlanet['metal_perhour']     * 24 * 7  * 0.01 * $parse['production_level'] + $parse['metal_basic_income']     * 24 * 7  );
	$parse['monthly_metal']         = floor($CurrentPlanet['metal_perhour']     * 24 * 30 * 0.01 * $parse['production_level'] + $parse['metal_basic_income']     * 24 * 30 );

	$parse['daily_crystal']         = floor($CurrentPlanet['crystal_perhour']   * 24      * 0.01 * $parse['production_level'] + $parse['crystal_basic_income']   * 24      );
	$parse['weekly_crystal']        = floor($CurrentPlanet['crystal_perhour']   * 24 * 7  * 0.01 * $parse['production_level'] + $parse['crystal_basic_income']   * 24 * 7  );
	$parse['monthly_crystal']       = floor($CurrentPlanet['crystal_perhour']   * 24 * 30 * 0.01 * $parse['production_level'] + $parse['crystal_basic_income']   * 24 * 30 );

	$parse['daily_deuterium']       = floor($CurrentPlanet['deuterium_perhour'] * 24      * 0.01 * $parse['production_level'] + $parse['deuterium_basic_income'] * 24      );
	$parse['weekly_deuterium']      = floor($CurrentPlanet['deuterium_perhour'] * 24 * 7  * 0.01 * $parse['production_level'] + $parse['deuterium_basic_income'] * 24 * 7  );
	$parse['monthly_deuterium']     = floor($CurrentPlanet['deuterium_perhour'] * 24 * 30 * 0.01 * $parse['production_level'] + $parse['deuterium_basic_income'] * 24 * 30 );

	$parse['daily_metal']           = colorNumber(pretty_number($parse['daily_metal']));
	$parse['weekly_metal']          = colorNumber(pretty_number($parse['weekly_metal']));
	$parse['monthly_metal']         = colorNumber(pretty_number($parse['monthly_metal']));

	$parse['daily_crystal']         = colorNumber(pretty_number($parse['daily_crystal']));
	$parse['weekly_crystal']        = colorNumber(pretty_number($parse['weekly_crystal']));
	$parse['monthly_crystal']       = colorNumber(pretty_number($parse['monthly_crystal']));

	$parse['daily_deuterium']       = colorNumber(pretty_number($parse['daily_deuterium']));
	$parse['weekly_deuterium']      = colorNumber(pretty_number($parse['weekly_deuterium']));
	$parse['monthly_deuterium']     = colorNumber(pretty_number($parse['monthly_deuterium']));

	$parse['metal_storage']         = floor($CurrentPlanet['metal']     / $CurrentPlanet['metal_max']     * 100) . $lang['o/o'];
	$parse['crystal_storage']       = floor($CurrentPlanet['crystal']   / $CurrentPlanet['crystal_max']   * 100) . $lang['o/o'];
	$parse['deuterium_storage']     = floor($CurrentPlanet['deuterium'] / $CurrentPlanet['deuterium_max'] * 100) . $lang['o/o'];
	$parse['metal_storage_bar']     = floor(($CurrentPlanet['metal']     / $CurrentPlanet['metal_max']     * 100) * 2.5);
	$parse['crystal_storage_bar']   = floor(($CurrentPlanet['crystal']   / $CurrentPlanet['crystal_max']   * 100) * 2.5);
	$parse['deuterium_storage_bar'] = floor(($CurrentPlanet['deuterium'] / $CurrentPlanet['deuterium_max'] * 100) * 2.5);

	if ($parse['metal_storage_bar'] > (100 * 2.5)) {
		$parse['metal_storage_bar'] = 250;
		$parse['metal_storage_barcolor'] = '#C00000';
	} elseif ($parse['metal_storage_bar'] > (80 * 2.5)) {
		$parse['metal_storage_barcolor'] = '#C0C000';
	} else {
		$parse['metal_storage_barcolor'] = '#00C000';
	}

	if ($parse['crystal_storage_bar'] > (100 * 2.5)) {
		$parse['crystal_storage_bar'] = 250;
		$parse['crystal_storage_barcolor'] = '#C00000';
	} elseif ($parse['crystal_storage_bar'] > (80 * 2.5)) {
		$parse['crystal_storage_barcolor'] = '#C0C000';
	} else {
		$parse['crystal_storage_barcolor'] = '#00C000';
	}

	if ($parse['deuterium_storage_bar'] > (100 * 2.5)) {
		$parse['deuterium_storage_bar'] = 250;
		$parse['deuterium_storage_barcolor'] = '#C00000';
	} elseif ($parse['deuterium_storage_bar'] > (80 * 2.5)) {
		$parse['deuterium_storage_barcolor'] = '#C0C000';
	} else {
		$parse['deuterium_storage_barcolor'] = '#00C000';
	}

	$parse['production_level_bar'] = $parse['production_level'] * 2.5;
	$parse['production_level']     = "{$parse['production_level']}%";
	$parse['production_level_barcolor'] = '#00ff00';

	$QryUpdatePlanet  = "UPDATE {{table}} SET ";
	$QryUpdatePlanet .= "`id` = '". $CurrentPlanet['id'] ."' ";
	$QryUpdatePlanet .= $SubQry;
	$QryUpdatePlanet .= "WHERE ";
	$QryUpdatePlanet .= "`id` = '". $CurrentPlanet['id'] ."';";
	doquery( $QryUpdatePlanet, 'planets');

	$page = parsetemplate( $RessBodyTPL, $parse );

	return $page;
}

	$Page = BuildRessourcePage ( $user, $planetrow );
	display( $Page, $lang['Resources'] );

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Passage en fonction pour utilisation XNova
?>
