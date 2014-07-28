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

    includeLang('records');

    $recordTpl = gettemplate('records_body');
    $headerTpl = gettemplate('records_section_header');
    $tableRows = gettemplate('records_section_rows');
    $parse['rec_title'] = $lang['rec_title'];

    $bloc['section']    = $lang['rec_build'];
    $bloc['player']     = $lang['rec_playe'];
    $bloc['level']      = $lang['rec_level'];
    $parse['building']  = parsetemplate($headerTpl, $bloc);

    $bloc['section']    = $lang['rec_specb'];
    $bloc['player']     = $lang['rec_playe'];
    $bloc['level']      = $lang['rec_level'];
    $parse['buildspe']  = parsetemplate($headerTpl, $bloc);

    $bloc['section']    = $lang['rec_techn'];
    $bloc['player']     = $lang['rec_playe'];
    $bloc['level']      = $lang['rec_level'];
    $parse['research']  = parsetemplate($headerTpl, $bloc);

    $bloc['section']    = $lang['rec_fleet'];
    $bloc['player']     = $lang['rec_playe'];
    $bloc['level']      = $lang['rec_nbre'];
    $parse['fleet']     = parsetemplate($headerTpl, $bloc);

    $bloc['section']    = $lang['rec_defes'];
    $bloc['player']     = $lang['rec_playe'];
    $bloc['level']      = $lang['rec_nbre'];
    $parse['defenses']  = parsetemplate($headerTpl, $bloc);


   foreach($lang['tech'] as $element => $elementName)
{
if(!empty($elementName) && !empty($resource[$element]))
{
	$data = array();
	$ConditionShowAdmin = SHOW_ADMIN_IN_RECORDS == 0 ? "AND u.authlevel = 0 " : "";

	if(in_array($element, $reslist['build']) || in_array($element, $reslist['fleet']) || in_array($element, $reslist['defense']))
	{
		$Qry = <<<SQL
		SELECT IF(COUNT(DISTINCT u.username)<= 3, GROUP_CONCAT(DISTINCT u.username ORDER BY u.username DESC SEPARATOR ", "),"Plus de 3 joueurs ont ce record") AS players, p.{$resource[$element]} AS level
		FROM {{table}}users AS u
		LEFT JOIN {{table}}planets AS p ON p.{$resource[$element]} = (SELECT MAX(`{$resource[$element]}`) FROM {{table}}planets AS p LEFT JOIN {{table}}users AS u ON (u.id=p.id_owner) WHERE p.{$resource[$element]} > 0 {$ConditionShowAdmin} {$ShowPlayerRecords})
		WHERE u.id = p.id_owner {$ConditionShowAdmin} {$ShowPlayerRecords}
		GROUP BY p.{$resource[$element]} ORDER BY u.username ASC
SQL;
		$record = doquery($Qry, '', true);
	}
	else if(in_array($element, $reslist['tech']))
	{
		$ShowAdminRecords = SHOW_ADMIN_IN_RECORDS == 0 ? "WHERE authlevel ='0' " : "WHERE authlevel <='3'";

		$record = doquery(sprintf(
		'SELECT IF(COUNT(u.username)<=3,GROUP_CONCAT(DISTINCT u.username ORDER BY u.username DESC SEPARATOR ", "),"Plus de 3 joueurs ont ce record") AS players, u.%1$s AS level ' .
		'FROM {{table}}users AS u ' .
		'%2$s AND u.%1$s=(SELECT MAX(u2.%1$s) FROM {{table}}users AS u2 %2$s %3$s) AND u.%1$s>0 %3$s GROUP BY u.%1$s ORDER BY u.username ASC', $resource[$element], $ShowAdminRecords,$ShowPlayerRecords), '', true);
	}
	else
	{
		continue;
	}


            $data['element'] = $elementName;
            $data['winner'] = !empty($record['players']) ? $record['players'] : '-';
            $data['count'] = intval($record['level']);

            if($element >= 0 && $element < 40 || $element == 44)
            {
                $parse['building'] .= parsetemplate($tableRows, $data);
            }
            else if($element >= 40 && $element < 100 && $element != 44)
            {
                $parse['buildspe'] .= parsetemplate($tableRows, $data);
            }
            else if($element >= 100 && $element < 200)
            {
                $parse['research'] .= parsetemplate($tableRows, $data);
            }
            else if($element >= 200 && $element < 400)
            {
                $data['count'] = number_format(intval($data['count']), 0, ',', '.');
                $parse['fleet'] .= parsetemplate($tableRows, $data);
            }
            else if($element >= 400 && $element < 600 && $element!=407 && $element!=408)
            {
                $data['count'] = number_format(intval($data['count']), 0, ',', '.');
                $parse['defenses'] .= parsetemplate($tableRows, $data);
            }
        }
    }

	if(SHOW_RECORDS == 1)
	{
		$page = parsetemplate($recordTpl, $parse);
		display($page, $lang['rec_title']);
	}
	else
	{
		message($lang['bloqued_record'],$lang['rec_title'] );
	}