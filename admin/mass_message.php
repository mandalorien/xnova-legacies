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
define('IN_ADMIN', true);

function mass_message_run($parent){
	if($_POST["mode"] == "change"){
		if(isset($_POST["tresc"])&& $_POST["tresc"] != ''){
			$game_config['tresc'] = $parent->safe_get_post_var("tresc");
		}
		if(isset($_POST["temat"])&& $_POST["temat"] != ''){
			$game_config['temat'] = $parent->safe_get_post_var("temat");
		}
		$kolor = 'red';
		if($game_config['tresc'] !='' and $game_config['temat']){
			$sq = $parent->db->query("SELECT `id` FROM {{table}}","users");
			while($u = $parent->db->fetch_assoc($sq)){
				doquery("INSERT INTO {{table}} SET
					`message_owner`='{$u['id']}',
					`message_sender`='1' ,
					`message_time`='".time()."',
					`message_type`='0',
					`message_from`='<font color=\"$kolor\">Administracja</font>',
					`message_subject`='<font color=\"$kolor\">{$game_config['temat']}</font>',
					`message_text`='<font color=\"$kolor\"><b>{$game_config['tresc']}</b></font>'
					","messages");
				$parent->db->query("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$u['id']}'",'users');
			}
			$parent->smarty->assign("message","<font color=\"lime\">Wys�a�e� wiadomo�� do wszystkich graczy</font>");
		}
	}
	$parent->smarty->display("mass_message.tpl");
}

function mass_message_info(){
	return array("name" => "Send MassMessages","description"=>"Sends messagess to all players","default_weight"=>"0");
}