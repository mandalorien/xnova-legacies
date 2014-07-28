<?php
/**
 * This file is part of XNova:Legacies
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @see http://www.nacatikx.dafun.com/forum/index.php
 *
 * Copyright (c) 2012-Present, mandalorien <https://github.com/mandalorien/xnova-legacies>
 * All rights reserved.
 *
 */

class game_users extends BaseModel
{
    /**
     * @var null|PDOStatement
     */
    private $_selectAllStatement = null;

    /**
     * @var null|PDOStatement
     */
    private $_selectStatement = null;

    /**
     * @var null|PDOStatement
     */
    private $_insertStatement = null;

    /**
     * @var null|PDOStatement
     */
    private $_updateStatement = null;

    /**
     * @var null|PDOStatement
     */
    private $_deleteStatement = null;

    /**
     * @var null|PDOStatement
     */
    private $_deleteoneStatement = null;
	
    public function __destruct()
    {
        if ($this->_selectAllStatement !== null) {
            $this->_selectAllStatement->closeCursor();
            $this->_selectAllStatement = null;
        }

        if ($this->_selectStatement !== null) {
            $this->_selectStatement->closeCursor();
            $this->_selectStatement = null;
        }

        if ($this->_insertStatement !== null) {
            $this->_insertStatement->closeCursor();
            $this->_insertStatement = null;
        }

        if ($this->_updateStatement !== null) {
            $this->_updateStatement->closeCursor();
            $this->_updateStatement = null;
        }

        if ($this->_deleteStatement !== null) {
            $this->_deleteStatement->closeCursor();
            $this->_deleteStatement = null;
        }
		
        if ($this->_deleteoneStatement !== null) {
            $this->_deleteoneStatement->closeCursor();
            $this->_deleteoneStatement = null;
        }
	}
	


	
		/**
		 * @return PDOStatement
		 */
		protected function _getSelectAllStatement()
		{
			if ($this->_selectAllStatement === null) {
				$this->_selectAllStatement = $this->getReadAdapter()
					->prepare('SELECT * FROM game_users ORDER BY `id` DESC');
			}

			return $this->_selectAllStatement;
		}

		/**
		 * @return array
		 */
		public function selectAll()
		{
			$statement = $this->_getSelectAllStatement();
			$statement->execute();

			return $statement->fetchAll();
		}

   /**
     * @return PDOStatement
     */
    protected function _getSelectStatement()
    {
        if ($this->_selectStatement === null) {
            $this->_selectStatement = $this->getReadAdapter()
                ->prepare('SELECT * FROM game_users WHERE `id`=:id or`username`=:username or`password`=:password or`email`=:email or`email_2`=:email_2 or`lang`=:lang or`authlevel`=:authlevel or`sex`=:sex or`avatar`=:avatar or`sign`=:sign or`id_planet`=:id_planet or`galaxy`=:galaxy or`system`=:system or`planet`=:planet or`current_planet`=:current_planet or`user_lastip`=:user_lastip or`ip_at_reg`=:ip_at_reg or`user_agent`=:user_agent or`current_page`=:current_page or`register_time`=:register_time or`onlinetime`=:onlinetime or`json_time`=:json_time or`dpath`=:dpath or`design`=:design or`noipcheck`=:noipcheck or`planet_sort`=:planet_sort or`planet_sort_order`=:planet_sort_order or`spio_anz`=:spio_anz or`settings_tooltiptime`=:settings_tooltiptime or`settings_fleetactions`=:settings_fleetactions or`settings_allylogo`=:settings_allylogo or`settings_esp`=:settings_esp or`settings_wri`=:settings_wri or`settings_bud`=:settings_bud or`settings_mis`=:settings_mis or`settings_rep`=:settings_rep or`urlaubs_modus`=:urlaubs_modus or`urlaubs_until`=:urlaubs_until or`db_deaktjava`=:db_deaktjava or`new_message`=:new_message or`fleet_shortcut`=:fleet_shortcut or`b_tech_planet`=:b_tech_planet or`b_tech`=:b_tech or`b_tech_id`=:b_tech_id or`spy_tech`=:spy_tech or`computer_tech`=:computer_tech or`military_tech`=:military_tech or`defence_tech`=:defence_tech or`shield_tech`=:shield_tech or`energy_tech`=:energy_tech or`hyperspace_tech`=:hyperspace_tech or`combustion_tech`=:combustion_tech or`impulse_motor_tech`=:impulse_motor_tech or`hyperspace_motor_tech`=:hyperspace_motor_tech or`laser_tech`=:laser_tech or`ionic_tech`=:ionic_tech or`buster_tech`=:buster_tech or`intergalactic_tech`=:intergalactic_tech or`expedition_tech`=:expedition_tech or`graviton_tech`=:graviton_tech or`ally_id`=:ally_id or`ally_name`=:ally_name or`ally_request`=:ally_request or`ally_request_text`=:ally_request_text or`ally_register_time`=:ally_register_time or`ally_rank_id`=:ally_rank_id or`current_luna`=:current_luna or`kolorminus`=:kolorminus or`kolorplus`=:kolorplus or`kolorpoziom`=:kolorpoziom or`rpg_geologue`=:rpg_geologue or`rpg_amiral`=:rpg_amiral or`rpg_ingenieur`=:rpg_ingenieur or`rpg_technocrate`=:rpg_technocrate or`rpg_espion`=:rpg_espion or`rpg_constructeur`=:rpg_constructeur or`rpg_scientifique`=:rpg_scientifique or`rpg_commandant`=:rpg_commandant or`rpg_points`=:rpg_points or`rpg_stockeur`=:rpg_stockeur or`rpg_defenseur`=:rpg_defenseur or`rpg_destructeur`=:rpg_destructeur or`rpg_general`=:rpg_general or`rpg_bunker`=:rpg_bunker or`rpg_raideur`=:rpg_raideur or`rpg_empereur`=:rpg_empereur or`lvl_minier`=:lvl_minier or`lvl_raid`=:lvl_raid or`xpraid`=:xpraid or`xpminier`=:xpminier or`raids`=:raids or`p_infligees`=:p_infligees or`mnl_alliance`=:mnl_alliance or`mnl_joueur`=:mnl_joueur or`mnl_attaque`=:mnl_attaque or`mnl_spy`=:mnl_spy or`mnl_exploit`=:mnl_exploit or`mnl_transport`=:mnl_transport or`mnl_expedition`=:mnl_expedition or`mnl_general`=:mnl_general or`mnl_buildlist`=:mnl_buildlist or`bana`=:bana or`multi_validated`=:multi_validated or`banaday`=:banaday or`raids1`=:raids1 or`raidswin`=:raidswin or`raidsloose`=:raidsloose  LIMIT 1');
        }

        return $this->_selectStatement;
    }

    public function select($id,$username,$password,$email,$email_2,$lang,$authlevel,$sex,$avatar,$sign,$id_planet,$galaxy,$system,$planet,$current_planet,$user_lastip,$ip_at_reg,$user_agent,$current_page,$register_time,$onlinetime,$json_time,$dpath,$design,$noipcheck,$planet_sort,$planet_sort_order,$spio_anz,$settings_tooltiptime,$settings_fleetactions,$settings_allylogo,$settings_esp,$settings_wri,$settings_bud,$settings_mis,$settings_rep,$urlaubs_modus,$urlaubs_until,$db_deaktjava,$new_message,$fleet_shortcut,$b_tech_planet,$b_tech,$b_tech_id,$spy_tech,$computer_tech,$military_tech,$defence_tech,$shield_tech,$energy_tech,$hyperspace_tech,$combustion_tech,$impulse_motor_tech,$hyperspace_motor_tech,$laser_tech,$ionic_tech,$buster_tech,$intergalactic_tech,$expedition_tech,$graviton_tech,$ally_id,$ally_name,$ally_request,$ally_request_text,$ally_register_time,$ally_rank_id,$current_luna,$kolorminus,$kolorplus,$kolorpoziom,$rpg_geologue,$rpg_amiral,$rpg_ingenieur,$rpg_technocrate,$rpg_espion,$rpg_constructeur,$rpg_scientifique,$rpg_commandant,$rpg_points,$rpg_stockeur,$rpg_defenseur,$rpg_destructeur,$rpg_general,$rpg_bunker,$rpg_raideur,$rpg_empereur,$lvl_minier,$lvl_raid,$xpraid,$xpminier,$raids,$p_infligees,$mnl_alliance,$mnl_joueur,$mnl_attaque,$mnl_spy,$mnl_exploit,$mnl_transport,$mnl_expedition,$mnl_general,$mnl_buildlist,$bana,$multi_validated,$banaday,$raids1,$raidswin,$raidsloose)
    {
		// securité
		$selectid = $id;
		$selectusername = $username;
		$selectpassword = $password;
		$selectemail = $email;
		$selectemail_2 = $email_2;
		$selectlang = $lang;
		$selectauthlevel = $authlevel;
		$selectsex = $sex;
		$selectavatar = $avatar;
		$selectsign = $sign;
		$selectid_planet = intval($id_planet);
		$selectgalaxy = intval($galaxy);
		$selectsystem = intval($system);
		$selectplanet = intval($planet);
		$selectcurrent_planet = intval($current_planet);
		$selectuser_lastip = $user_lastip;
		$selectip_at_reg = $ip_at_reg;
		$selectuser_agent = $user_agent;
		$selectcurrent_page = $current_page;
		$selectregister_time = intval($register_time);
		$selectonlinetime = intval($onlinetime);
		$selectjson_time = intval($json_time);
		$selectdpath = $dpath;
		$selectdesign = $design;
		$selectnoipcheck = $noipcheck;
		$selectplanet_sort = $planet_sort;
		$selectplanet_sort_order = $planet_sort_order;
		$selectspio_anz = $spio_anz;
		$selectsettings_tooltiptime = $settings_tooltiptime;
		$selectsettings_fleetactions = $settings_fleetactions;
		$selectsettings_allylogo = $settings_allylogo;
		$selectsettings_esp = $settings_esp;
		$selectsettings_wri = $settings_wri;
		$selectsettings_bud = $settings_bud;
		$selectsettings_mis = $settings_mis;
		$selectsettings_rep = $settings_rep;
		$selecturlaubs_modus = $urlaubs_modus;
		$selecturlaubs_until = intval($urlaubs_until);
		$selectdb_deaktjava = $db_deaktjava;
		$selectnew_message = intval($new_message);
		$selectfleet_shortcut = $fleet_shortcut;
		$selectb_tech_planet = intval($b_tech_planet);
		$selectb_tech = intval($b_tech);
		$selectb_tech_id = $b_tech_id;
		$selectspy_tech = intval($spy_tech);
		$selectcomputer_tech = intval($computer_tech);
		$selectmilitary_tech = intval($military_tech);
		$selectdefence_tech = intval($defence_tech);
		$selectshield_tech = intval($shield_tech);
		$selectenergy_tech = intval($energy_tech);
		$selecthyperspace_tech = intval($hyperspace_tech);
		$selectcombustion_tech = intval($combustion_tech);
		$selectimpulse_motor_tech = intval($impulse_motor_tech);
		$selecthyperspace_motor_tech = intval($hyperspace_motor_tech);
		$selectlaser_tech = intval($laser_tech);
		$selectionic_tech = intval($ionic_tech);
		$selectbuster_tech = intval($buster_tech);
		$selectintergalactic_tech = intval($intergalactic_tech);
		$selectexpedition_tech = intval($expedition_tech);
		$selectgraviton_tech = intval($graviton_tech);
		$selectally_id = intval($ally_id);
		$selectally_name = $ally_name;
		$selectally_request = intval($ally_request);
		$selectally_request_text = $ally_request_text;
		$selectally_register_time = intval($ally_register_time);
		$selectally_rank_id = intval($ally_rank_id);
		$selectcurrent_luna = intval($current_luna);
		$selectkolorminus = $kolorminus;
		$selectkolorplus = $kolorplus;
		$selectkolorpoziom = $kolorpoziom;
		$selectrpg_geologue = intval($rpg_geologue);
		$selectrpg_amiral = intval($rpg_amiral);
		$selectrpg_ingenieur = intval($rpg_ingenieur);
		$selectrpg_technocrate = intval($rpg_technocrate);
		$selectrpg_espion = intval($rpg_espion);
		$selectrpg_constructeur = intval($rpg_constructeur);
		$selectrpg_scientifique = intval($rpg_scientifique);
		$selectrpg_commandant = intval($rpg_commandant);
		$selectrpg_points = intval($rpg_points);
		$selectrpg_stockeur = intval($rpg_stockeur);
		$selectrpg_defenseur = intval($rpg_defenseur);
		$selectrpg_destructeur = intval($rpg_destructeur);
		$selectrpg_general = intval($rpg_general);
		$selectrpg_bunker = intval($rpg_bunker);
		$selectrpg_raideur = intval($rpg_raideur);
		$selectrpg_empereur = intval($rpg_empereur);
		$selectlvl_minier = intval($lvl_minier);
		$selectlvl_raid = intval($lvl_raid);
		$selectxpraid = intval($xpraid);
		$selectxpminier = intval($xpminier);
		$selectraids = $raids;
		$selectp_infligees = $p_infligees;
		$selectmnl_alliance = intval($mnl_alliance);
		$selectmnl_joueur = intval($mnl_joueur);
		$selectmnl_attaque = intval($mnl_attaque);
		$selectmnl_spy = intval($mnl_spy);
		$selectmnl_exploit = intval($mnl_exploit);
		$selectmnl_transport = intval($mnl_transport);
		$selectmnl_expedition = intval($mnl_expedition);
		$selectmnl_general = intval($mnl_general);
		$selectmnl_buildlist = intval($mnl_buildlist);
		$selectbana = intval($bana);
		$selectmulti_validated = intval($multi_validated);
		$selectbanaday = intval($banaday);
		$selectraids1 = intval($raids1);
		$selectraidswin = intval($raidswin);
		$selectraidsloose = intval($raidsloose);

		
		
		$statement = $this->_getSelectStatement();
        $statement->execute(array(
		':id'=>$selectid,
		':username'=>$selectusername,
		':password'=>$selectpassword,
		':email'=>$selectemail,
		':email_2'=>$selectemail_2,
		':lang'=>$selectlang,
		':authlevel'=>$selectauthlevel,
		':sex'=>$selectsex,
		':avatar'=>$selectavatar,
		':sign'=>$selectsign,
		':id_planet'=>$selectid_planet,
		':galaxy'=>$selectgalaxy,
		':system'=>$selectsystem,
		':planet'=>$selectplanet,
		':current_planet'=>$selectcurrent_planet,
		':user_lastip'=>$selectuser_lastip,
		':ip_at_reg'=>$selectip_at_reg,
		':user_agent'=>$selectuser_agent,
		':current_page'=>$selectcurrent_page,
		':register_time'=>$selectregister_time,
		':onlinetime'=>$selectonlinetime,
		':json_time'=>$selectjson_time,
		':dpath'=>$selectdpath,
		':design'=>$selectdesign,
		':noipcheck'=>$selectnoipcheck,
		':planet_sort'=>$selectplanet_sort,
		':planet_sort_order'=>$selectplanet_sort_order,
		':spio_anz'=>$selectspio_anz,
		':settings_tooltiptime'=>$selectsettings_tooltiptime,
		':settings_fleetactions'=>$selectsettings_fleetactions,
		':settings_allylogo'=>$selectsettings_allylogo,
		':settings_esp'=>$selectsettings_esp,
		':settings_wri'=>$selectsettings_wri,
		':settings_bud'=>$selectsettings_bud,
		':settings_mis'=>$selectsettings_mis,
		':settings_rep'=>$selectsettings_rep,
		':urlaubs_modus'=>$selecturlaubs_modus,
		':urlaubs_until'=>$selecturlaubs_until,
		':db_deaktjava'=>$selectdb_deaktjava,
		':new_message'=>$selectnew_message,
		':fleet_shortcut'=>$selectfleet_shortcut,
		':b_tech_planet'=>$selectb_tech_planet,
		':b_tech'=>$selectb_tech,
		':b_tech_id'=>$selectb_tech_id,
		':spy_tech'=>$selectspy_tech,
		':computer_tech'=>$selectcomputer_tech,
		':military_tech'=>$selectmilitary_tech,
		':defence_tech'=>$selectdefence_tech,
		':shield_tech'=>$selectshield_tech,
		':energy_tech'=>$selectenergy_tech,
		':hyperspace_tech'=>$selecthyperspace_tech,
		':combustion_tech'=>$selectcombustion_tech,
		':impulse_motor_tech'=>$selectimpulse_motor_tech,
		':hyperspace_motor_tech'=>$selecthyperspace_motor_tech,
		':laser_tech'=>$selectlaser_tech,
		':ionic_tech'=>$selectionic_tech,
		':buster_tech'=>$selectbuster_tech,
		':intergalactic_tech'=>$selectintergalactic_tech,
		':expedition_tech'=>$selectexpedition_tech,
		':graviton_tech'=>$selectgraviton_tech,
		':ally_id'=>$selectally_id,
		':ally_name'=>$selectally_name,
		':ally_request'=>$selectally_request,
		':ally_request_text'=>$selectally_request_text,
		':ally_register_time'=>$selectally_register_time,
		':ally_rank_id'=>$selectally_rank_id,
		':current_luna'=>$selectcurrent_luna,
		':kolorminus'=>$selectkolorminus,
		':kolorplus'=>$selectkolorplus,
		':kolorpoziom'=>$selectkolorpoziom,
		':rpg_geologue'=>$selectrpg_geologue,
		':rpg_amiral'=>$selectrpg_amiral,
		':rpg_ingenieur'=>$selectrpg_ingenieur,
		':rpg_technocrate'=>$selectrpg_technocrate,
		':rpg_espion'=>$selectrpg_espion,
		':rpg_constructeur'=>$selectrpg_constructeur,
		':rpg_scientifique'=>$selectrpg_scientifique,
		':rpg_commandant'=>$selectrpg_commandant,
		':rpg_points'=>$selectrpg_points,
		':rpg_stockeur'=>$selectrpg_stockeur,
		':rpg_defenseur'=>$selectrpg_defenseur,
		':rpg_destructeur'=>$selectrpg_destructeur,
		':rpg_general'=>$selectrpg_general,
		':rpg_bunker'=>$selectrpg_bunker,
		':rpg_raideur'=>$selectrpg_raideur,
		':rpg_empereur'=>$selectrpg_empereur,
		':lvl_minier'=>$selectlvl_minier,
		':lvl_raid'=>$selectlvl_raid,
		':xpraid'=>$selectxpraid,
		':xpminier'=>$selectxpminier,
		':raids'=>$selectraids,
		':p_infligees'=>$selectp_infligees,
		':mnl_alliance'=>$selectmnl_alliance,
		':mnl_joueur'=>$selectmnl_joueur,
		':mnl_attaque'=>$selectmnl_attaque,
		':mnl_spy'=>$selectmnl_spy,
		':mnl_exploit'=>$selectmnl_exploit,
		':mnl_transport'=>$selectmnl_transport,
		':mnl_expedition'=>$selectmnl_expedition,
		':mnl_general'=>$selectmnl_general,
		':mnl_buildlist'=>$selectmnl_buildlist,
		':bana'=>$selectbana,
		':multi_validated'=>$selectmulti_validated,
		':banaday'=>$selectbanaday,
		':raids1'=>$selectraids1,
		':raidswin'=>$selectraidswin,
		':raidsloose'=>$selectraidsloose
        ));

        return $statement->fetchAll();
    }
	/****************BEGIN INSERT****************/	

	protected function _getInsertStatement()
    {
        if ($this->_insertStatement === null) {
            $this->_insertStatement = $this->getWriteAdapter()
                ->prepare('INSERT INTO game_users(`username`,`password`,`email`,`email_2`,`lang`,`authlevel`,`sex`,`avatar`,`sign`,`id_planet`,`galaxy`,`system`,`planet`,`current_planet`,`user_lastip`,`ip_at_reg`,`user_agent`,`current_page`,`register_time`,`onlinetime`,`json_time`,`dpath`,`design`,`noipcheck`,`planet_sort`,`planet_sort_order`,`spio_anz`,`settings_tooltiptime`,`settings_fleetactions`,`settings_allylogo`,`settings_esp`,`settings_wri`,`settings_bud`,`settings_mis`,`settings_rep`,`urlaubs_modus`,`urlaubs_until`,`db_deaktjava`,`new_message`,`fleet_shortcut`,`b_tech_planet`,`b_tech`,`b_tech_id`,`spy_tech`,`computer_tech`,`military_tech`,`defence_tech`,`shield_tech`,`energy_tech`,`hyperspace_tech`,`combustion_tech`,`impulse_motor_tech`,`hyperspace_motor_tech`,`laser_tech`,`ionic_tech`,`buster_tech`,`intergalactic_tech`,`expedition_tech`,`graviton_tech`,`ally_id`,`ally_name`,`ally_request`,`ally_request_text`,`ally_register_time`,`ally_rank_id`,`current_luna`,`kolorminus`,`kolorplus`,`kolorpoziom`,`rpg_geologue`,`rpg_amiral`,`rpg_ingenieur`,`rpg_technocrate`,`rpg_espion`,`rpg_constructeur`,`rpg_scientifique`,`rpg_commandant`,`rpg_points`,`rpg_stockeur`,`rpg_defenseur`,`rpg_destructeur`,`rpg_general`,`rpg_bunker`,`rpg_raideur`,`rpg_empereur`,`lvl_minier`,`lvl_raid`,`xpraid`,`xpminier`,`raids`,`p_infligees`,`mnl_alliance`,`mnl_joueur`,`mnl_attaque`,`mnl_spy`,`mnl_exploit`,`mnl_transport`,`mnl_expedition`,`mnl_general`,`mnl_buildlist`,`bana`,`multi_validated`,`banaday`,`raids1`,`raidswin`,`raidsloose`) VALUES(:username,:password,:email,:email_2,:lang,:authlevel,:sex,:avatar,:sign,:id_planet,:galaxy,:system,:planet,:current_planet,:user_lastip,:ip_at_reg,:user_agent,:current_page,:register_time,:onlinetime,:json_time,:dpath,:design,:noipcheck,:planet_sort,:planet_sort_order,:spio_anz,:settings_tooltiptime,:settings_fleetactions,:settings_allylogo,:settings_esp,:settings_wri,:settings_bud,:settings_mis,:settings_rep,:urlaubs_modus,:urlaubs_until,:db_deaktjava,:new_message,:fleet_shortcut,:b_tech_planet,:b_tech,:b_tech_id,:spy_tech,:computer_tech,:military_tech,:defence_tech,:shield_tech,:energy_tech,:hyperspace_tech,:combustion_tech,:impulse_motor_tech,:hyperspace_motor_tech,:laser_tech,:ionic_tech,:buster_tech,:intergalactic_tech,:expedition_tech,:graviton_tech,:ally_id,:ally_name,:ally_request,:ally_request_text,:ally_register_time,:ally_rank_id,:current_luna,:kolorminus,:kolorplus,:kolorpoziom,:rpg_geologue,:rpg_amiral,:rpg_ingenieur,:rpg_technocrate,:rpg_espion,:rpg_constructeur,:rpg_scientifique,:rpg_commandant,:rpg_points,:rpg_stockeur,:rpg_defenseur,:rpg_destructeur,:rpg_general,:rpg_bunker,:rpg_raideur,:rpg_empereur,:lvl_minier,:lvl_raid,:xpraid,:xpminier,:raids,:p_infligees,:mnl_alliance,:mnl_joueur,:mnl_attaque,:mnl_spy,:mnl_exploit,:mnl_transport,:mnl_expedition,:mnl_general,:mnl_buildlist,:bana,:multi_validated,:banaday,:raids1,:raidswin,:raidsloose)');
        }

        return $this->_insertStatement;
    }

    /**
     */
    public function insert($username,$password,$email,$email_2,$lang,$authlevel,$sex,$avatar,$sign,$id_planet,$galaxy,$system,$planet,$current_planet,$user_lastip,$ip_at_reg,$user_agent,$current_page,$register_time,$onlinetime,$json_time,$dpath,$design,$noipcheck,$planet_sort,$planet_sort_order,$spio_anz,$settings_tooltiptime,$settings_fleetactions,$settings_allylogo,$settings_esp,$settings_wri,$settings_bud,$settings_mis,$settings_rep,$urlaubs_modus,$urlaubs_until,$db_deaktjava,$new_message,$fleet_shortcut,$b_tech_planet,$b_tech,$b_tech_id,$spy_tech,$computer_tech,$military_tech,$defence_tech,$shield_tech,$energy_tech,$hyperspace_tech,$combustion_tech,$impulse_motor_tech,$hyperspace_motor_tech,$laser_tech,$ionic_tech,$buster_tech,$intergalactic_tech,$expedition_tech,$graviton_tech,$ally_id,$ally_name,$ally_request,$ally_request_text,$ally_register_time,$ally_rank_id,$current_luna,$kolorminus,$kolorplus,$kolorpoziom,$rpg_geologue,$rpg_amiral,$rpg_ingenieur,$rpg_technocrate,$rpg_espion,$rpg_constructeur,$rpg_scientifique,$rpg_commandant,$rpg_points,$rpg_stockeur,$rpg_defenseur,$rpg_destructeur,$rpg_general,$rpg_bunker,$rpg_raideur,$rpg_empereur,$lvl_minier,$lvl_raid,$xpraid,$xpminier,$raids,$p_infligees,$mnl_alliance,$mnl_joueur,$mnl_attaque,$mnl_spy,$mnl_exploit,$mnl_transport,$mnl_expedition,$mnl_general,$mnl_buildlist,$bana,$multi_validated,$banaday,$raids1,$raidswin,$raidsloose)
    {
		// 
		$insertusername = $username;
		$insertpassword = $password;
		$insertemail = $email;
		$insertemail_2 = $email_2;
		$insertlang = $lang;
		$insertauthlevel = $authlevel;
		$insertsex = $sex;
		$insertavatar = $avatar;
		$insertsign = $sign;
		$insertid_planet = intval($id_planet);
		$insertgalaxy = intval($galaxy);
		$insertsystem = intval($system);
		$insertplanet = intval($planet);
		$insertcurrent_planet = intval($current_planet);
		$insertuser_lastip = $user_lastip;
		$insertip_at_reg = $ip_at_reg;
		$insertuser_agent = $user_agent;
		$insertcurrent_page = $current_page;
		$insertregister_time = intval($register_time);
		$insertonlinetime = intval($onlinetime);
		$insertjson_time = intval($json_time);
		$insertdpath = $dpath;
		$insertdesign = $design;
		$insertnoipcheck = $noipcheck;
		$insertplanet_sort = $planet_sort;
		$insertplanet_sort_order = $planet_sort_order;
		$insertspio_anz = $spio_anz;
		$insertsettings_tooltiptime = $settings_tooltiptime;
		$insertsettings_fleetactions = $settings_fleetactions;
		$insertsettings_allylogo = $settings_allylogo;
		$insertsettings_esp = $settings_esp;
		$insertsettings_wri = $settings_wri;
		$insertsettings_bud = $settings_bud;
		$insertsettings_mis = $settings_mis;
		$insertsettings_rep = $settings_rep;
		$inserturlaubs_modus = $urlaubs_modus;
		$inserturlaubs_until = intval($urlaubs_until);
		$insertdb_deaktjava = $db_deaktjava;
		$insertnew_message = intval($new_message);
		$insertfleet_shortcut = $fleet_shortcut;
		$insertb_tech_planet = intval($b_tech_planet);
		$insertb_tech = intval($b_tech);
		$insertb_tech_id = $b_tech_id;
		$insertspy_tech = intval($spy_tech);
		$insertcomputer_tech = intval($computer_tech);
		$insertmilitary_tech = intval($military_tech);
		$insertdefence_tech = intval($defence_tech);
		$insertshield_tech = intval($shield_tech);
		$insertenergy_tech = intval($energy_tech);
		$inserthyperspace_tech = intval($hyperspace_tech);
		$insertcombustion_tech = intval($combustion_tech);
		$insertimpulse_motor_tech = intval($impulse_motor_tech);
		$inserthyperspace_motor_tech = intval($hyperspace_motor_tech);
		$insertlaser_tech = intval($laser_tech);
		$insertionic_tech = intval($ionic_tech);
		$insertbuster_tech = intval($buster_tech);
		$insertintergalactic_tech = intval($intergalactic_tech);
		$insertexpedition_tech = intval($expedition_tech);
		$insertgraviton_tech = intval($graviton_tech);
		$insertally_id = intval($ally_id);
		$insertally_name = $ally_name;
		$insertally_request = intval($ally_request);
		$insertally_request_text = $ally_request_text;
		$insertally_register_time = intval($ally_register_time);
		$insertally_rank_id = intval($ally_rank_id);
		$insertcurrent_luna = intval($current_luna);
		$insertkolorminus = $kolorminus;
		$insertkolorplus = $kolorplus;
		$insertkolorpoziom = $kolorpoziom;
		$insertrpg_geologue = intval($rpg_geologue);
		$insertrpg_amiral = intval($rpg_amiral);
		$insertrpg_ingenieur = intval($rpg_ingenieur);
		$insertrpg_technocrate = intval($rpg_technocrate);
		$insertrpg_espion = intval($rpg_espion);
		$insertrpg_constructeur = intval($rpg_constructeur);
		$insertrpg_scientifique = intval($rpg_scientifique);
		$insertrpg_commandant = intval($rpg_commandant);
		$insertrpg_points = intval($rpg_points);
		$insertrpg_stockeur = intval($rpg_stockeur);
		$insertrpg_defenseur = intval($rpg_defenseur);
		$insertrpg_destructeur = intval($rpg_destructeur);
		$insertrpg_general = intval($rpg_general);
		$insertrpg_bunker = intval($rpg_bunker);
		$insertrpg_raideur = intval($rpg_raideur);
		$insertrpg_empereur = intval($rpg_empereur);
		$insertlvl_minier = intval($lvl_minier);
		$insertlvl_raid = intval($lvl_raid);
		$insertxpraid = intval($xpraid);
		$insertxpminier = intval($xpminier);
		$insertraids = $raids;
		$insertp_infligees = $p_infligees;
		$insertmnl_alliance = intval($mnl_alliance);
		$insertmnl_joueur = intval($mnl_joueur);
		$insertmnl_attaque = intval($mnl_attaque);
		$insertmnl_spy = intval($mnl_spy);
		$insertmnl_exploit = intval($mnl_exploit);
		$insertmnl_transport = intval($mnl_transport);
		$insertmnl_expedition = intval($mnl_expedition);
		$insertmnl_general = intval($mnl_general);
		$insertmnl_buildlist = intval($mnl_buildlist);
		$insertbana = intval($bana);
		$insertmulti_validated = intval($multi_validated);
		$insertbanaday = intval($banaday);
		$insertraids1 = intval($raids1);
		$insertraidswin = intval($raidswin);
		$insertraidsloose = intval($raidsloose);

	
        $statement = $this->_getInsertStatement();
        $result = $statement->execute(array(
		':username'=>$insertusername,
		':password'=>$insertpassword,
		':email'=>$insertemail,
		':email_2'=>$insertemail_2,
		':lang'=>$insertlang,
		':authlevel'=>$insertauthlevel,
		':sex'=>$insertsex,
		':avatar'=>$insertavatar,
		':sign'=>$insertsign,
		':id_planet'=>$insertid_planet,
		':galaxy'=>$insertgalaxy,
		':system'=>$insertsystem,
		':planet'=>$insertplanet,
		':current_planet'=>$insertcurrent_planet,
		':user_lastip'=>$insertuser_lastip,
		':ip_at_reg'=>$insertip_at_reg,
		':user_agent'=>$insertuser_agent,
		':current_page'=>$insertcurrent_page,
		':register_time'=>$insertregister_time,
		':onlinetime'=>$insertonlinetime,
		':json_time'=>$insertjson_time,
		':dpath'=>$insertdpath,
		':design'=>$insertdesign,
		':noipcheck'=>$insertnoipcheck,
		':planet_sort'=>$insertplanet_sort,
		':planet_sort_order'=>$insertplanet_sort_order,
		':spio_anz'=>$insertspio_anz,
		':settings_tooltiptime'=>$insertsettings_tooltiptime,
		':settings_fleetactions'=>$insertsettings_fleetactions,
		':settings_allylogo'=>$insertsettings_allylogo,
		':settings_esp'=>$insertsettings_esp,
		':settings_wri'=>$insertsettings_wri,
		':settings_bud'=>$insertsettings_bud,
		':settings_mis'=>$insertsettings_mis,
		':settings_rep'=>$insertsettings_rep,
		':urlaubs_modus'=>$inserturlaubs_modus,
		':urlaubs_until'=>$inserturlaubs_until,
		':db_deaktjava'=>$insertdb_deaktjava,
		':new_message'=>$insertnew_message,
		':fleet_shortcut'=>$insertfleet_shortcut,
		':b_tech_planet'=>$insertb_tech_planet,
		':b_tech'=>$insertb_tech,
		':b_tech_id'=>$insertb_tech_id,
		':spy_tech'=>$insertspy_tech,
		':computer_tech'=>$insertcomputer_tech,
		':military_tech'=>$insertmilitary_tech,
		':defence_tech'=>$insertdefence_tech,
		':shield_tech'=>$insertshield_tech,
		':energy_tech'=>$insertenergy_tech,
		':hyperspace_tech'=>$inserthyperspace_tech,
		':combustion_tech'=>$insertcombustion_tech,
		':impulse_motor_tech'=>$insertimpulse_motor_tech,
		':hyperspace_motor_tech'=>$inserthyperspace_motor_tech,
		':laser_tech'=>$insertlaser_tech,
		':ionic_tech'=>$insertionic_tech,
		':buster_tech'=>$insertbuster_tech,
		':intergalactic_tech'=>$insertintergalactic_tech,
		':expedition_tech'=>$insertexpedition_tech,
		':graviton_tech'=>$insertgraviton_tech,
		':ally_id'=>$insertally_id,
		':ally_name'=>$insertally_name,
		':ally_request'=>$insertally_request,
		':ally_request_text'=>$insertally_request_text,
		':ally_register_time'=>$insertally_register_time,
		':ally_rank_id'=>$insertally_rank_id,
		':current_luna'=>$insertcurrent_luna,
		':kolorminus'=>$insertkolorminus,
		':kolorplus'=>$insertkolorplus,
		':kolorpoziom'=>$insertkolorpoziom,
		':rpg_geologue'=>$insertrpg_geologue,
		':rpg_amiral'=>$insertrpg_amiral,
		':rpg_ingenieur'=>$insertrpg_ingenieur,
		':rpg_technocrate'=>$insertrpg_technocrate,
		':rpg_espion'=>$insertrpg_espion,
		':rpg_constructeur'=>$insertrpg_constructeur,
		':rpg_scientifique'=>$insertrpg_scientifique,
		':rpg_commandant'=>$insertrpg_commandant,
		':rpg_points'=>$insertrpg_points,
		':rpg_stockeur'=>$insertrpg_stockeur,
		':rpg_defenseur'=>$insertrpg_defenseur,
		':rpg_destructeur'=>$insertrpg_destructeur,
		':rpg_general'=>$insertrpg_general,
		':rpg_bunker'=>$insertrpg_bunker,
		':rpg_raideur'=>$insertrpg_raideur,
		':rpg_empereur'=>$insertrpg_empereur,
		':lvl_minier'=>$insertlvl_minier,
		':lvl_raid'=>$insertlvl_raid,
		':xpraid'=>$insertxpraid,
		':xpminier'=>$insertxpminier,
		':raids'=>$insertraids,
		':p_infligees'=>$insertp_infligees,
		':mnl_alliance'=>$insertmnl_alliance,
		':mnl_joueur'=>$insertmnl_joueur,
		':mnl_attaque'=>$insertmnl_attaque,
		':mnl_spy'=>$insertmnl_spy,
		':mnl_exploit'=>$insertmnl_exploit,
		':mnl_transport'=>$insertmnl_transport,
		':mnl_expedition'=>$insertmnl_expedition,
		':mnl_general'=>$insertmnl_general,
		':mnl_buildlist'=>$insertmnl_buildlist,
		':bana'=>$insertbana,
		':multi_validated'=>$insertmulti_validated,
		':banaday'=>$insertbanaday,
		':raids1'=>$insertraids1,
		':raidswin'=>$insertraidswin,
		':raidsloose'=>$insertraidsloose
		));

        if ($result === false) {
            return false;
        }

        return $statement->rowCount();
    }
	
/****************END INSERT****************/

   /**
     * @return PDOStatement
     */
    protected function _getDeleteOneStatement()
    {
        if ($this->_deleteoneStatement === null) {
            $this->_deleteoneStatement = $this->getReadAdapter()
                ->prepare('DELETE FROM game_users WHERE `id`=:id;');
        }
        return $this->_deleteoneStatement;
    }


    public function delete($stat_date)
    {
		// securité
		$deleteid = intval($id);
		
		
		$statement = $this->_getDeleteOneStatement();
        $statement->execute(array(
		':id'=>$deleteid
        ));

        return $statement->rowCount();
    }	

/****************BEGIN UPDATE****************/
	
    protected function _getUpdateStatement()
    {
        if ($this->_updateStatement === null) {
            $this->_updateStatement = $this->getWriteAdapter()
                ->prepare('UPDATE game_users SET `username`=:username,`password`=:password,`email`=:email,`email_2`=:email_2,`lang`=:lang,`authlevel`=:authlevel,`sex`=:sex,`avatar`=:avatar,`sign`=:sign,`id_planet`=:id_planet,`galaxy`=:galaxy,`system`=:system,`planet`=:planet,`current_planet`=:current_planet,`user_lastip`=:user_lastip,`ip_at_reg`=:ip_at_reg,`user_agent`=:user_agent,`current_page`=:current_page,`register_time`=:register_time,`onlinetime`=:onlinetime,`json_time`=:json_time,`dpath`=:dpath,`design`=:design,`noipcheck`=:noipcheck,`planet_sort`=:planet_sort,`planet_sort_order`=:planet_sort_order,`spio_anz`=:spio_anz,`settings_tooltiptime`=:settings_tooltiptime,`settings_fleetactions`=:settings_fleetactions,`settings_allylogo`=:settings_allylogo,`settings_esp`=:settings_esp,`settings_wri`=:settings_wri,`settings_bud`=:settings_bud,`settings_mis`=:settings_mis,`settings_rep`=:settings_rep,`urlaubs_modus`=:urlaubs_modus,`urlaubs_until`=:urlaubs_until,`db_deaktjava`=:db_deaktjava,`new_message`=:new_message,`fleet_shortcut`=:fleet_shortcut,`b_tech_planet`=:b_tech_planet,`b_tech`=:b_tech,`b_tech_id`=:b_tech_id,`spy_tech`=:spy_tech,`computer_tech`=:computer_tech,`military_tech`=:military_tech,`defence_tech`=:defence_tech,`shield_tech`=:shield_tech,`energy_tech`=:energy_tech,`hyperspace_tech`=:hyperspace_tech,`combustion_tech`=:combustion_tech,`impulse_motor_tech`=:impulse_motor_tech,`hyperspace_motor_tech`=:hyperspace_motor_tech,`laser_tech`=:laser_tech,`ionic_tech`=:ionic_tech,`buster_tech`=:buster_tech,`intergalactic_tech`=:intergalactic_tech,`expedition_tech`=:expedition_tech,`graviton_tech`=:graviton_tech,`ally_id`=:ally_id,`ally_name`=:ally_name,`ally_request`=:ally_request,`ally_request_text`=:ally_request_text,`ally_register_time`=:ally_register_time,`ally_rank_id`=:ally_rank_id,`current_luna`=:current_luna,`kolorminus`=:kolorminus,`kolorplus`=:kolorplus,`kolorpoziom`=:kolorpoziom,`rpg_geologue`=:rpg_geologue,`rpg_amiral`=:rpg_amiral,`rpg_ingenieur`=:rpg_ingenieur,`rpg_technocrate`=:rpg_technocrate,`rpg_espion`=:rpg_espion,`rpg_constructeur`=:rpg_constructeur,`rpg_scientifique`=:rpg_scientifique,`rpg_commandant`=:rpg_commandant,`rpg_points`=:rpg_points,`rpg_stockeur`=:rpg_stockeur,`rpg_defenseur`=:rpg_defenseur,`rpg_destructeur`=:rpg_destructeur,`rpg_general`=:rpg_general,`rpg_bunker`=:rpg_bunker,`rpg_raideur`=:rpg_raideur,`rpg_empereur`=:rpg_empereur,`lvl_minier`=:lvl_minier,`lvl_raid`=:lvl_raid,`xpraid`=:xpraid,`xpminier`=:xpminier,`raids`=:raids,`p_infligees`=:p_infligees,`mnl_alliance`=:mnl_alliance,`mnl_joueur`=:mnl_joueur,`mnl_attaque`=:mnl_attaque,`mnl_spy`=:mnl_spy,`mnl_exploit`=:mnl_exploit,`mnl_transport`=:mnl_transport,`mnl_expedition`=:mnl_expedition,`mnl_general`=:mnl_general,`mnl_buildlist`=:mnl_buildlist,`bana`=:bana,`multi_validated`=:multi_validated,`banaday`=:banaday,`raids1`=:raids1,`raidswin`=:raidswin,`raidsloose`=:raidsloose WHERE `id`=:id');
        }

        return $this->_updateStatement;
    }

    public function update($id,$username,$password,$email,$email_2,$lang,$authlevel,$sex,$avatar,$sign,$id_planet,$galaxy,$system,$planet,$current_planet,$user_lastip,$ip_at_reg,$user_agent,$current_page,$register_time,$onlinetime,$json_time,$dpath,$design,$noipcheck,$planet_sort,$planet_sort_order,$spio_anz,$settings_tooltiptime,$settings_fleetactions,$settings_allylogo,$settings_esp,$settings_wri,$settings_bud,$settings_mis,$settings_rep,$urlaubs_modus,$urlaubs_until,$db_deaktjava,$new_message,$fleet_shortcut,$b_tech_planet,$b_tech,$b_tech_id,$spy_tech,$computer_tech,$military_tech,$defence_tech,$shield_tech,$energy_tech,$hyperspace_tech,$combustion_tech,$impulse_motor_tech,$hyperspace_motor_tech,$laser_tech,$ionic_tech,$buster_tech,$intergalactic_tech,$expedition_tech,$graviton_tech,$ally_id,$ally_name,$ally_request,$ally_request_text,$ally_register_time,$ally_rank_id,$current_luna,$kolorminus,$kolorplus,$kolorpoziom,$rpg_geologue,$rpg_amiral,$rpg_ingenieur,$rpg_technocrate,$rpg_espion,$rpg_constructeur,$rpg_scientifique,$rpg_commandant,$rpg_points,$rpg_stockeur,$rpg_defenseur,$rpg_destructeur,$rpg_general,$rpg_bunker,$rpg_raideur,$rpg_empereur,$lvl_minier,$lvl_raid,$xpraid,$xpminier,$raids,$p_infligees,$mnl_alliance,$mnl_joueur,$mnl_attaque,$mnl_spy,$mnl_exploit,$mnl_transport,$mnl_expedition,$mnl_general,$mnl_buildlist,$bana,$multi_validated,$banaday,$raids1,$raidswin,$raidsloose)
    {
		//securité
		$updateid = $id;
		$updateusername = $username;
		$updatepassword = $password;
		$updateemail = $email;
		$updateemail_2 = $email_2;
		$updatelang = $lang;
		$updateauthlevel = $authlevel;
		$updatesex = $sex;
		$updateavatar = $avatar;
		$updatesign = $sign;
		$updateid_planet = intval($id_planet);
		$updategalaxy = intval($galaxy);
		$updatesystem = intval($system);
		$updateplanet = intval($planet);
		$updatecurrent_planet = intval($current_planet);
		$updateuser_lastip = $user_lastip;
		$updateip_at_reg = $ip_at_reg;
		$updateuser_agent = $user_agent;
		$updatecurrent_page = $current_page;
		$updateregister_time = intval($register_time);
		$updateonlinetime = intval($onlinetime);
		$updatejson_time = intval($json_time);
		$updatedpath = $dpath;
		$updatedesign = $design;
		$updatenoipcheck = $noipcheck;
		$updateplanet_sort = $planet_sort;
		$updateplanet_sort_order = $planet_sort_order;
		$updatespio_anz = $spio_anz;
		$updatesettings_tooltiptime = $settings_tooltiptime;
		$updatesettings_fleetactions = $settings_fleetactions;
		$updatesettings_allylogo = $settings_allylogo;
		$updatesettings_esp = $settings_esp;
		$updatesettings_wri = $settings_wri;
		$updatesettings_bud = $settings_bud;
		$updatesettings_mis = $settings_mis;
		$updatesettings_rep = $settings_rep;
		$updateurlaubs_modus = $urlaubs_modus;
		$updateurlaubs_until = intval($urlaubs_until);
		$updatedb_deaktjava = $db_deaktjava;
		$updatenew_message = intval($new_message);
		$updatefleet_shortcut = $fleet_shortcut;
		$updateb_tech_planet = intval($b_tech_planet);
		$updateb_tech = intval($b_tech);
		$updateb_tech_id = $b_tech_id;
		$updatespy_tech = intval($spy_tech);
		$updatecomputer_tech = intval($computer_tech);
		$updatemilitary_tech = intval($military_tech);
		$updatedefence_tech = intval($defence_tech);
		$updateshield_tech = intval($shield_tech);
		$updateenergy_tech = intval($energy_tech);
		$updatehyperspace_tech = intval($hyperspace_tech);
		$updatecombustion_tech = intval($combustion_tech);
		$updateimpulse_motor_tech = intval($impulse_motor_tech);
		$updatehyperspace_motor_tech = intval($hyperspace_motor_tech);
		$updatelaser_tech = intval($laser_tech);
		$updateionic_tech = intval($ionic_tech);
		$updatebuster_tech = intval($buster_tech);
		$updateintergalactic_tech = intval($intergalactic_tech);
		$updateexpedition_tech = intval($expedition_tech);
		$updategraviton_tech = intval($graviton_tech);
		$updateally_id = intval($ally_id);
		$updateally_name = $ally_name;
		$updateally_request = intval($ally_request);
		$updateally_request_text = $ally_request_text;
		$updateally_register_time = intval($ally_register_time);
		$updateally_rank_id = intval($ally_rank_id);
		$updatecurrent_luna = intval($current_luna);
		$updatekolorminus = $kolorminus;
		$updatekolorplus = $kolorplus;
		$updatekolorpoziom = $kolorpoziom;
		$updaterpg_geologue = intval($rpg_geologue);
		$updaterpg_amiral = intval($rpg_amiral);
		$updaterpg_ingenieur = intval($rpg_ingenieur);
		$updaterpg_technocrate = intval($rpg_technocrate);
		$updaterpg_espion = intval($rpg_espion);
		$updaterpg_constructeur = intval($rpg_constructeur);
		$updaterpg_scientifique = intval($rpg_scientifique);
		$updaterpg_commandant = intval($rpg_commandant);
		$updaterpg_points = intval($rpg_points);
		$updaterpg_stockeur = intval($rpg_stockeur);
		$updaterpg_defenseur = intval($rpg_defenseur);
		$updaterpg_destructeur = intval($rpg_destructeur);
		$updaterpg_general = intval($rpg_general);
		$updaterpg_bunker = intval($rpg_bunker);
		$updaterpg_raideur = intval($rpg_raideur);
		$updaterpg_empereur = intval($rpg_empereur);
		$updatelvl_minier = intval($lvl_minier);
		$updatelvl_raid = intval($lvl_raid);
		$updatexpraid = intval($xpraid);
		$updatexpminier = intval($xpminier);
		$updateraids = $raids;
		$updatep_infligees = $p_infligees;
		$updatemnl_alliance = intval($mnl_alliance);
		$updatemnl_joueur = intval($mnl_joueur);
		$updatemnl_attaque = intval($mnl_attaque);
		$updatemnl_spy = intval($mnl_spy);
		$updatemnl_exploit = intval($mnl_exploit);
		$updatemnl_transport = intval($mnl_transport);
		$updatemnl_expedition = intval($mnl_expedition);
		$updatemnl_general = intval($mnl_general);
		$updatemnl_buildlist = intval($mnl_buildlist);
		$updatebana = intval($bana);
		$updatemulti_validated = intval($multi_validated);
		$updatebanaday = intval($banaday);
		$updateraids1 = intval($raids1);
		$updateraidswin = intval($raidswin);
		$updateraidsloose = intval($raidsloose);

		
        $statement = $this->_getUpdateStatement();
        $result = $statement->execute(array(
		':id'=>$updateid,
		':username'=>$updateusername,
		':password'=>$updatepassword,
		':email'=>$updateemail,
		':email_2'=>$updateemail_2,
		':lang'=>$updatelang,
		':authlevel'=>$updateauthlevel,
		':sex'=>$updatesex,
		':avatar'=>$updateavatar,
		':sign'=>$updatesign,
		':id_planet'=>$updateid_planet,
		':galaxy'=>$updategalaxy,
		':system'=>$updatesystem,
		':planet'=>$updateplanet,
		':current_planet'=>$updatecurrent_planet,
		':user_lastip'=>$updateuser_lastip,
		':ip_at_reg'=>$updateip_at_reg,
		':user_agent'=>$updateuser_agent,
		':current_page'=>$updatecurrent_page,
		':register_time'=>$updateregister_time,
		':onlinetime'=>$updateonlinetime,
		':json_time'=>$updatejson_time,
		':dpath'=>$updatedpath,
		':design'=>$updatedesign,
		':noipcheck'=>$updatenoipcheck,
		':planet_sort'=>$updateplanet_sort,
		':planet_sort_order'=>$updateplanet_sort_order,
		':spio_anz'=>$updatespio_anz,
		':settings_tooltiptime'=>$updatesettings_tooltiptime,
		':settings_fleetactions'=>$updatesettings_fleetactions,
		':settings_allylogo'=>$updatesettings_allylogo,
		':settings_esp'=>$updatesettings_esp,
		':settings_wri'=>$updatesettings_wri,
		':settings_bud'=>$updatesettings_bud,
		':settings_mis'=>$updatesettings_mis,
		':settings_rep'=>$updatesettings_rep,
		':urlaubs_modus'=>$updateurlaubs_modus,
		':urlaubs_until'=>$updateurlaubs_until,
		':db_deaktjava'=>$updatedb_deaktjava,
		':new_message'=>$updatenew_message,
		':fleet_shortcut'=>$updatefleet_shortcut,
		':b_tech_planet'=>$updateb_tech_planet,
		':b_tech'=>$updateb_tech,
		':b_tech_id'=>$updateb_tech_id,
		':spy_tech'=>$updatespy_tech,
		':computer_tech'=>$updatecomputer_tech,
		':military_tech'=>$updatemilitary_tech,
		':defence_tech'=>$updatedefence_tech,
		':shield_tech'=>$updateshield_tech,
		':energy_tech'=>$updateenergy_tech,
		':hyperspace_tech'=>$updatehyperspace_tech,
		':combustion_tech'=>$updatecombustion_tech,
		':impulse_motor_tech'=>$updateimpulse_motor_tech,
		':hyperspace_motor_tech'=>$updatehyperspace_motor_tech,
		':laser_tech'=>$updatelaser_tech,
		':ionic_tech'=>$updateionic_tech,
		':buster_tech'=>$updatebuster_tech,
		':intergalactic_tech'=>$updateintergalactic_tech,
		':expedition_tech'=>$updateexpedition_tech,
		':graviton_tech'=>$updategraviton_tech,
		':ally_id'=>$updateally_id,
		':ally_name'=>$updateally_name,
		':ally_request'=>$updateally_request,
		':ally_request_text'=>$updateally_request_text,
		':ally_register_time'=>$updateally_register_time,
		':ally_rank_id'=>$updateally_rank_id,
		':current_luna'=>$updatecurrent_luna,
		':kolorminus'=>$updatekolorminus,
		':kolorplus'=>$updatekolorplus,
		':kolorpoziom'=>$updatekolorpoziom,
		':rpg_geologue'=>$updaterpg_geologue,
		':rpg_amiral'=>$updaterpg_amiral,
		':rpg_ingenieur'=>$updaterpg_ingenieur,
		':rpg_technocrate'=>$updaterpg_technocrate,
		':rpg_espion'=>$updaterpg_espion,
		':rpg_constructeur'=>$updaterpg_constructeur,
		':rpg_scientifique'=>$updaterpg_scientifique,
		':rpg_commandant'=>$updaterpg_commandant,
		':rpg_points'=>$updaterpg_points,
		':rpg_stockeur'=>$updaterpg_stockeur,
		':rpg_defenseur'=>$updaterpg_defenseur,
		':rpg_destructeur'=>$updaterpg_destructeur,
		':rpg_general'=>$updaterpg_general,
		':rpg_bunker'=>$updaterpg_bunker,
		':rpg_raideur'=>$updaterpg_raideur,
		':rpg_empereur'=>$updaterpg_empereur,
		':lvl_minier'=>$updatelvl_minier,
		':lvl_raid'=>$updatelvl_raid,
		':xpraid'=>$updatexpraid,
		':xpminier'=>$updatexpminier,
		':raids'=>$updateraids,
		':p_infligees'=>$updatep_infligees,
		':mnl_alliance'=>$updatemnl_alliance,
		':mnl_joueur'=>$updatemnl_joueur,
		':mnl_attaque'=>$updatemnl_attaque,
		':mnl_spy'=>$updatemnl_spy,
		':mnl_exploit'=>$updatemnl_exploit,
		':mnl_transport'=>$updatemnl_transport,
		':mnl_expedition'=>$updatemnl_expedition,
		':mnl_general'=>$updatemnl_general,
		':mnl_buildlist'=>$updatemnl_buildlist,
		':bana'=>$updatebana,
		':multi_validated'=>$updatemulti_validated,
		':banaday'=>$updatebanaday,
		':raids1'=>$updateraids1,
		':raidswin'=>$updateraidswin,
		':raidsloose'=>$updateraidsloose
        ));
        if ($result === false) {
            return false;
        }

        return $statement->rowCount();
    }
/****************END UPDATE****************/

    /**
     * @return int
     */
    public function truncate()
    {
        return $this->getWriteAdapter()->exec('TRUNCATE TABLE game_users');
    }
}