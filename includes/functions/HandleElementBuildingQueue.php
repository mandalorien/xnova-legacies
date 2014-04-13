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
 *                                --//NOTICE <--
 *  This file is part of the core development branch, changing its contents will
 * make you unable to use the automatic updates manager. Please refer to the
 * documentation for further information about customizing XNova.
 *
 */

   function HandleElementBuildingQueue ( $CurrentUser, &$CurrentPlanet, $ProductionTime )
    {
        global $resource;

        if ($CurrentPlanet['b_hangar_id'] != 0)
        {
            $Builded                    = array ();
            $CurrentPlanet['b_hangar'] += $ProductionTime;
            $BuildQueue                 = explode(';', $CurrentPlanet['b_hangar_id']);
            $BuildArray                    = array();

            foreach ($BuildQueue as $Node => $Array)
            {
                if ($Array != '')
                {
                    $Item              = explode(',', $Array);
                    $AcumTime           = GetBuildingTime ($CurrentUser, $CurrentPlanet, $Item[0]);
                    $BuildArray[$Node] = array($Item[0], $Item[1], $AcumTime);
                }
            }

            $CurrentPlanet['b_hangar_id']     = '';
            $UnFinished                     = false;
                    foreach ( $BuildArray as $Node => $Item ){
                        $Element   = $Item[0];
                        $Count     = $Item[1];
                        $BuildTime = $Item[2];
                        $Builded[$Element] = 0;
                        if (!$UnFinished and $BuildTime > 0){
                            $AllTime = $BuildTime * $Count;
                            if($CurrentPlanet['b_hangar'] >= $BuildTime){
                                $Done = min($Count, floor( $CurrentPlanet['b_hangar'] / $BuildTime));
                                if($Count > $Done){
                                    $CurrentPlanet['b_hangar'] -= $BuildTime * $Done;                                
                                    $UnFinished = true;    
                                    $Count -= $Done;                                                        
                                }else{
                                    $CurrentPlanet['b_hangar'] -= $AllTime;                                        
                                    $Count = 0;
                                }
                                $Builded[$Element] += $Done;
                                $CurrentPlanet[$resource[$Element]] += $Done;
                            }else{
                                $UnFinished = true;    
                            }
                        }elseif(!$UnFinished){    
                                $Builded[$Element] += $Count;
                                $CurrentPlanet[$resource[$Element]] += $Count;                                
                                $Count = 0;                            
                        }
                        if ( $Count != 0 ){
                            $CurrentPlanet['b_hangar_id'] .= $Element.",".$Count.";";
                        }
                    }
        }
        else
        {
            $Builded                   = '';
            $CurrentPlanet['b_hangar'] = 0;
        }

        return $Builded;
    }