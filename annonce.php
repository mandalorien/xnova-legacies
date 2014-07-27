<?php

define('INSIDE' , true);
define('INSTALL' , false);
require_once dirname(__FILE__) .'/common.php';

includeLang('tech');
includeLang('annonce');
$action  = $_GET['action'];
switch($action)
{
	case 'ajouter': #la page qui permet d'ajouter une annonce
	{
		$parse = $lang;
		$BodyTPL = gettemplate('annonce_add');
		break;
	}
	case 'supprimer': # la page qui permet de supprimer une annonce
	{
		$annonce = doquery("SELECT * FROM {{table}} WHERE `id` = '".intval($_GET['id'])."' ", "annonce", true);
		if($annonce['id_user'] == $user['id'])
		{
			doquery("DELETE FROM {{table}} WHERE `id` = " . intval($_GET['id']) . ";","annonce");
			message($lang['ann_delete_ok'],$lang['ann_delete_action']);
		}
		else
		{
			message($lang['ann_delete_error'],$lang['ann_delete_action']);
		}
		break;
	}
	case 'prendre': #la page qui permet de prendre une annonce en cour
	{
		# Récupération annonce
		$annonce = doquery("SELECT * FROM {{table}} WHERE `id` = '".intval($_GET['id'])."' ", "annonce", true);

		#si l'utilisateur qui prend l'annonce à assez de ressource !
		if(floatval($annonce['metals'])<= $planetrow['metal'] && floatval($annonce['cristals'])<=$planetrow['crystal'] && floatval($annonce['deuts'])<=$planetrow['deuterium'])
		{
			# Gestion ressources planète de l'annonceur
			$planetsAnnonceur = doquery("SELECT * FROM {{table}}  WHERE galaxy ='".$annonce['galaxie']."' AND system = '". $annonce['systeme'] ."' AND planet = '". $annonce['planet'] ."' AND  planet_type = '1'  ", "planets", true);

			$planetsAnnonceur['metal'] = floatval($planetsAnnonceur['metal']) - floatval($annonce["metala"]) + floatval($annonce["metals"]);
			$planetsAnnonceur['crystal'] = floatval($planetsAnnonceur['crystal']) - floatval($annonce["cristala"]) + floatval($annonce["cristals"]);
			$planetsAnnonceur['deuterium'] = floatval($planetsAnnonceur['deuterium']) - floatval($annonce["deuta"]) + floatval($annonce["deuts"]);
								
			$queryUpdate = "UPDATE {{table}} SET ";
			$queryUpdate .= " metal = '".$planetsAnnonceur['metal']."',crystal = '".$planetsAnnonceur['crystal']."',deuterium = '".$planetsAnnonceur['deuterium']."' ";
			$queryUpdate .= " WHERE galaxy = '". $annonce['galaxie'] ."' AND system = '". $annonce['systeme'] ."' AND planet = '". $annonce['planet'] ."' AND  planet_type = '1' ";
			$planete = doquery($queryUpdate, "planets");

			# Gestion ressources planète de l'acheteur
			$planetrow['metal'] = floatval($planetrow['metal']) + floatval($annonce["metala"]) - floatval($annonce["metals"]);
			$planetrow['crystal'] = floatval($planetrow['crystal']) + floatval($annonce["cristala"]) - floatval($annonce["cristals"]);
			$planetrow['deuterium'] = floatval($planetrow['deuterium']) + floatval($annonce["deuta"]) - floatval($annonce["deuts"]);
			
			$queryUpdate = "UPDATE {{table}} SET ";
			$queryUpdate .= " metal = '".$planetrow['metal']."', crystal = '".$planetrow['crystal']."', deuterium = '".$planetrow['deuterium']."' ";
			$queryUpdate .= " WHERE galaxy = '". $planetrow['galaxy'] ."' AND system = '". $planetrow['system'] ."' AND planet = '". $planetrow['planet'] ."' AND  planet_type = '".$planetrow['planet_type']."' ";
			$planete2 = doquery($queryUpdate, "planets");		

			doquery("DELETE FROM {{table}} WHERE `id` = " . intval($_GET['id']) . ";","annonce");
			message($lang['ann_take_ok'],$lang['ann_add_action']);
		}
		else
		{
			$manquemet = floatval($annonce["metals"]) - floatval($planetrow['metal']);
			$manquecri = floatval($annonce["cristals"]) - floatval($planetrow['crystal']);
			$manquedet = floatval($annonce["deuts"]) - floatval($planetrow['deuterium']);
			if($manquemet < 0){$manquemet = 0;}
			if($manquecri < 0){$manquecri = 0;}
			if($manquedet < 0){$manquedet = 0;}
			$message = sprintf($lang['ann_take_none'],$lang['ann_take_error'],pretty_number($manquemet),$lang['Metal'],pretty_number($manquecri),$lang['Crystal'],pretty_number($manquedet),$lang['Deuterium']);
			message($message,$lang['ann_add_action']);
		}
		break;
	}
	case 'enregistrer': # la page qui recupere les données pour l'ajout de l'annonce
	{						
		if(isset($_POST['ajout']))
		{	
			# on verifie que les variables existes
			if(isset($_POST['metalvendre']) && isset($_POST['cristalvendre']) && isset($_POST['deutvendre'])
			&& isset($_POST['metalsouhait'])&& isset($_POST['cristalsouhait'])&& isset($_POST['deutsouhait']))
			{
				$metalvendre = floatval($_POST['metalvendre']);
				$cristalvendre = floatval($_POST['cristalvendre']);
				$deutvendre = floatval($_POST['deutvendre']);
	
				$metalsouhait = floatval($_POST['metalsouhait']);
				$cristalsouhait = floatval($_POST['cristalsouhait']);
				$deutsouhait = floatval($_POST['deutsouhait']);
				#quel ne sont pas vides
				if($metalvendre>=0 && $cristalvendre>=0 && $deutvendre>=0
				&& $metalsouhait>=0 && $cristalsouhait>=0 && $deutsouhait>=0)
				{
						$username = htmlentities($user['username'],ENT_QUOTES,'UTF-8');
						$iduser = intval($user['id']);
						$galaxie = intval($user['galaxy']);
						$systeme = intval($user['system']);
						$planete = intval($user['planet']);

						$test = doquery("INSERT INTO {{table}} SET
												user='{$username}',
												id_user='{$iduser}',
												galaxie='{$galaxie}',
												systeme='{$systeme}',
												planet='{$planete}',
												metala='{$metalvendre}',
												cristala='{$cristalvendre}',
												deuta='{$deutvendre}',
												metals='{$metalsouhait}',
												cristals='{$cristalsouhait}',
												deuts='{$deutsouhait}'" , "annonce");
						message($lang['ann_add_ok'],$lang['ann_add_action']);
				}
				else
				{
					message($lang['ann_add_error'],$lang['ann_add_action']);
				}
			}
			else
			{
				message($lang['ann_add_error'],$lang['ann_add_action']);
			}
		}
		break;
	}
	default: #la page par default 
	{
		$annonce = doquery("SELECT * FROM {{table}} ORDER BY `id` DESC ", "annonce");
		while ($b = mysql_fetch_array($annonce))
		{
			$page2 .= '<tr><th>';
			$page2 .= htmlentities($b["user"],ENT_QUOTES,'UTF-8');
			$page2 .= '</th><th>';
			$page2 .= intval($b["galaxie"]);
			$page2 .= '</th><th>';
			$page2 .= intval($b["systeme"]);
			$page2 .= '</th><th>';
			$page2 .= pretty_number($b["metala"]);
			$page2 .= '</th><th>';
			$page2 .= pretty_number($b["cristala"]);
			$page2 .= '</th><th>';
			$page2 .= pretty_number($b["deuta"]);
			$page2 .= '</th><th>';
			$page2 .= pretty_number($b["metals"]);
			$page2 .= '</th><th>';
			$page2 .= pretty_number($b["cristals"]);
			$page2 .= '</th><th>';
			$page2 .= pretty_number($b["deuts"]);
			$page2 .= '</th><th>';
			if ($b["id_user"] == $user["id"])
			{
				$page2 .= "<a href=\"annonce.php?action=supprimer&id={$b['id']}\" style='color:red;'>".$lang['ann_delete_action']."</a>";
			}
			else
			{
				$page2 .= "<a href=\"annonce.php?action=prendre&id={$b['id']}\" style='color:lime;'>".$lang['ann_take_action']."</a>";
			}
			$page2 .= "</th></tr>";
		}
		$parse = $lang;
		$parse['List_annonce'] = $page2;
		$BodyTPL = gettemplate('annonce_body');
		break;
	}
}
	
$page = parsetemplate($BodyTPL, $parse);
display($page,"annonce", true);