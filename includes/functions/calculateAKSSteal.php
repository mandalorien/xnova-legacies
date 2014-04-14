<?php
function calculateAKSSteal($attackFleets, $defenderPlanet, $ForSim = false)
	{
		//Steal-Math by Slaver for 2Moons(http://code.google.com/p/2moons/) based on http://www.owiki.de/Beute
		global $pricelist;

		$SortFleets = array();
		foreach ($attackFleets as $FleetID => $Attacker)
		{
			foreach($Attacker['detail'] as $Element => $amount)
			{
				$SortFleets[$FleetID]        += $pricelist[$Element]['capacity'] * $amount;
			}

			$SortFleets[$FleetID]            -= $Attacker['fleet']['fleet_resource_metal'] - $Attacker['fleet']['fleet_resource_crystal'] - $Attacker['fleet']['fleet_resource_deuterium'];
		}

		$Sumcapacity              = array_sum($SortFleets);

		// Step 1
		$booty['metal']         = min(($Sumcapacity / 3),  ($defenderPlanet['metal'] / 2));
		$Sumcapacity             -= $booty['metal'];

		// Step 2
		$booty['crystal']         = min(($Sumcapacity / 2),  ($defenderPlanet['crystal'] / 2));
		$Sumcapacity             -= $booty['crystal'];

		// Step 3
		$booty['deuterium']     = min($Sumcapacity,  ($defenderPlanet['deuterium'] / 2));
		$Sumcapacity             -= $booty['deuterium'];

		// Step 4
		$oldMetalBooty             = $booty['metal'];
		$booty['metal']         += min(($Sumcapacity / 2),  max((($defenderPlanet['metal']) / 2) - $booty['metal'], 0));
		$Sumcapacity             += $oldMetalBooty - $booty['metal'];

		// Step 5
		$booty['crystal']         += min(($Sumcapacity),  max((($defenderPlanet['crystal']) / 2) - $booty['crystal'], 0));

		$booty['metal']            = max($booty['metal'] ,0);
		$booty['crystal']        = max($booty['crystal'] ,0);
		$booty['deuterium']        = max($booty['deuterium'] ,0);

		$steal                    = array_map('floor', $booty);

		if($ForSim)
			return $steal;

		$AllCapacity        = array_sum($SortFleets);
		$QryUpdateFleet        = "";

		foreach($SortFleets as $FleetID => $Capacity)
		{
			$QryUpdateFleet     = "UPDATE {{table}} SET ";
			$QryUpdateFleet .= "`fleet_resource_metal` =  `fleet_resource_metal` + '".floattostring($steal['metal'] * ($Capacity /  $AllCapacity))."', ";
			$QryUpdateFleet .= "`fleet_resource_crystal` =  `fleet_resource_crystal` +'".floattostring($steal['crystal'] * ($Capacity  / $AllCapacity))."', ";
			$QryUpdateFleet .= "`fleet_resource_deuterium` =  `fleet_resource_deuterium` +'".floattostring($steal['deuterium'] * ($Capacity / $AllCapacity))."' ";
			$QryUpdateFleet .= "WHERE fleet_id = '".$FleetID."' ";
			$QryUpdateFleet .= "LIMIT 1;";
			doquery($QryUpdateFleet, 'fleets');

		}

		return $steal;
	}