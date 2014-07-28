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

class game_planets extends BaseModel
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
					->prepare('SELECT * FROM game_planets ORDER BY `id` DESC');
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
                ->prepare('SELECT * FROM game_planets WHERE `id`=:id or`name`=:name or`id_owner`=:id_owner or`id_level`=:id_level or`galaxy`=:galaxy or`system`=:system or`planet`=:planet or`last_update`=:last_update or`planet_type`=:planet_type or`destruyed`=:destruyed or`b_building`=:b_building or`b_building_id`=:b_building_id or`b_tech`=:b_tech or`b_tech_id`=:b_tech_id or`b_hangar`=:b_hangar or`b_hangar_id`=:b_hangar_id or`b_hangar_plus`=:b_hangar_plus or`image`=:image or`diameter`=:diameter or`points`=:points or`ranks`=:ranks or`field_current`=:field_current or`field_max`=:field_max or`temp_min`=:temp_min or`temp_max`=:temp_max or`metal`=:metal or`metal_perhour`=:metal_perhour or`metal_max`=:metal_max or`crystal`=:crystal or`crystal_perhour`=:crystal_perhour or`crystal_max`=:crystal_max or`deuterium`=:deuterium or`deuterium_perhour`=:deuterium_perhour or`deuterium_max`=:deuterium_max or`energy_used`=:energy_used or`energy_max`=:energy_max or`metal_mine`=:metal_mine or`crystal_mine`=:crystal_mine or`deuterium_sintetizer`=:deuterium_sintetizer or`solar_plant`=:solar_plant or`fusion_plant`=:fusion_plant or`robot_factory`=:robot_factory or`nano_factory`=:nano_factory or`hangar`=:hangar or`metal_store`=:metal_store or`crystal_store`=:crystal_store or`deuterium_store`=:deuterium_store or`laboratory`=:laboratory or`terraformer`=:terraformer or`ally_deposit`=:ally_deposit or`silo`=:silo or`small_ship_cargo`=:small_ship_cargo or`big_ship_cargo`=:big_ship_cargo or`light_hunter`=:light_hunter or`heavy_hunter`=:heavy_hunter or`crusher`=:crusher or`battle_ship`=:battle_ship or`colonizer`=:colonizer or`recycler`=:recycler or`spy_sonde`=:spy_sonde or`bomber_ship`=:bomber_ship or`solar_satelit`=:solar_satelit or`destructor`=:destructor or`dearth_star`=:dearth_star or`battleship`=:battleship or`misil_launcher`=:misil_launcher or`small_laser`=:small_laser or`big_laser`=:big_laser or`gauss_canyon`=:gauss_canyon or`ionic_canyon`=:ionic_canyon or`buster_canyon`=:buster_canyon or`small_protection_shield`=:small_protection_shield or`big_protection_shield`=:big_protection_shield or`interceptor_misil`=:interceptor_misil or`interplanetary_misil`=:interplanetary_misil or`metal_mine_porcent`=:metal_mine_porcent or`crystal_mine_porcent`=:crystal_mine_porcent or`deuterium_sintetizer_porcent`=:deuterium_sintetizer_porcent or`solar_plant_porcent`=:solar_plant_porcent or`fusion_plant_porcent`=:fusion_plant_porcent or`solar_satelit_porcent`=:solar_satelit_porcent or`mondbasis`=:mondbasis or`phalanx`=:phalanx or`sprungtor`=:sprungtor or`last_jump_time`=:last_jump_time  LIMIT 1');
        }

        return $this->_selectStatement;
    }

    public function select($id,$name,$id_owner,$id_level,$galaxy,$system,$planet,$last_update,$planet_type,$destruyed,$b_building,$b_building_id,$b_tech,$b_tech_id,$b_hangar,$b_hangar_id,$b_hangar_plus,$image,$diameter,$points,$ranks,$field_current,$field_max,$temp_min,$temp_max,$metal,$metal_perhour,$metal_max,$crystal,$crystal_perhour,$crystal_max,$deuterium,$deuterium_perhour,$deuterium_max,$energy_used,$energy_max,$metal_mine,$crystal_mine,$deuterium_sintetizer,$solar_plant,$fusion_plant,$robot_factory,$nano_factory,$hangar,$metal_store,$crystal_store,$deuterium_store,$laboratory,$terraformer,$ally_deposit,$silo,$small_ship_cargo,$big_ship_cargo,$light_hunter,$heavy_hunter,$crusher,$battle_ship,$colonizer,$recycler,$spy_sonde,$bomber_ship,$solar_satelit,$destructor,$dearth_star,$battleship,$misil_launcher,$small_laser,$big_laser,$gauss_canyon,$ionic_canyon,$buster_canyon,$small_protection_shield,$big_protection_shield,$interceptor_misil,$interplanetary_misil,$metal_mine_porcent,$crystal_mine_porcent,$deuterium_sintetizer_porcent,$solar_plant_porcent,$fusion_plant_porcent,$solar_satelit_porcent,$mondbasis,$phalanx,$sprungtor,$last_jump_time)
    {
		// securité
		$selectid = $id;
		$selectname = $name;
		$selectid_owner = intval($id_owner);
		$selectid_level = intval($id_level);
		$selectgalaxy = intval($galaxy);
		$selectsystem = intval($system);
		$selectplanet = intval($planet);
		$selectlast_update = intval($last_update);
		$selectplanet_type = intval($planet_type);
		$selectdestruyed = intval($destruyed);
		$selectb_building = intval($b_building);
		$selectb_building_id = $b_building_id;
		$selectb_tech = intval($b_tech);
		$selectb_tech_id = intval($b_tech_id);
		$selectb_hangar = intval($b_hangar);
		$selectb_hangar_id = $b_hangar_id;
		$selectb_hangar_plus = intval($b_hangar_plus);
		$selectimage = $image;
		$selectdiameter = intval($diameter);
		$selectpoints = $points;
		$selectranks = $ranks;
		$selectfield_current = intval($field_current);
		$selectfield_max = intval($field_max);
		$selecttemp_min = intval($temp_min);
		$selecttemp_max = intval($temp_max);
		$selectmetal = $metal;
		$selectmetal_perhour = intval($metal_perhour);
		$selectmetal_max = $metal_max;
		$selectcrystal = $crystal;
		$selectcrystal_perhour = intval($crystal_perhour);
		$selectcrystal_max = $crystal_max;
		$selectdeuterium = $deuterium;
		$selectdeuterium_perhour = intval($deuterium_perhour);
		$selectdeuterium_max = $deuterium_max;
		$selectenergy_used = intval($energy_used);
		$selectenergy_max = intval($energy_max);
		$selectmetal_mine = intval($metal_mine);
		$selectcrystal_mine = intval($crystal_mine);
		$selectdeuterium_sintetizer = intval($deuterium_sintetizer);
		$selectsolar_plant = intval($solar_plant);
		$selectfusion_plant = intval($fusion_plant);
		$selectrobot_factory = intval($robot_factory);
		$selectnano_factory = intval($nano_factory);
		$selecthangar = intval($hangar);
		$selectmetal_store = intval($metal_store);
		$selectcrystal_store = intval($crystal_store);
		$selectdeuterium_store = intval($deuterium_store);
		$selectlaboratory = intval($laboratory);
		$selectterraformer = intval($terraformer);
		$selectally_deposit = intval($ally_deposit);
		$selectsilo = intval($silo);
		$selectsmall_ship_cargo = $small_ship_cargo;
		$selectbig_ship_cargo = $big_ship_cargo;
		$selectlight_hunter = $light_hunter;
		$selectheavy_hunter = $heavy_hunter;
		$selectcrusher = $crusher;
		$selectbattle_ship = $battle_ship;
		$selectcolonizer = $colonizer;
		$selectrecycler = $recycler;
		$selectspy_sonde = $spy_sonde;
		$selectbomber_ship = $bomber_ship;
		$selectsolar_satelit = $solar_satelit;
		$selectdestructor = $destructor;
		$selectdearth_star = $dearth_star;
		$selectbattleship = $battleship;
		$selectmisil_launcher = $misil_launcher;
		$selectsmall_laser = $small_laser;
		$selectbig_laser = $big_laser;
		$selectgauss_canyon = $gauss_canyon;
		$selectionic_canyon = $ionic_canyon;
		$selectbuster_canyon = $buster_canyon;
		$selectsmall_protection_shield = intval($small_protection_shield);
		$selectbig_protection_shield = intval($big_protection_shield);
		$selectinterceptor_misil = intval($interceptor_misil);
		$selectinterplanetary_misil = intval($interplanetary_misil);
		$selectmetal_mine_porcent = intval($metal_mine_porcent);
		$selectcrystal_mine_porcent = intval($crystal_mine_porcent);
		$selectdeuterium_sintetizer_porcent = intval($deuterium_sintetizer_porcent);
		$selectsolar_plant_porcent = intval($solar_plant_porcent);
		$selectfusion_plant_porcent = intval($fusion_plant_porcent);
		$selectsolar_satelit_porcent = intval($solar_satelit_porcent);
		$selectmondbasis = $mondbasis;
		$selectphalanx = $phalanx;
		$selectsprungtor = $sprungtor;
		$selectlast_jump_time = intval($last_jump_time);

		
		
		$statement = $this->_getSelectStatement();
        $statement->execute(array(
		':id'=>$selectid,
		':name'=>$selectname,
		':id_owner'=>$selectid_owner,
		':id_level'=>$selectid_level,
		':galaxy'=>$selectgalaxy,
		':system'=>$selectsystem,
		':planet'=>$selectplanet,
		':last_update'=>$selectlast_update,
		':planet_type'=>$selectplanet_type,
		':destruyed'=>$selectdestruyed,
		':b_building'=>$selectb_building,
		':b_building_id'=>$selectb_building_id,
		':b_tech'=>$selectb_tech,
		':b_tech_id'=>$selectb_tech_id,
		':b_hangar'=>$selectb_hangar,
		':b_hangar_id'=>$selectb_hangar_id,
		':b_hangar_plus'=>$selectb_hangar_plus,
		':image'=>$selectimage,
		':diameter'=>$selectdiameter,
		':points'=>$selectpoints,
		':ranks'=>$selectranks,
		':field_current'=>$selectfield_current,
		':field_max'=>$selectfield_max,
		':temp_min'=>$selecttemp_min,
		':temp_max'=>$selecttemp_max,
		':metal'=>$selectmetal,
		':metal_perhour'=>$selectmetal_perhour,
		':metal_max'=>$selectmetal_max,
		':crystal'=>$selectcrystal,
		':crystal_perhour'=>$selectcrystal_perhour,
		':crystal_max'=>$selectcrystal_max,
		':deuterium'=>$selectdeuterium,
		':deuterium_perhour'=>$selectdeuterium_perhour,
		':deuterium_max'=>$selectdeuterium_max,
		':energy_used'=>$selectenergy_used,
		':energy_max'=>$selectenergy_max,
		':metal_mine'=>$selectmetal_mine,
		':crystal_mine'=>$selectcrystal_mine,
		':deuterium_sintetizer'=>$selectdeuterium_sintetizer,
		':solar_plant'=>$selectsolar_plant,
		':fusion_plant'=>$selectfusion_plant,
		':robot_factory'=>$selectrobot_factory,
		':nano_factory'=>$selectnano_factory,
		':hangar'=>$selecthangar,
		':metal_store'=>$selectmetal_store,
		':crystal_store'=>$selectcrystal_store,
		':deuterium_store'=>$selectdeuterium_store,
		':laboratory'=>$selectlaboratory,
		':terraformer'=>$selectterraformer,
		':ally_deposit'=>$selectally_deposit,
		':silo'=>$selectsilo,
		':small_ship_cargo'=>$selectsmall_ship_cargo,
		':big_ship_cargo'=>$selectbig_ship_cargo,
		':light_hunter'=>$selectlight_hunter,
		':heavy_hunter'=>$selectheavy_hunter,
		':crusher'=>$selectcrusher,
		':battle_ship'=>$selectbattle_ship,
		':colonizer'=>$selectcolonizer,
		':recycler'=>$selectrecycler,
		':spy_sonde'=>$selectspy_sonde,
		':bomber_ship'=>$selectbomber_ship,
		':solar_satelit'=>$selectsolar_satelit,
		':destructor'=>$selectdestructor,
		':dearth_star'=>$selectdearth_star,
		':battleship'=>$selectbattleship,
		':misil_launcher'=>$selectmisil_launcher,
		':small_laser'=>$selectsmall_laser,
		':big_laser'=>$selectbig_laser,
		':gauss_canyon'=>$selectgauss_canyon,
		':ionic_canyon'=>$selectionic_canyon,
		':buster_canyon'=>$selectbuster_canyon,
		':small_protection_shield'=>$selectsmall_protection_shield,
		':big_protection_shield'=>$selectbig_protection_shield,
		':interceptor_misil'=>$selectinterceptor_misil,
		':interplanetary_misil'=>$selectinterplanetary_misil,
		':metal_mine_porcent'=>$selectmetal_mine_porcent,
		':crystal_mine_porcent'=>$selectcrystal_mine_porcent,
		':deuterium_sintetizer_porcent'=>$selectdeuterium_sintetizer_porcent,
		':solar_plant_porcent'=>$selectsolar_plant_porcent,
		':fusion_plant_porcent'=>$selectfusion_plant_porcent,
		':solar_satelit_porcent'=>$selectsolar_satelit_porcent,
		':mondbasis'=>$selectmondbasis,
		':phalanx'=>$selectphalanx,
		':sprungtor'=>$selectsprungtor,
		':last_jump_time'=>$selectlast_jump_time
        ));

        return $statement->fetchAll();
    }
	/****************BEGIN INSERT****************/	

	protected function _getInsertStatement()
    {
        if ($this->_insertStatement === null) {
            $this->_insertStatement = $this->getWriteAdapter()
                ->prepare('INSERT INTO game_planets(`name`,`id_owner`,`id_level`,`galaxy`,`system`,`planet`,`last_update`,`planet_type`,`destruyed`,`b_building`,`b_building_id`,`b_tech`,`b_tech_id`,`b_hangar`,`b_hangar_id`,`b_hangar_plus`,`image`,`diameter`,`points`,`ranks`,`field_current`,`field_max`,`temp_min`,`temp_max`,`metal`,`metal_perhour`,`metal_max`,`crystal`,`crystal_perhour`,`crystal_max`,`deuterium`,`deuterium_perhour`,`deuterium_max`,`energy_used`,`energy_max`,`metal_mine`,`crystal_mine`,`deuterium_sintetizer`,`solar_plant`,`fusion_plant`,`robot_factory`,`nano_factory`,`hangar`,`metal_store`,`crystal_store`,`deuterium_store`,`laboratory`,`terraformer`,`ally_deposit`,`silo`,`small_ship_cargo`,`big_ship_cargo`,`light_hunter`,`heavy_hunter`,`crusher`,`battle_ship`,`colonizer`,`recycler`,`spy_sonde`,`bomber_ship`,`solar_satelit`,`destructor`,`dearth_star`,`battleship`,`misil_launcher`,`small_laser`,`big_laser`,`gauss_canyon`,`ionic_canyon`,`buster_canyon`,`small_protection_shield`,`big_protection_shield`,`interceptor_misil`,`interplanetary_misil`,`metal_mine_porcent`,`crystal_mine_porcent`,`deuterium_sintetizer_porcent`,`solar_plant_porcent`,`fusion_plant_porcent`,`solar_satelit_porcent`,`mondbasis`,`phalanx`,`sprungtor`,`last_jump_time`) VALUES(:name,:id_owner,:id_level,:galaxy,:system,:planet,:last_update,:planet_type,:destruyed,:b_building,:b_building_id,:b_tech,:b_tech_id,:b_hangar,:b_hangar_id,:b_hangar_plus,:image,:diameter,:points,:ranks,:field_current,:field_max,:temp_min,:temp_max,:metal,:metal_perhour,:metal_max,:crystal,:crystal_perhour,:crystal_max,:deuterium,:deuterium_perhour,:deuterium_max,:energy_used,:energy_max,:metal_mine,:crystal_mine,:deuterium_sintetizer,:solar_plant,:fusion_plant,:robot_factory,:nano_factory,:hangar,:metal_store,:crystal_store,:deuterium_store,:laboratory,:terraformer,:ally_deposit,:silo,:small_ship_cargo,:big_ship_cargo,:light_hunter,:heavy_hunter,:crusher,:battle_ship,:colonizer,:recycler,:spy_sonde,:bomber_ship,:solar_satelit,:destructor,:dearth_star,:battleship,:misil_launcher,:small_laser,:big_laser,:gauss_canyon,:ionic_canyon,:buster_canyon,:small_protection_shield,:big_protection_shield,:interceptor_misil,:interplanetary_misil,:metal_mine_porcent,:crystal_mine_porcent,:deuterium_sintetizer_porcent,:solar_plant_porcent,:fusion_plant_porcent,:solar_satelit_porcent,:mondbasis,:phalanx,:sprungtor,:last_jump_time)');
        }

        return $this->_insertStatement;
    }

    /**
     */
    public function insert($name,$id_owner,$id_level,$galaxy,$system,$planet,$last_update,$planet_type,$destruyed,$b_building,$b_building_id,$b_tech,$b_tech_id,$b_hangar,$b_hangar_id,$b_hangar_plus,$image,$diameter,$points,$ranks,$field_current,$field_max,$temp_min,$temp_max,$metal,$metal_perhour,$metal_max,$crystal,$crystal_perhour,$crystal_max,$deuterium,$deuterium_perhour,$deuterium_max,$energy_used,$energy_max,$metal_mine,$crystal_mine,$deuterium_sintetizer,$solar_plant,$fusion_plant,$robot_factory,$nano_factory,$hangar,$metal_store,$crystal_store,$deuterium_store,$laboratory,$terraformer,$ally_deposit,$silo,$small_ship_cargo,$big_ship_cargo,$light_hunter,$heavy_hunter,$crusher,$battle_ship,$colonizer,$recycler,$spy_sonde,$bomber_ship,$solar_satelit,$destructor,$dearth_star,$battleship,$misil_launcher,$small_laser,$big_laser,$gauss_canyon,$ionic_canyon,$buster_canyon,$small_protection_shield,$big_protection_shield,$interceptor_misil,$interplanetary_misil,$metal_mine_porcent,$crystal_mine_porcent,$deuterium_sintetizer_porcent,$solar_plant_porcent,$fusion_plant_porcent,$solar_satelit_porcent,$mondbasis,$phalanx,$sprungtor,$last_jump_time)
    {
		// 
		$insertname = $name;
		$insertid_owner = intval($id_owner);
		$insertid_level = intval($id_level);
		$insertgalaxy = intval($galaxy);
		$insertsystem = intval($system);
		$insertplanet = intval($planet);
		$insertlast_update = intval($last_update);
		$insertplanet_type = intval($planet_type);
		$insertdestruyed = intval($destruyed);
		$insertb_building = intval($b_building);
		$insertb_building_id = $b_building_id;
		$insertb_tech = intval($b_tech);
		$insertb_tech_id = intval($b_tech_id);
		$insertb_hangar = intval($b_hangar);
		$insertb_hangar_id = $b_hangar_id;
		$insertb_hangar_plus = intval($b_hangar_plus);
		$insertimage = $image;
		$insertdiameter = intval($diameter);
		$insertpoints = $points;
		$insertranks = $ranks;
		$insertfield_current = intval($field_current);
		$insertfield_max = intval($field_max);
		$inserttemp_min = intval($temp_min);
		$inserttemp_max = intval($temp_max);
		$insertmetal = $metal;
		$insertmetal_perhour = intval($metal_perhour);
		$insertmetal_max = $metal_max;
		$insertcrystal = $crystal;
		$insertcrystal_perhour = intval($crystal_perhour);
		$insertcrystal_max = $crystal_max;
		$insertdeuterium = $deuterium;
		$insertdeuterium_perhour = intval($deuterium_perhour);
		$insertdeuterium_max = $deuterium_max;
		$insertenergy_used = intval($energy_used);
		$insertenergy_max = intval($energy_max);
		$insertmetal_mine = intval($metal_mine);
		$insertcrystal_mine = intval($crystal_mine);
		$insertdeuterium_sintetizer = intval($deuterium_sintetizer);
		$insertsolar_plant = intval($solar_plant);
		$insertfusion_plant = intval($fusion_plant);
		$insertrobot_factory = intval($robot_factory);
		$insertnano_factory = intval($nano_factory);
		$inserthangar = intval($hangar);
		$insertmetal_store = intval($metal_store);
		$insertcrystal_store = intval($crystal_store);
		$insertdeuterium_store = intval($deuterium_store);
		$insertlaboratory = intval($laboratory);
		$insertterraformer = intval($terraformer);
		$insertally_deposit = intval($ally_deposit);
		$insertsilo = intval($silo);
		$insertsmall_ship_cargo = $small_ship_cargo;
		$insertbig_ship_cargo = $big_ship_cargo;
		$insertlight_hunter = $light_hunter;
		$insertheavy_hunter = $heavy_hunter;
		$insertcrusher = $crusher;
		$insertbattle_ship = $battle_ship;
		$insertcolonizer = $colonizer;
		$insertrecycler = $recycler;
		$insertspy_sonde = $spy_sonde;
		$insertbomber_ship = $bomber_ship;
		$insertsolar_satelit = $solar_satelit;
		$insertdestructor = $destructor;
		$insertdearth_star = $dearth_star;
		$insertbattleship = $battleship;
		$insertmisil_launcher = $misil_launcher;
		$insertsmall_laser = $small_laser;
		$insertbig_laser = $big_laser;
		$insertgauss_canyon = $gauss_canyon;
		$insertionic_canyon = $ionic_canyon;
		$insertbuster_canyon = $buster_canyon;
		$insertsmall_protection_shield = intval($small_protection_shield);
		$insertbig_protection_shield = intval($big_protection_shield);
		$insertinterceptor_misil = intval($interceptor_misil);
		$insertinterplanetary_misil = intval($interplanetary_misil);
		$insertmetal_mine_porcent = intval($metal_mine_porcent);
		$insertcrystal_mine_porcent = intval($crystal_mine_porcent);
		$insertdeuterium_sintetizer_porcent = intval($deuterium_sintetizer_porcent);
		$insertsolar_plant_porcent = intval($solar_plant_porcent);
		$insertfusion_plant_porcent = intval($fusion_plant_porcent);
		$insertsolar_satelit_porcent = intval($solar_satelit_porcent);
		$insertmondbasis = $mondbasis;
		$insertphalanx = $phalanx;
		$insertsprungtor = $sprungtor;
		$insertlast_jump_time = intval($last_jump_time);

	
        $statement = $this->_getInsertStatement();
        $result = $statement->execute(array(
		':name'=>$insertname,
		':id_owner'=>$insertid_owner,
		':id_level'=>$insertid_level,
		':galaxy'=>$insertgalaxy,
		':system'=>$insertsystem,
		':planet'=>$insertplanet,
		':last_update'=>$insertlast_update,
		':planet_type'=>$insertplanet_type,
		':destruyed'=>$insertdestruyed,
		':b_building'=>$insertb_building,
		':b_building_id'=>$insertb_building_id,
		':b_tech'=>$insertb_tech,
		':b_tech_id'=>$insertb_tech_id,
		':b_hangar'=>$insertb_hangar,
		':b_hangar_id'=>$insertb_hangar_id,
		':b_hangar_plus'=>$insertb_hangar_plus,
		':image'=>$insertimage,
		':diameter'=>$insertdiameter,
		':points'=>$insertpoints,
		':ranks'=>$insertranks,
		':field_current'=>$insertfield_current,
		':field_max'=>$insertfield_max,
		':temp_min'=>$inserttemp_min,
		':temp_max'=>$inserttemp_max,
		':metal'=>$insertmetal,
		':metal_perhour'=>$insertmetal_perhour,
		':metal_max'=>$insertmetal_max,
		':crystal'=>$insertcrystal,
		':crystal_perhour'=>$insertcrystal_perhour,
		':crystal_max'=>$insertcrystal_max,
		':deuterium'=>$insertdeuterium,
		':deuterium_perhour'=>$insertdeuterium_perhour,
		':deuterium_max'=>$insertdeuterium_max,
		':energy_used'=>$insertenergy_used,
		':energy_max'=>$insertenergy_max,
		':metal_mine'=>$insertmetal_mine,
		':crystal_mine'=>$insertcrystal_mine,
		':deuterium_sintetizer'=>$insertdeuterium_sintetizer,
		':solar_plant'=>$insertsolar_plant,
		':fusion_plant'=>$insertfusion_plant,
		':robot_factory'=>$insertrobot_factory,
		':nano_factory'=>$insertnano_factory,
		':hangar'=>$inserthangar,
		':metal_store'=>$insertmetal_store,
		':crystal_store'=>$insertcrystal_store,
		':deuterium_store'=>$insertdeuterium_store,
		':laboratory'=>$insertlaboratory,
		':terraformer'=>$insertterraformer,
		':ally_deposit'=>$insertally_deposit,
		':silo'=>$insertsilo,
		':small_ship_cargo'=>$insertsmall_ship_cargo,
		':big_ship_cargo'=>$insertbig_ship_cargo,
		':light_hunter'=>$insertlight_hunter,
		':heavy_hunter'=>$insertheavy_hunter,
		':crusher'=>$insertcrusher,
		':battle_ship'=>$insertbattle_ship,
		':colonizer'=>$insertcolonizer,
		':recycler'=>$insertrecycler,
		':spy_sonde'=>$insertspy_sonde,
		':bomber_ship'=>$insertbomber_ship,
		':solar_satelit'=>$insertsolar_satelit,
		':destructor'=>$insertdestructor,
		':dearth_star'=>$insertdearth_star,
		':battleship'=>$insertbattleship,
		':misil_launcher'=>$insertmisil_launcher,
		':small_laser'=>$insertsmall_laser,
		':big_laser'=>$insertbig_laser,
		':gauss_canyon'=>$insertgauss_canyon,
		':ionic_canyon'=>$insertionic_canyon,
		':buster_canyon'=>$insertbuster_canyon,
		':small_protection_shield'=>$insertsmall_protection_shield,
		':big_protection_shield'=>$insertbig_protection_shield,
		':interceptor_misil'=>$insertinterceptor_misil,
		':interplanetary_misil'=>$insertinterplanetary_misil,
		':metal_mine_porcent'=>$insertmetal_mine_porcent,
		':crystal_mine_porcent'=>$insertcrystal_mine_porcent,
		':deuterium_sintetizer_porcent'=>$insertdeuterium_sintetizer_porcent,
		':solar_plant_porcent'=>$insertsolar_plant_porcent,
		':fusion_plant_porcent'=>$insertfusion_plant_porcent,
		':solar_satelit_porcent'=>$insertsolar_satelit_porcent,
		':mondbasis'=>$insertmondbasis,
		':phalanx'=>$insertphalanx,
		':sprungtor'=>$insertsprungtor,
		':last_jump_time'=>$insertlast_jump_time
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
                ->prepare('DELETE FROM game_planets WHERE `id`=:id;');
        }
        return $this->_deleteoneStatement;
    }


    public function delete($text)
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
                ->prepare('UPDATE game_planets SET `name`=:name,`id_owner`=:id_owner,`id_level`=:id_level,`galaxy`=:galaxy,`system`=:system,`planet`=:planet,`last_update`=:last_update,`planet_type`=:planet_type,`destruyed`=:destruyed,`b_building`=:b_building,`b_building_id`=:b_building_id,`b_tech`=:b_tech,`b_tech_id`=:b_tech_id,`b_hangar`=:b_hangar,`b_hangar_id`=:b_hangar_id,`b_hangar_plus`=:b_hangar_plus,`image`=:image,`diameter`=:diameter,`points`=:points,`ranks`=:ranks,`field_current`=:field_current,`field_max`=:field_max,`temp_min`=:temp_min,`temp_max`=:temp_max,`metal`=:metal,`metal_perhour`=:metal_perhour,`metal_max`=:metal_max,`crystal`=:crystal,`crystal_perhour`=:crystal_perhour,`crystal_max`=:crystal_max,`deuterium`=:deuterium,`deuterium_perhour`=:deuterium_perhour,`deuterium_max`=:deuterium_max,`energy_used`=:energy_used,`energy_max`=:energy_max,`metal_mine`=:metal_mine,`crystal_mine`=:crystal_mine,`deuterium_sintetizer`=:deuterium_sintetizer,`solar_plant`=:solar_plant,`fusion_plant`=:fusion_plant,`robot_factory`=:robot_factory,`nano_factory`=:nano_factory,`hangar`=:hangar,`metal_store`=:metal_store,`crystal_store`=:crystal_store,`deuterium_store`=:deuterium_store,`laboratory`=:laboratory,`terraformer`=:terraformer,`ally_deposit`=:ally_deposit,`silo`=:silo,`small_ship_cargo`=:small_ship_cargo,`big_ship_cargo`=:big_ship_cargo,`light_hunter`=:light_hunter,`heavy_hunter`=:heavy_hunter,`crusher`=:crusher,`battle_ship`=:battle_ship,`colonizer`=:colonizer,`recycler`=:recycler,`spy_sonde`=:spy_sonde,`bomber_ship`=:bomber_ship,`solar_satelit`=:solar_satelit,`destructor`=:destructor,`dearth_star`=:dearth_star,`battleship`=:battleship,`misil_launcher`=:misil_launcher,`small_laser`=:small_laser,`big_laser`=:big_laser,`gauss_canyon`=:gauss_canyon,`ionic_canyon`=:ionic_canyon,`buster_canyon`=:buster_canyon,`small_protection_shield`=:small_protection_shield,`big_protection_shield`=:big_protection_shield,`interceptor_misil`=:interceptor_misil,`interplanetary_misil`=:interplanetary_misil,`metal_mine_porcent`=:metal_mine_porcent,`crystal_mine_porcent`=:crystal_mine_porcent,`deuterium_sintetizer_porcent`=:deuterium_sintetizer_porcent,`solar_plant_porcent`=:solar_plant_porcent,`fusion_plant_porcent`=:fusion_plant_porcent,`solar_satelit_porcent`=:solar_satelit_porcent,`mondbasis`=:mondbasis,`phalanx`=:phalanx,`sprungtor`=:sprungtor,`last_jump_time`=:last_jump_time WHERE `id`=:id');
        }

        return $this->_updateStatement;
    }

    public function update($id,$name,$id_owner,$id_level,$galaxy,$system,$planet,$last_update,$planet_type,$destruyed,$b_building,$b_building_id,$b_tech,$b_tech_id,$b_hangar,$b_hangar_id,$b_hangar_plus,$image,$diameter,$points,$ranks,$field_current,$field_max,$temp_min,$temp_max,$metal,$metal_perhour,$metal_max,$crystal,$crystal_perhour,$crystal_max,$deuterium,$deuterium_perhour,$deuterium_max,$energy_used,$energy_max,$metal_mine,$crystal_mine,$deuterium_sintetizer,$solar_plant,$fusion_plant,$robot_factory,$nano_factory,$hangar,$metal_store,$crystal_store,$deuterium_store,$laboratory,$terraformer,$ally_deposit,$silo,$small_ship_cargo,$big_ship_cargo,$light_hunter,$heavy_hunter,$crusher,$battle_ship,$colonizer,$recycler,$spy_sonde,$bomber_ship,$solar_satelit,$destructor,$dearth_star,$battleship,$misil_launcher,$small_laser,$big_laser,$gauss_canyon,$ionic_canyon,$buster_canyon,$small_protection_shield,$big_protection_shield,$interceptor_misil,$interplanetary_misil,$metal_mine_porcent,$crystal_mine_porcent,$deuterium_sintetizer_porcent,$solar_plant_porcent,$fusion_plant_porcent,$solar_satelit_porcent,$mondbasis,$phalanx,$sprungtor,$last_jump_time)
    {
		//securité
		$updateid = $id;
		$updatename = $name;
		$updateid_owner = intval($id_owner);
		$updateid_level = intval($id_level);
		$updategalaxy = intval($galaxy);
		$updatesystem = intval($system);
		$updateplanet = intval($planet);
		$updatelast_update = intval($last_update);
		$updateplanet_type = intval($planet_type);
		$updatedestruyed = intval($destruyed);
		$updateb_building = intval($b_building);
		$updateb_building_id = $b_building_id;
		$updateb_tech = intval($b_tech);
		$updateb_tech_id = intval($b_tech_id);
		$updateb_hangar = intval($b_hangar);
		$updateb_hangar_id = $b_hangar_id;
		$updateb_hangar_plus = intval($b_hangar_plus);
		$updateimage = $image;
		$updatediameter = intval($diameter);
		$updatepoints = $points;
		$updateranks = $ranks;
		$updatefield_current = intval($field_current);
		$updatefield_max = intval($field_max);
		$updatetemp_min = intval($temp_min);
		$updatetemp_max = intval($temp_max);
		$updatemetal = $metal;
		$updatemetal_perhour = intval($metal_perhour);
		$updatemetal_max = $metal_max;
		$updatecrystal = $crystal;
		$updatecrystal_perhour = intval($crystal_perhour);
		$updatecrystal_max = $crystal_max;
		$updatedeuterium = $deuterium;
		$updatedeuterium_perhour = intval($deuterium_perhour);
		$updatedeuterium_max = $deuterium_max;
		$updateenergy_used = intval($energy_used);
		$updateenergy_max = intval($energy_max);
		$updatemetal_mine = intval($metal_mine);
		$updatecrystal_mine = intval($crystal_mine);
		$updatedeuterium_sintetizer = intval($deuterium_sintetizer);
		$updatesolar_plant = intval($solar_plant);
		$updatefusion_plant = intval($fusion_plant);
		$updaterobot_factory = intval($robot_factory);
		$updatenano_factory = intval($nano_factory);
		$updatehangar = intval($hangar);
		$updatemetal_store = intval($metal_store);
		$updatecrystal_store = intval($crystal_store);
		$updatedeuterium_store = intval($deuterium_store);
		$updatelaboratory = intval($laboratory);
		$updateterraformer = intval($terraformer);
		$updateally_deposit = intval($ally_deposit);
		$updatesilo = intval($silo);
		$updatesmall_ship_cargo = $small_ship_cargo;
		$updatebig_ship_cargo = $big_ship_cargo;
		$updatelight_hunter = $light_hunter;
		$updateheavy_hunter = $heavy_hunter;
		$updatecrusher = $crusher;
		$updatebattle_ship = $battle_ship;
		$updatecolonizer = $colonizer;
		$updaterecycler = $recycler;
		$updatespy_sonde = $spy_sonde;
		$updatebomber_ship = $bomber_ship;
		$updatesolar_satelit = $solar_satelit;
		$updatedestructor = $destructor;
		$updatedearth_star = $dearth_star;
		$updatebattleship = $battleship;
		$updatemisil_launcher = $misil_launcher;
		$updatesmall_laser = $small_laser;
		$updatebig_laser = $big_laser;
		$updategauss_canyon = $gauss_canyon;
		$updateionic_canyon = $ionic_canyon;
		$updatebuster_canyon = $buster_canyon;
		$updatesmall_protection_shield = intval($small_protection_shield);
		$updatebig_protection_shield = intval($big_protection_shield);
		$updateinterceptor_misil = intval($interceptor_misil);
		$updateinterplanetary_misil = intval($interplanetary_misil);
		$updatemetal_mine_porcent = intval($metal_mine_porcent);
		$updatecrystal_mine_porcent = intval($crystal_mine_porcent);
		$updatedeuterium_sintetizer_porcent = intval($deuterium_sintetizer_porcent);
		$updatesolar_plant_porcent = intval($solar_plant_porcent);
		$updatefusion_plant_porcent = intval($fusion_plant_porcent);
		$updatesolar_satelit_porcent = intval($solar_satelit_porcent);
		$updatemondbasis = $mondbasis;
		$updatephalanx = $phalanx;
		$updatesprungtor = $sprungtor;
		$updatelast_jump_time = intval($last_jump_time);

		
        $statement = $this->_getUpdateStatement();
        $result = $statement->execute(array(
		':id'=>$updateid,
		':name'=>$updatename,
		':id_owner'=>$updateid_owner,
		':id_level'=>$updateid_level,
		':galaxy'=>$updategalaxy,
		':system'=>$updatesystem,
		':planet'=>$updateplanet,
		':last_update'=>$updatelast_update,
		':planet_type'=>$updateplanet_type,
		':destruyed'=>$updatedestruyed,
		':b_building'=>$updateb_building,
		':b_building_id'=>$updateb_building_id,
		':b_tech'=>$updateb_tech,
		':b_tech_id'=>$updateb_tech_id,
		':b_hangar'=>$updateb_hangar,
		':b_hangar_id'=>$updateb_hangar_id,
		':b_hangar_plus'=>$updateb_hangar_plus,
		':image'=>$updateimage,
		':diameter'=>$updatediameter,
		':points'=>$updatepoints,
		':ranks'=>$updateranks,
		':field_current'=>$updatefield_current,
		':field_max'=>$updatefield_max,
		':temp_min'=>$updatetemp_min,
		':temp_max'=>$updatetemp_max,
		':metal'=>$updatemetal,
		':metal_perhour'=>$updatemetal_perhour,
		':metal_max'=>$updatemetal_max,
		':crystal'=>$updatecrystal,
		':crystal_perhour'=>$updatecrystal_perhour,
		':crystal_max'=>$updatecrystal_max,
		':deuterium'=>$updatedeuterium,
		':deuterium_perhour'=>$updatedeuterium_perhour,
		':deuterium_max'=>$updatedeuterium_max,
		':energy_used'=>$updateenergy_used,
		':energy_max'=>$updateenergy_max,
		':metal_mine'=>$updatemetal_mine,
		':crystal_mine'=>$updatecrystal_mine,
		':deuterium_sintetizer'=>$updatedeuterium_sintetizer,
		':solar_plant'=>$updatesolar_plant,
		':fusion_plant'=>$updatefusion_plant,
		':robot_factory'=>$updaterobot_factory,
		':nano_factory'=>$updatenano_factory,
		':hangar'=>$updatehangar,
		':metal_store'=>$updatemetal_store,
		':crystal_store'=>$updatecrystal_store,
		':deuterium_store'=>$updatedeuterium_store,
		':laboratory'=>$updatelaboratory,
		':terraformer'=>$updateterraformer,
		':ally_deposit'=>$updateally_deposit,
		':silo'=>$updatesilo,
		':small_ship_cargo'=>$updatesmall_ship_cargo,
		':big_ship_cargo'=>$updatebig_ship_cargo,
		':light_hunter'=>$updatelight_hunter,
		':heavy_hunter'=>$updateheavy_hunter,
		':crusher'=>$updatecrusher,
		':battle_ship'=>$updatebattle_ship,
		':colonizer'=>$updatecolonizer,
		':recycler'=>$updaterecycler,
		':spy_sonde'=>$updatespy_sonde,
		':bomber_ship'=>$updatebomber_ship,
		':solar_satelit'=>$updatesolar_satelit,
		':destructor'=>$updatedestructor,
		':dearth_star'=>$updatedearth_star,
		':battleship'=>$updatebattleship,
		':misil_launcher'=>$updatemisil_launcher,
		':small_laser'=>$updatesmall_laser,
		':big_laser'=>$updatebig_laser,
		':gauss_canyon'=>$updategauss_canyon,
		':ionic_canyon'=>$updateionic_canyon,
		':buster_canyon'=>$updatebuster_canyon,
		':small_protection_shield'=>$updatesmall_protection_shield,
		':big_protection_shield'=>$updatebig_protection_shield,
		':interceptor_misil'=>$updateinterceptor_misil,
		':interplanetary_misil'=>$updateinterplanetary_misil,
		':metal_mine_porcent'=>$updatemetal_mine_porcent,
		':crystal_mine_porcent'=>$updatecrystal_mine_porcent,
		':deuterium_sintetizer_porcent'=>$updatedeuterium_sintetizer_porcent,
		':solar_plant_porcent'=>$updatesolar_plant_porcent,
		':fusion_plant_porcent'=>$updatefusion_plant_porcent,
		':solar_satelit_porcent'=>$updatesolar_satelit_porcent,
		':mondbasis'=>$updatemondbasis,
		':phalanx'=>$updatephalanx,
		':sprungtor'=>$updatesprungtor,
		':last_jump_time'=>$updatelast_jump_time
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
        return $this->getWriteAdapter()->exec('TRUNCATE TABLE game_planets');
    }
}