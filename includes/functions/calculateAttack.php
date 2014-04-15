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
 
    function calculateAttack (&$attackers, &$defenders)
    {
        global $pricelist, $CombatCaps, $game_config, $resource;

        $totalResourcePoints = array('attacker' => 0, 'defender' => 0);
        $resourcePointsAttacker = array('metal' => 0, 'crystal' => 0);

        foreach ($attackers as $fleetID => $attacker) {
            foreach ($attacker['detail'] as $element => $amount) {
                $resourcePointsAttacker['metal'] += $pricelist[$element]['metal'] * $amount;
                $resourcePointsAttacker['crystal'] += $pricelist[$element]['crystal'] * $amount ;

                $totalResourcePoints['attacker'] += $pricelist[$element]['metal'] * $amount ;
                $totalResourcePoints['attacker'] += $pricelist[$element]['crystal'] * $amount ;
            }
        }

        $resourcePointsDefender = array('metal' => 0, 'crystal' => 0);
        foreach ($defenders as $fleetID => $defender) {
            foreach ($defender['def'] as $element => $amount) {                                //Line20
                if ($element < 300) {
                    $resourcePointsDefender['metal'] += $pricelist[$element]['metal'] * $amount ;
                    $resourcePointsDefender['crystal'] += $pricelist[$element]['crystal'] * $amount ;

                    $totalResourcePoints['defender'] += $pricelist[$element]['metal'] * $amount ;
                    $totalResourcePoints['defender'] += $pricelist[$element]['crystal'] * $amount ;
                } else {
                    if (!isset($originalDef[$element])) $originalDef[$element] = 0;
                    $originalDef[$element] += $amount;

                    $totalResourcePoints['defender'] += $pricelist[$element]['metal'] * $amount ;
                    $totalResourcePoints['defender'] += $pricelist[$element]['crystal'] * $amount ;
                }
            }
        }

		$max_rounds = 6;

        for ($round = 0, $rounds = array(); $round < $max_rounds; $round++) {
            $attackDamage  = array('total' => 0);
            $attackShield  = array('total' => 0);
            $attackAmount  = array('total' => 0);
            $defenseDamage = array('total' => 0);
            $defenseShield = array('total' => 0);
            $defenseAmount = array('total' => 0);
            $attArray = array();
            $defArray = array();

            foreach ($attackers as $fleetID => $attacker) {
                $attackDamage[$fleetID] = 0;
                $attackShield[$fleetID] = 0;
                $attackAmount[$fleetID] = 0;

                foreach ($attacker['detail'] as $element => $amount) {
                    $attTech    = (1 + (0.1 * ($attacker['user']['military_tech']) + (0.05 * $attacker['user']['rpg_amiral']))); //attaque
                    $defTech    = (1 + (0.1 * ($attacker['user']['defence_tech']) + (0.05 * $attacker['user']['rpg_amiral']))); //bouclier
                    $shieldTech = (1 + (0.1 * ($attacker['user']['shield_tech']) + (0.05 * $attacker['user']['rpg_amiral']))); //coque

                    $attackers[$fleetID]['techs'] = array($shieldTech, $defTech, $attTech);

                    $thisAtt    = $amount * ($CombatCaps[$element]['attack']) * $attTech; //attaque
                    $thisDef    = $amount * ($CombatCaps[$element]['shield']) * $defTech ; //bouclier
                    $thisShield    = $amount * ($pricelist[$element]['metal'] + $pricelist[$element]['crystal']) / 10 * $shieldTech; //coque

                    $attArray[$fleetID][$element] = array('def' => $thisDef, 'shield' => $thisShield, 'att' => $thisAtt);

                    $attackDamage[$fleetID] += $thisAtt;
                    $attackDamage['total'] += $thisAtt;
                    $attackShield[$fleetID] += $thisDef;
                    $attackShield['total'] += $thisDef;
                    $attackAmount[$fleetID] += $amount;
                    $attackAmount['total'] += $amount;
                }
            }

            foreach ($defenders as $fleetID => $defender) {
                $defenseDamage[$fleetID] = 0;
                $defenseShield[$fleetID] = 0;
                $defenseAmount[$fleetID] = 0;

                foreach ($defender['def'] as $element => $amount) {
                    $attTech    = (1 + (0.1 * ($defender['user']['military_tech']) + (0.05 * $defender['user']['rpg_amiral']))); //attaquue
                    $defTech    = (1 + (0.1 * ($defender['user']['defence_tech']) + (0.05 * $defender['user']['rpg_amiral']))); //bouclier
                    $shieldTech = (1 + (0.1 * ($defender['user']['shield_tech']) + (0.05 * $defender['user']['rpg_amiral']))); //coque

                    $defenders[$fleetID]['techs'] = array($shieldTech, $defTech, $attTech);

                    $thisAtt    = $amount * ($CombatCaps[$element]['attack']) * $attTech; //attaque
                    $thisDef    = $amount * ($CombatCaps[$element]['shield']) * $defTech ; //bouclier
                    $thisShield    = $amount * ($pricelist[$element]['metal'] + $pricelist[$element]['crystal']) / 10 * $shieldTech; //coque

                    if ($element == 407 || $element == 408 || $element == 409) $thisAtt = 0;

                    $defArray[$fleetID][$element] = array('def' => $thisDef, 'shield' => $thisShield, 'att' => $thisAtt);

                    $defenseDamage[$fleetID] += $thisAtt;
                    $defenseDamage['total'] += $thisAtt;
                    $defenseShield[$fleetID] += $thisDef;
                    $defenseShield['total'] += $thisDef;
                    $defenseAmount[$fleetID] += $amount;
                    $defenseAmount['total'] += $amount;
                }
            }

            $rounds[$round] = array('attackers' => $attackers, 'defenders' => $defenders, 'attack' => $attackDamage, 'defense' => $defenseDamage, 'attackA' => $attackAmount, 'defenseA' => $defenseAmount, 'infoA' => $attArray, 'infoD' => $defArray);

            if ($defenseAmount['total'] <= 0 || $attackAmount['total'] <= 0) {
                break;
            }

            // Calculate hit percentages (ACS only but ok)
            $attackPct = array();
            foreach ($attackAmount as $fleetID => $amount) {
                if (!is_numeric($fleetID)) continue;
                $attackPct[$fleetID] = $amount / $attackAmount['total'];
            }

            $defensePct = array();
            foreach ($defenseAmount as $fleetID => $amount) {
                if (!is_numeric($fleetID)) continue;
                $defensePct[$fleetID] = $amount / $defenseAmount['total'];
            }

            $defender_n = array();
            $defender_shield = 0;

            foreach ($defenders as $fleetID => $defender) {
                $defender_n[$fleetID] = array();

                foreach($defender['def'] as $element => $amount) {
                    $attacker_moc = $amount * $attackDamage['total'] / $defenseAmount[$fleetID];#la puissance de l'attaquant
                    if ($amount > 0) {
                        if ($defArray[$fleetID][$element]['def'] <= $attacker_moc) { #si le bouclier du defenseur est plus petit ou égale a la puissance de l'attaquant 
                            
							$defender_shield =$defender_shield + $defArray[$fleetID][$element]['def'];
							$attacker_moc -= $defArray[$fleetID][$element]['def'];
							
							if($defArray[$fleetID][$element]['shield'] > $attacker_moc) #si la coque du defenseur est plus grand que la puissance de l'attaquant
							{						
								
								$coque = $defArray[$fleetID][$element]['shield'] - $attacker_moc;
								$calc = $coque/$defArray[$fleetID][$element]['shield'];
								
								if($calc>=1)
								{
									$calc = 1;
								}
								
								var_dump($RShipDef);
								$RShipDef = round(($calc) * $amount);
								$defender_n[$fleetID][$element] = $RShipDef;

								var_dump($defender_n[$fleetID][$element]);
								if ($defender_n[$fleetID][$element] <= 0)
								{
									$defender_n[$fleetID][$element] = 0;
								}

							} else {
								$defender_n[$fleetID][$element] = 0;
								$defender_shield = 0;
							}
						}
						else #si le bouclier du defenseur est plus grand a la puissance de l'attaquant  
						{
							$defender_n[$fleetID][$element] = $amount;
							$defender_shield = $defender_shield + $attacker_moc;
						}
					} 
					else #si il n'y a plus de vaisseaux 
					{
						$defender_n[$fleetID][$element] = 0;
						$defender_shield = 0;
					}
            }
		}

			// CALCUL DES PERTES !!!
            $attacker_n = array();
            $attacker_shield = 0;
            foreach ($attackers as $fleetID => $attacker) {
                $attacker_n[$fleetID] = array();

                foreach($attacker['detail'] as $element => $amount) {
                    $defender_moc = $amount * $defenseDamage['total'] / $attackAmount[$fleetID];  #la puissance de du defenseur

                    if ($amount > 0) {
                        if ($attArray[$fleetID][$element]['def'] <= $defender_moc) {#si le bouclier de l'attaquant est plus petit ou égale a la puissance du def
						
							$attacker_shield =$attacker_shield + $attArray[$fleetID][$element]['def'];
                            $defender_moc -= $attArray[$fleetID][$element]['def'];
                            
							if($attArray[$fleetID][$element]['shield'] > $defender_moc)#si la coque de l'attaquant est plus grand que la puissance de l'attaquant
							{
								// on soustrait la valeur de la coque attaquante a la puissance du defenseur
								$coque = ($attArray[$fleetID][$element]['shield']) - $defender_moc;
								
								$calc = $coque/$attArray[$fleetID][$element]['shield'];
								
								if($calc >= 1)
								{
									$calc = 1;
								}
								$RShipAtt = round(($calc) * $amount);
								$attacker_n[$fleetID][$element] = $RShipAtt;
								
								if ($attacker_n[$fleetID][$element] <= 0)
								{
									$attacker_n[$fleetID][$element] = 0;
								}
							} else {
								$attacker_n[$fleetID][$element] = 0;
								$attacker_shield = 0;
							}
						}
						else #si le bouclier du defenseur est plus grand a la puissance de l'attaquant  
						{
							$attacker_n[$fleetID][$element] = $amount;
							$attacker_shield = $attacker_shield + $defender_moc;
						}
					} 
					else #si il n'y a plus de vaisseaux 
					{
						$attacker_n[$fleetID][$element] = 0;
						$attacker_shield = 0;
					}
            }
		}

            // "Rapidfire"
            foreach ($attackers as $fleetID => $attacker) {
                foreach ($defenders as $fleetID2 => $defender) {
                    foreach($attacker['detail'] as $element => $amount) {
                        if ($amount > 0) {
                            foreach ($CombatCaps[$element]['sd'] as $c => $d) {
								if($defender['def'][$c]!='0' || $defender['def'][$c]!=null)
								{
									if($d > 1) {
										$rapidfire = true;
									}
								}
							}
							
							
							while($rapidfire)
							{
								$randEntier = rand(0,100);
								$randDecimal = rand(0,99);
								$pourcentage = $randEntier + ($randDecimal / 100);
								foreach ($CombatCaps[$element]['sd'] as $c => $d) {
									if($defender['def'][$c]!='0' || $defender['def'][$c]!=null)
									{
										if($pourcentage < 100*(1 - ( 1 / $CombatCaps[$element]['sd'][$c])))
										{
											if ($defenseAmount[$fleetID2] > 0)
											{
												$attacker_moc = $amount * $attackDamage['total'] / $defenseAmount[$fleetID2];#la puissance de l'attaquant

												$newcoque = $defArray[$fleetID2][$c]['shield'] / $defenseAmount[$fleetID2] * $defender_n[$fleetID2][$c];
												if($newcoque > $attacker_moc)
												{
													$coque = $newcoque - $attacker_moc;
													$calc = $coque/$newcoque;		
													if($calc >= 1)
													{
														$calc = 1;
													}

													$RFRShipDef = round(($calc) * $defenseAmount[$fleetID2]);
													$enleDEF = ($defenseAmount[$fleetID2] - $RFRShipDef);
													$defenseAmount[$fleetID2] -= $RFRShipDef - $enleDEF;
													if ($defender_n[$fleetID2][$c] <= 0) {
															$defender_n[$fleetID2][$c] = 0;
													}
												}
											} else {
												$defender_n[$fleetID2][$c] = $defenseAmount[$fleetID2];
												$defender_shield = $defender_shield + $attacker_moc;
											}		
										} else{
											$rapidfire = false;
										}
									}
								}
							}
						}
					}
				}
			}
			
            // "Rapidfire"
            foreach ($defenders as $fleetID => $defender) {
                foreach ($attackers as $fleetID2 => $attacker) {
                    foreach($defender['def'] as $element => $amount) {
                        if ($amount > 0) {
                            foreach ($CombatCaps[$element]['sd'] as $c => $d) {
								if($attacker['def'][$c]!='0' || $attacker['def'][$c]!=null)
								{
									if($d > 1) {
										$rapidfire = true;
									}
								}
							}
							while($rapidfire)
							{
								$randEntier = rand(0,100);
								$randDecimal = rand(0,99);
								$pourcentage = $randEntier + ($randDecimal / 100);
								foreach ($CombatCaps[$element]['sd'] as $c => $d) {
									if($attacker['def'][$c]!='0' || $attacker['def'][$c]!=null)
									{
										if($pourcentage < 100*(1 - ( 1 / $CombatCaps[$element]['sd'][$c])))
										{
											if ($attackAmount[$fleetID2] > 0)
											{
												$defender_moc = $amount * $defenseDamage['total'] / $attackAmount[$fleetID2];#la puissance de l'attaquant

												$newcoque = $attArray[$fleetID2][$c]['shield'] / $attackAmount[$fleetID2] * $attacker_n[$fleetID2][$c];
												if($newcoque > $defender_moc)
												{
													$coque = $newcoque - $defender_moc;
													$calc = $coque/$newcoque;		
													if($calc >= 1)
													{
														$calc = 1;
													}

													$RFRShipAtt = round(($calc) * $attackAmount[$fleetID2]);
													$enleATT = ($attackAmount[$fleetID2] - $RFRShipAtt);
													$attackAmount[$fleetID2] -= $RFRShipAtt - $enleATT;
													if ($attacker_n[$fleetID2][$c] <= 0) {
															$attacker_n[$fleetID2][$c] = 0;
													}
												}
											} else {
												$attacker_n[$fleetID2][$c] = $attackAmount[$fleetID2];
												$attacker_shield = $attacker_shield + $defender_moc;
											}		
										} else{
											$rapidfire = false;
										}
									}
								}
							}
						}
					}
				}
			}		
		


            $rounds[$round]['attackShield'] = $attacker_shield;
            $rounds[$round]['defShield'] = $defender_shield;

            foreach ($attackers as $fleetID => $attacker) {
                $attackers[$fleetID]['detail'] = array_map('round', $attacker_n[$fleetID]);
            }

            foreach ($defenders as $fleetID => $defender) {
                $defenders[$fleetID]['def'] = array_map('round', $defender_n[$fleetID]);
            }
        }

        if ($attackAmount['total'] <= 0) {
            $won = "r"; // defender

        } elseif ($defenseAmount['total'] <= 0) {
            $won = "a"; // attacker

        } else {
            $won = "w"; // draw
            $rounds[count($rounds)] = array('attackers' => $attackers, 'defenders' => $defenders, 'attack' => $attackDamage, 'defense' => $defenseDamage, 'attackA' => $attackAmount, 'defenseA' => $defenseAmount);
        }

        // CDR
        foreach ($attackers as $fleetID => $attacker) {                                       // flotte attaquant en CDR
            foreach ($attacker['detail'] as $element => $amount) {
                $totalResourcePoints['attacker'] -= $pricelist[$element]['metal'] * $amount ;
                $totalResourcePoints['attacker'] -= $pricelist[$element]['crystal'] * $amount ;

                $resourcePointsAttacker['metal'] -= $pricelist[$element]['metal'] * $amount ;
                $resourcePointsAttacker['crystal'] -= $pricelist[$element]['crystal'] * $amount ;
            }
        }

        $resourcePointsDefenderDefs = array('metal' => 0, 'crystal' => 0);
        foreach ($defenders as $fleetID => $defender) {
            foreach ($defender['def'] as $element => $amount) {
                if ($element < 300) {                                                        // flotte defenseur en CDR
                    $resourcePointsDefender['metal'] -= $pricelist[$element]['metal'] * $amount ;
                    $resourcePointsDefender['crystal'] -= $pricelist[$element]['crystal'] * $amount ;

                    $totalResourcePoints['defender'] -= $pricelist[$element]['metal'] * $amount ;
                    $totalResourcePoints['defender'] -= $pricelist[$element]['crystal'] * $amount ;
                } else {                                                                    // defs defenseur en CDR + reconstruction
                    $totalResourcePoints['defender'] -= $pricelist[$element]['metal'] * $amount ;
                    $totalResourcePoints['defender'] -= $pricelist[$element]['crystal'] * $amount ;

                    $lost = $originalDef[$element] - $amount;
                    $giveback = round($lost * (rand(70*0.8, 70*1.2) / 100));
                    $defenders[$fleetID]['def'][$element] += $giveback;
                    $resourcePointsDefenderDefs['metal'] += $pricelist[$element]['metal'] * ($lost - $giveback) ;
                    $resourcePointsDefenderDefs['crystal'] += $pricelist[$element]['crystal'] * ($lost - $giveback) ;

                }
            }
        }


        $totalLost = array('att' => $totalResourcePoints['attacker'], 'def' => $totalResourcePoints['defender']);
        $debAttMet = ($resourcePointsAttacker['metal'] * ($game_config['Fleet_Cdr'] / 100));
        $debAttCry = ($resourcePointsAttacker['crystal'] * ($game_config['Fleet_Cdr'] / 100));
        $debDefMet = ($resourcePointsDefender['metal'] * ($game_config['Fleet_Cdr'] / 100)) + ($resourcePointsDefenderDefs['metal'] * ($game_config['Defs_Cdr'] / 100));
        $debDefCry = ($resourcePointsDefender['crystal'] * ($game_config['Fleet_Cdr'] / 100)) + ($resourcePointsDefenderDefs['crystal'] * ($game_config['Defs_Cdr'] / 100));

        return array('won' => $won, 'debree' => array('att' => array($debAttMet, $debAttCry), 'def' => array($debDefMet, $debDefCry)), 'rw' => $rounds, 'lost' => $totalLost);
    }
?>