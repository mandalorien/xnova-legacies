<?php
// Attaque groupée
				function MissionCaseACS($FleetRow)
				{
					global $pricelist, $lang, $resource, $CombatCaps, $game_config;

					if ($FleetRow['fleet_mess'] == 0 && $FleetRow['fleet_start_time'] > time())
					{
						$QryUpdateFleet  = "UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = '". intval($FleetRow['fleet_id']) ."' LIMIT 1 ;";
						doquery( $QryUpdateFleet, 'fleets');
					}
					elseif ($FleetRow['fleet_end_time'] <= time())
					{
						RestoreFleetToPlanet($FleetRow);
						doquery ('DELETE FROM {{table}} WHERE `fleet_id`='.intval($FleetRow['fleet_id']),'fleets');
					}
				}