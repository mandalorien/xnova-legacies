<?php
/**
 * This file is part of Noxgame
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 *
 * Copyright (c) 2012-Present, mandalorien
 * All rights reserved.
 *=========================================================
  _   _                                     
 | \ | |                                    
 |  \| | _____  ____ _  __ _ _ __ ___   ___ 
 | . ` |/ _ \ \/ / _` |/ _` | '_ ` _ \ / _ \
 | |\  | (_) >  < (_| | (_| | | | | | |  __/
 |_| \_|\___/_/\_\__, |\__,_|_| |_| |_|\___|
                  __/ |                     
                 |___/                                                                             
 *=========================================================
 *
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('DISABLE_IDENTITY_CHECK', true);

require_once dirname(dirname(dirname(__FILE__))) .'/Core/core.php';

/***************************************************/
/*		SUPPRESSION DES PLANETES DECOLONISER	   */
/***************************************************/	
$planetinutilise = doquery("SELECT * FROM {{table}};", 'planets');
while ($del = mysql_fetch_array($planetinutilise)) 
{
	if($del['b_hangar_id'] ==0)
	{
					$Qry = "
						UPDATE
								{{table}}
						SET 
								`b_hangar_id` = ''
						WHERE 
								`id` = '{$del['id']}';";

				doquery($Qry, 'planets');				
	}
	
	if($del['id_owner'] == 0)
	{			
		$galaxieinutilise = doquery("DELETE FROM {{table}} WHERE `id_planet` =".$del['id'].";", 'galaxy',true);
		$planetinutilise = doquery("DELETE FROM {{table}} WHERE `id_owner` = 0;", 'planets',true);
	}
}
/****************************************
 *		GESTION DES BANNISSEMENT		*
 ****************************************/
 
$banni = doquery("SELECT * FROM {{table}}",'banned');
while ($bannissement = mysql_fetch_array($banni)) 
{
	if(time() >= $bannissement['longer'])
	{
		$Qry5 ="DELETE FROM {{table}}  WHERE `id`=".$bannissement['id'].";";
		doquery($Qry5, 'banned');

		$Qry6 ="UPDATE {{table}} SET `bana`='0'  AND `banaday`='0'  WHERE `username`=".$bannissement['who']." or `username`=".$bannissement['who2'].";";
		doquery($Qry6, 'users');
	}
}

include_once('statfunctions.php');


	includeLang('admin');

	$StatDate   = time();
	// Rotation des statistiques
	doquery ( "DELETE FROM {{table}} WHERE `stat_code` = '2';" , 'statpoints');
	doquery ( "UPDATE {{table}} SET `stat_code` = `stat_code` + '1';" , 'statpoints');

	$GameUsers  = doquery("SELECT * FROM {{table}}", 'users');

	while ($CurUser = mysql_fetch_assoc($GameUsers)) {
		// Recuperation des anciennes statistiques
		$OldStatRecord  = doquery ("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `id_owner` = '".$CurUser['id']."';",'statpoints');
		if ($OldStatRecord) {
			$OldTotalRank = $OldStatRecord['total_rank'];
			$OldTechRank  = $OldStatRecord['tech_rank'];
			$OldBuildRank = $OldStatRecord['build_rank'];
			$OldDefsRank  = $OldStatRecord['defs_rank'];
			$OldFleetRank = $OldStatRecord['fleet_rank'];
			$OldPertesRank = $OldStatRecord['pertes_rank'];
			// Suppression de l'ancien enregistrement
			doquery ("DELETE FROM {{table}} WHERE `stat_type` = '1' AND `id_owner` = '".$CurUser['id']."';",'statpoints');
		} else {
			$OldTotalRank = 0;
			$OldTechRank  = 0;
			$OldBuildRank = 0;
			$OldDefsRank  = 0;
			$OldFleetRank = 0;
			$OldPertesRank = 0;
		}

		// Total des unit�es consomm�e pour la recherche
		$Points         = GetTechnoPoints ( $CurUser );
		$TTechCount     = $Points['TechCount'];
		$TTechPoints    = ($Points['TechPoint'] / $game_config['stat_settings']);

		// Totalisation des points accumul�s par planete
		$TBuildCount    = 0;
		$TBuildPoints   = 0;
		$TDefsCount     = 0;
		$TDefsPoints    = 0;
		$TFleetCount    = 0;
		$TFleetPoints   = 0;
		$TPertesCount    = 0;
		$TPertesPoints   = 0;
		$GCount         = $TTechCount;
		$GPoints        = $TTechPoints;
		$UsrPlanets     = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '". $CurUser['id'] ."';", 'planets');
		while ($CurPlanet = mysql_fetch_assoc($UsrPlanets) ) {
			$Points           = GetBuildPoints ( $CurPlanet );
			$TBuildCount     += $Points['BuildCount'];
			$GCount          += $Points['BuildCount'];
			$PlanetPoints     = ($Points['BuildPoint'] / $game_config['stat_settings']);
			$TBuildPoints    += ($Points['BuildPoint'] / $game_config['stat_settings']);

			$Points           = GetDefensePoints ( $CurPlanet,$CurUser );
			$TDefsCount      += $Points['DefenseCount'];
			$GCount          += $Points['DefenseCount'];
			$PlanetPoints    += ($Points['DefensePoint'] / $game_config['stat_settings']);
			$TDefsPoints     += ($Points['DefensePoint'] / $game_config['stat_settings']);

			$Points           = GetFleetPoints ( $CurPlanet,$CurUser );
			$TFleetCount     += $Points['FleetCount'];
			$GCount          += $Points['FleetCount'];
			$PlanetPoints    += ($Points['FleetPoint'] / $game_config['stat_settings']);
			$TFleetPoints    += ($Points['FleetPoint'] / $game_config['stat_settings']);

			$pertetotal = $CurUser['p_infligees'];
			//si il est negative
			if($pertetotal < 0)
			{
				$pertetotal = 0;
			}
			
			$TPertesCount     = 0;
			$GCount           = $Points['PertesCount'];
			$TPertesPoints    = ($pertetotal / $game_config['stat_settings']);
			

			$TPertesCount     += $Points['PertesCount'];
						
			$GPoints         += $PlanetPoints;
			$QryUpdatePlanet  = "UPDATE {{table}} SET ";
			$QryUpdatePlanet .= "`points` = '". $PlanetPoints ."' ";
			$QryUpdatePlanet .= "WHERE ";
			$QryUpdatePlanet .= "`id` = '". $CurPlanet['id'] ."';";
			doquery ( $QryUpdatePlanet , 'planets');
		}

		$QryInsertStats  = "INSERT INTO {{table}} SET ";
		$QryInsertStats .= "`id_owner` = '". $CurUser['id'] ."', ";
		$QryInsertStats .= "`id_ally` = '". $CurUser['ally_id'] ."', ";
		$QryInsertStats .= "`stat_type` = '1', "; // 1 pour joueur , 2 pour alliance
		$QryInsertStats .= "`stat_code` = '1', "; // de 1 a 2 mis a jour de maniere automatique
		$QryInsertStats .= "`tech_points` = '". $TTechPoints ."', ";
		$QryInsertStats .= "`tech_count` = '". $TTechCount ."', ";
		// $QryInsertStats .= "`tech_old_rank` = '". $OldTechRank ."', ";
		$QryInsertStats .= "`build_points` = '". $TBuildPoints ."', ";
		$QryInsertStats .= "`build_count` = '". $TBuildCount ."', ";
		// $QryInsertStats .= "`build_old_rank` = '". $OldBuildRank ."', ";
		$QryInsertStats .= "`defs_points` = '". $TDefsPoints ."', ";
		$QryInsertStats .= "`defs_count` = '". $TDefsCount ."', ";
		// $QryInsertStats .= "`defs_old_rank` = '". $OldDefsRank ."', ";
		$QryInsertStats .= "`fleet_points` = '". $TFleetPoints ."', ";
		$QryInsertStats .= "`fleet_count` = '". $TFleetCount ."', ";
		// $QryInsertStats .= "`fleet_old_rank` = '". $OldFleetRank ."', ";
		$QryInsertStats .= "`pertes_points` = `pertes_points` + '". $TPertesPoints ."', ";
		$QryInsertStats .= "`pertes_count` = '". $TPertesCount ."', ";
		// $QryInsertStats .= "`pertes_old_rank` = '". $OldPertesRank ."', ";
		$QryInsertStats .= "`total_points` = '". $GPoints ."', ";
		$QryInsertStats .= "`total_count` = '". $GCount ."', ";
		// $QryInsertStats .= "`total_old_rank` = '". $OldTotalRank ."', ";
		$QryInsertStats .= "`stat_date` = '". $StatDate ."';";
		doquery ( $QryInsertStats , 'statpoints');
	}

	$Rank           = 1;
	$RankQry        = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' ORDER BY `tech_points` DESC;", 'statpoints');
	while ($TheRank = mysql_fetch_assoc($RankQry) ) {
		$QryUpdateStats  = "UPDATE {{table}} SET ";
		$QryUpdateStats .= "`tech_rank` = '". $Rank ."' ";
		$QryUpdateStats .= "WHERE ";
		$QryUpdateStats .= " `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $TheRank['id_owner'] ."';";
		doquery ( $QryUpdateStats , 'statpoints');
		$Rank++;
	}

	$Rank           = 1;
	$RankQry        = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' ORDER BY `build_points` DESC;", 'statpoints');
	while ($TheRank = mysql_fetch_assoc($RankQry) ) {
		$QryUpdateStats  = "UPDATE {{table}} SET ";
		$QryUpdateStats .= "`build_rank` = '". $Rank ."' ";
		$QryUpdateStats .= "WHERE ";
		$QryUpdateStats .= " `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $TheRank['id_owner'] ."';";
		doquery ( $QryUpdateStats , 'statpoints');
		$Rank++;
	}

	$Rank           = 1;
	$RankQry        = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' ORDER BY `defs_points` DESC;", 'statpoints');
	while ($TheRank = mysql_fetch_assoc($RankQry) ) {
		$QryUpdateStats  = "UPDATE {{table}} SET ";
		$QryUpdateStats .= "`defs_rank` = '". $Rank ."' ";
		$QryUpdateStats .= "WHERE ";
		$QryUpdateStats .= " `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $TheRank['id_owner'] ."';";
		doquery ( $QryUpdateStats , 'statpoints');
		$Rank++;
	}

	$Rank           = 1;
	$RankQry        = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' ORDER BY `fleet_points` DESC;", 'statpoints');
	while ($TheRank = mysql_fetch_assoc($RankQry) ) {
		$QryUpdateStats  = "UPDATE {{table}} SET ";
		$QryUpdateStats .= "`fleet_rank` = '". $Rank ."' ";
		$QryUpdateStats .= "WHERE ";
		$QryUpdateStats .= " `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $TheRank['id_owner'] ."';";
		doquery ( $QryUpdateStats , 'statpoints');
		$Rank++;
	}

	$Rank           = 1;
	$RankQry        = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' ORDER BY `pertes_points` DESC;", 'statpoints');
	while ($TheRank = mysql_fetch_assoc($RankQry) ) {
		$QryUpdateStats  = "UPDATE {{table}} SET ";
		$QryUpdateStats .= "`pertes_rank` = '". $Rank ."' ";
		$QryUpdateStats .= "WHERE ";
		$QryUpdateStats .= " `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $TheRank['id_owner'] ."';";
		doquery ( $QryUpdateStats , 'statpoints');
		$Rank++;
	}
	$Rank           = 1;
	$RankQry        = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' ORDER BY `total_points` DESC;", 'statpoints');
	while ($TheRank = mysql_fetch_assoc($RankQry) ) {
		$QryUpdateStats  = "UPDATE {{table}} SET ";
		$QryUpdateStats .= "`total_rank` = '". $Rank ."' ";
		$QryUpdateStats .= "WHERE ";
		$QryUpdateStats .= " `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $TheRank['id_owner'] ."';";
		doquery ( $QryUpdateStats , 'statpoints');
		$Rank++;
	}

	// Statistiques des alliances ...
	$GameAllys  = doquery("SELECT * FROM {{table}}", 'alliance');

	while ($CurAlly = mysql_fetch_assoc($GameAllys)) {
		// Recuperation des anciennes statistiques
		$OldStatRecord  = doquery ("SELECT * FROM {{table}} WHERE `stat_type` = '2' AND `id_owner` = '".$CurAlly['id']."';",'statpoints');
		if ($OldStatRecord) {
			$OldTotalRank = $OldStatRecord['total_rank'];
			$OldTechRank  = $OldStatRecord['tech_rank'];
			$OldBuildRank = $OldStatRecord['build_rank'];
			$OldDefsRank  = $OldStatRecord['defs_rank'];
			$OldFleetRank = $OldStatRecord['fleet_rank'];
			$OldPertesRank = $OldStatRecord['pertes_rank'];
			// Suppression de l'ancien enregistrement
			doquery ("DELETE FROM {{table}} WHERE `stat_type` = '2' AND `id_owner` = '".$CurAlly['id']."';",'statpoints');
		} else {
			$OldTotalRank = 0;
			$OldTechRank  = 0;
			$OldBuildRank = 0;
			$OldDefsRank  = 0;
			$OldFleetRank = 0;
			$OldPertesRank = 0;
		}

		// Total des unit�es consomm�e pour la recherche
		$QrySumSelect   = "SELECT ";
		$QrySumSelect  .= "SUM(`tech_points`)  as `TechPoint`, ";
		$QrySumSelect  .= "SUM(`tech_count`)   as `TechCount`, ";
		$QrySumSelect  .= "SUM(`build_points`) as `BuildPoint`, ";
		$QrySumSelect  .= "SUM(`build_count`)  as `BuildCount`, ";
		$QrySumSelect  .= "SUM(`defs_points`)  as `DefsPoint`, ";
		$QrySumSelect  .= "SUM(`defs_count`)   as `DefsCount`, ";
		$QrySumSelect  .= "SUM(`fleet_points`) as `FleetPoint`, ";
		$QrySumSelect  .= "SUM(`fleet_count`)  as `FleetCount`, ";
		$QrySumSelect  .= "SUM(`pertes_points`) as `PertesPoint`, ";
		$QrySumSelect  .= "SUM(`pertes_count`)  as `PertesCount`, ";
		$QrySumSelect  .= "SUM(`total_points`) as `TotalPoint`, ";
		$QrySumSelect  .= "SUM(`total_count`)  as `TotalCount` ";
		$QrySumSelect  .= "FROM {{table}} ";
		$QrySumSelect  .= "WHERE ";
		$QrySumSelect  .= "`stat_type` = '1' AND ";
		$QrySumSelect  .= "`id_ally` = '". $CurAlly['id'] ."';";
		$Points         = doquery( $QrySumSelect, 'statpoints', true);

		$TTechCount     = $Points['TechCount'];
		$TTechPoints    = $Points['TechPoint'];
		$TBuildCount    = $Points['BuildCount'];
		$TBuildPoints   = $Points['BuildPoint'];
		$TDefsCount     = $Points['DefsCount'];
		$TDefsPoints    = $Points['DefsPoint'];
		$TFleetCount    = $Points['FleetCount'];
		$TFleetPoints   = $Points['FleetPoint'];
		$TPertesCount    = $Points['PertesCount'];
		$TPertesPoints   = $Points['PertesPoint'];
		$GCount         = $Points['TotalCount'];
		$GPoints        = $Points['TotalPoint'];

		$QryInsertStats  = "INSERT INTO {{table}} SET ";
		$QryInsertStats .= "`id_owner` = '". $CurAlly['id'] ."', ";
		$QryInsertStats .= "`id_ally` = '0', ";
		$QryInsertStats .= "`stat_type` = '2', "; // 1 pour joueur , 2 pour alliance
		$QryInsertStats .= "`stat_code` = '1', "; // de 1 a 5 mis a jour de maniere automatique
		$QryInsertStats .= "`tech_points` = '". $TTechPoints ."', ";
		$QryInsertStats .= "`tech_count` = '". $TTechCount ."', ";
		// $QryInsertStats .= "`tech_old_rank` = '". $OldTechRank ."', ";
		$QryInsertStats .= "`build_points` = '". $TBuildPoints ."', ";
		$QryInsertStats .= "`build_count` = '". $TBuildCount ."', ";
		// $QryInsertStats .= "`build_old_rank` = '". $OldBuildRank ."', ";
		$QryInsertStats .= "`defs_points` = '". $TDefsPoints ."', ";
		$QryInsertStats .= "`defs_count` = '". $TDefsCount ."', ";
		// $QryInsertStats .= "`defs_old_rank` = '". $OldDefsRank ."', ";
		$QryInsertStats .= "`fleet_points` = '". $TFleetPoints ."', ";
		$QryInsertStats .= "`fleet_count` = '". $TFleetCount ."', ";
		// $QryInsertStats .= "`fleet_old_rank` = '". $OldFleetRank ."', ";
		$QryInsertStats .= "`pertes_points` = '". $TPertesPoints ."', ";
		$QryInsertStats .= "`pertes_count` = '". $TPertesCount ."', ";
		// $QryInsertStats .= "`pertes_old_rank` = '". $OldPertesRank ."', ";
		$QryInsertStats .= "`total_points` = '". $GPoints ."', ";
		$QryInsertStats .= "`total_count` = '". $GCount ."', ";
		// $QryInsertStats .= "`total_old_rank` = '". $OldTotalRank ."', ";
		$QryInsertStats .= "`stat_date` = '". $StatDate ."';";
		doquery ( $QryInsertStats , 'statpoints');
	}

message ( $lang['adm_done'], $lang['adm_stat_title'] );