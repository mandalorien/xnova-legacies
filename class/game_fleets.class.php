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

class game_fleets extends BaseModel
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
					->prepare('SELECT * FROM game_fleets ORDER BY `id` DESC');
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
                ->prepare('SELECT * FROM game_fleets WHERE `fleet_id`=:fleet_id or`fleet_owner`=:fleet_owner or`fleet_mission`=:fleet_mission or`fleet_amount`=:fleet_amount or`fleet_array`=:fleet_array or`fleet_start_time`=:fleet_start_time or`fleet_start_galaxy`=:fleet_start_galaxy or`fleet_start_system`=:fleet_start_system or`fleet_start_planet`=:fleet_start_planet or`fleet_start_type`=:fleet_start_type or`fleet_end_time`=:fleet_end_time or`fleet_end_stay`=:fleet_end_stay or`fleet_end_galaxy`=:fleet_end_galaxy or`fleet_end_system`=:fleet_end_system or`fleet_end_planet`=:fleet_end_planet or`fleet_end_type`=:fleet_end_type or`fleet_taget_owner`=:fleet_taget_owner or`fleet_resource_metal`=:fleet_resource_metal or`fleet_resource_crystal`=:fleet_resource_crystal or`fleet_resource_deuterium`=:fleet_resource_deuterium or`fleet_target_owner`=:fleet_target_owner or`fleet_group`=:fleet_group or`fleet_mess`=:fleet_mess or`start_time`=:start_time  LIMIT 1');
        }

        return $this->_selectStatement;
    }

    public function select($fleet_id,$fleet_owner,$fleet_mission,$fleet_amount,$fleet_array,$fleet_start_time,$fleet_start_galaxy,$fleet_start_system,$fleet_start_planet,$fleet_start_type,$fleet_end_time,$fleet_end_stay,$fleet_end_galaxy,$fleet_end_system,$fleet_end_planet,$fleet_end_type,$fleet_taget_owner,$fleet_resource_metal,$fleet_resource_crystal,$fleet_resource_deuterium,$fleet_target_owner,$fleet_group,$fleet_mess,$start_time)
    {
		// securité
		$selectfleet_id = $fleet_id;
		$selectfleet_owner = intval($fleet_owner);
		$selectfleet_mission = intval($fleet_mission);
		$selectfleet_amount = $fleet_amount;
		$selectfleet_array = $fleet_array;
		$selectfleet_start_time = intval($fleet_start_time);
		$selectfleet_start_galaxy = intval($fleet_start_galaxy);
		$selectfleet_start_system = intval($fleet_start_system);
		$selectfleet_start_planet = intval($fleet_start_planet);
		$selectfleet_start_type = intval($fleet_start_type);
		$selectfleet_end_time = intval($fleet_end_time);
		$selectfleet_end_stay = intval($fleet_end_stay);
		$selectfleet_end_galaxy = intval($fleet_end_galaxy);
		$selectfleet_end_system = intval($fleet_end_system);
		$selectfleet_end_planet = intval($fleet_end_planet);
		$selectfleet_end_type = intval($fleet_end_type);
		$selectfleet_taget_owner = intval($fleet_taget_owner);
		$selectfleet_resource_metal = $fleet_resource_metal;
		$selectfleet_resource_crystal = $fleet_resource_crystal;
		$selectfleet_resource_deuterium = $fleet_resource_deuterium;
		$selectfleet_target_owner = intval($fleet_target_owner);
		$selectfleet_group = intval($fleet_group);
		$selectfleet_mess = intval($fleet_mess);
		$selectstart_time = intval($start_time);

		
		
		$statement = $this->_getSelectStatement();
        $statement->execute(array(
		':fleet_id'=>$selectfleet_id,
		':fleet_owner'=>$selectfleet_owner,
		':fleet_mission'=>$selectfleet_mission,
		':fleet_amount'=>$selectfleet_amount,
		':fleet_array'=>$selectfleet_array,
		':fleet_start_time'=>$selectfleet_start_time,
		':fleet_start_galaxy'=>$selectfleet_start_galaxy,
		':fleet_start_system'=>$selectfleet_start_system,
		':fleet_start_planet'=>$selectfleet_start_planet,
		':fleet_start_type'=>$selectfleet_start_type,
		':fleet_end_time'=>$selectfleet_end_time,
		':fleet_end_stay'=>$selectfleet_end_stay,
		':fleet_end_galaxy'=>$selectfleet_end_galaxy,
		':fleet_end_system'=>$selectfleet_end_system,
		':fleet_end_planet'=>$selectfleet_end_planet,
		':fleet_end_type'=>$selectfleet_end_type,
		':fleet_taget_owner'=>$selectfleet_taget_owner,
		':fleet_resource_metal'=>$selectfleet_resource_metal,
		':fleet_resource_crystal'=>$selectfleet_resource_crystal,
		':fleet_resource_deuterium'=>$selectfleet_resource_deuterium,
		':fleet_target_owner'=>$selectfleet_target_owner,
		':fleet_group'=>$selectfleet_group,
		':fleet_mess'=>$selectfleet_mess,
		':start_time'=>$selectstart_time
        ));

        return $statement->fetchAll();
    }
	/****************BEGIN INSERT****************/	

	protected function _getInsertStatement()
    {
        if ($this->_insertStatement === null) {
            $this->_insertStatement = $this->getWriteAdapter()
                ->prepare('INSERT INTO game_fleets(`fleet_id`,`fleet_owner`,`fleet_mission`,`fleet_amount`,`fleet_array`,`fleet_start_time`,`fleet_start_galaxy`,`fleet_start_system`,`fleet_start_planet`,`fleet_start_type`,`fleet_end_time`,`fleet_end_stay`,`fleet_end_galaxy`,`fleet_end_system`,`fleet_end_planet`,`fleet_end_type`,`fleet_taget_owner`,`fleet_resource_metal`,`fleet_resource_crystal`,`fleet_resource_deuterium`,`fleet_target_owner`,`fleet_group`,`fleet_mess`,`start_time`) VALUES(:fleet_id,:fleet_owner,:fleet_mission,:fleet_amount,:fleet_array,:fleet_start_time,:fleet_start_galaxy,:fleet_start_system,:fleet_start_planet,:fleet_start_type,:fleet_end_time,:fleet_end_stay,:fleet_end_galaxy,:fleet_end_system,:fleet_end_planet,:fleet_end_type,:fleet_taget_owner,:fleet_resource_metal,:fleet_resource_crystal,:fleet_resource_deuterium,:fleet_target_owner,:fleet_group,:fleet_mess,:start_time)');
        }

        return $this->_insertStatement;
    }

    /**
     */
    public function insert($fleet_id,$fleet_owner,$fleet_mission,$fleet_amount,$fleet_array,$fleet_start_time,$fleet_start_galaxy,$fleet_start_system,$fleet_start_planet,$fleet_start_type,$fleet_end_time,$fleet_end_stay,$fleet_end_galaxy,$fleet_end_system,$fleet_end_planet,$fleet_end_type,$fleet_taget_owner,$fleet_resource_metal,$fleet_resource_crystal,$fleet_resource_deuterium,$fleet_target_owner,$fleet_group,$fleet_mess,$start_time)
    {
		// 
		$insertfleet_id = $fleet_id;
		$insertfleet_owner = intval($fleet_owner);
		$insertfleet_mission = intval($fleet_mission);
		$insertfleet_amount = $fleet_amount;
		$insertfleet_array = $fleet_array;
		$insertfleet_start_time = intval($fleet_start_time);
		$insertfleet_start_galaxy = intval($fleet_start_galaxy);
		$insertfleet_start_system = intval($fleet_start_system);
		$insertfleet_start_planet = intval($fleet_start_planet);
		$insertfleet_start_type = intval($fleet_start_type);
		$insertfleet_end_time = intval($fleet_end_time);
		$insertfleet_end_stay = intval($fleet_end_stay);
		$insertfleet_end_galaxy = intval($fleet_end_galaxy);
		$insertfleet_end_system = intval($fleet_end_system);
		$insertfleet_end_planet = intval($fleet_end_planet);
		$insertfleet_end_type = intval($fleet_end_type);
		$insertfleet_taget_owner = intval($fleet_taget_owner);
		$insertfleet_resource_metal = $fleet_resource_metal;
		$insertfleet_resource_crystal = $fleet_resource_crystal;
		$insertfleet_resource_deuterium = $fleet_resource_deuterium;
		$insertfleet_target_owner = intval($fleet_target_owner);
		$insertfleet_group = intval($fleet_group);
		$insertfleet_mess = intval($fleet_mess);
		$insertstart_time = intval($start_time);

	
        $statement = $this->_getInsertStatement();
        $result = $statement->execute(array(
		':fleet_id'=>$insertfleet_id,
		':fleet_owner'=>$insertfleet_owner,
		':fleet_mission'=>$insertfleet_mission,
		':fleet_amount'=>$insertfleet_amount,
		':fleet_array'=>$insertfleet_array,
		':fleet_start_time'=>$insertfleet_start_time,
		':fleet_start_galaxy'=>$insertfleet_start_galaxy,
		':fleet_start_system'=>$insertfleet_start_system,
		':fleet_start_planet'=>$insertfleet_start_planet,
		':fleet_start_type'=>$insertfleet_start_type,
		':fleet_end_time'=>$insertfleet_end_time,
		':fleet_end_stay'=>$insertfleet_end_stay,
		':fleet_end_galaxy'=>$insertfleet_end_galaxy,
		':fleet_end_system'=>$insertfleet_end_system,
		':fleet_end_planet'=>$insertfleet_end_planet,
		':fleet_end_type'=>$insertfleet_end_type,
		':fleet_taget_owner'=>$insertfleet_taget_owner,
		':fleet_resource_metal'=>$insertfleet_resource_metal,
		':fleet_resource_crystal'=>$insertfleet_resource_crystal,
		':fleet_resource_deuterium'=>$insertfleet_resource_deuterium,
		':fleet_target_owner'=>$insertfleet_target_owner,
		':fleet_group'=>$insertfleet_group,
		':fleet_mess'=>$insertfleet_mess,
		':start_time'=>$insertstart_time
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
                ->prepare('DELETE FROM game_fleets WHERE `id`=:id;');
        }
        return $this->_deleteoneStatement;
    }


    public function delete($email)
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
                ->prepare('UPDATE game_fleets SET `fleet_id`=:fleet_id,`fleet_owner`=:fleet_owner,`fleet_mission`=:fleet_mission,`fleet_amount`=:fleet_amount,`fleet_array`=:fleet_array,`fleet_start_time`=:fleet_start_time,`fleet_start_galaxy`=:fleet_start_galaxy,`fleet_start_system`=:fleet_start_system,`fleet_start_planet`=:fleet_start_planet,`fleet_start_type`=:fleet_start_type,`fleet_end_time`=:fleet_end_time,`fleet_end_stay`=:fleet_end_stay,`fleet_end_galaxy`=:fleet_end_galaxy,`fleet_end_system`=:fleet_end_system,`fleet_end_planet`=:fleet_end_planet,`fleet_end_type`=:fleet_end_type,`fleet_taget_owner`=:fleet_taget_owner,`fleet_resource_metal`=:fleet_resource_metal,`fleet_resource_crystal`=:fleet_resource_crystal,`fleet_resource_deuterium`=:fleet_resource_deuterium,`fleet_target_owner`=:fleet_target_owner,`fleet_group`=:fleet_group,`fleet_mess`=:fleet_mess,`start_time`=:start_time WHERE ');
        }

        return $this->_updateStatement;
    }

    public function update($fleet_id,$fleet_owner,$fleet_mission,$fleet_amount,$fleet_array,$fleet_start_time,$fleet_start_galaxy,$fleet_start_system,$fleet_start_planet,$fleet_start_type,$fleet_end_time,$fleet_end_stay,$fleet_end_galaxy,$fleet_end_system,$fleet_end_planet,$fleet_end_type,$fleet_taget_owner,$fleet_resource_metal,$fleet_resource_crystal,$fleet_resource_deuterium,$fleet_target_owner,$fleet_group,$fleet_mess,$start_time)
    {
		//securité
		$updatefleet_id = $fleet_id;
		$updatefleet_owner = intval($fleet_owner);
		$updatefleet_mission = intval($fleet_mission);
		$updatefleet_amount = $fleet_amount;
		$updatefleet_array = $fleet_array;
		$updatefleet_start_time = intval($fleet_start_time);
		$updatefleet_start_galaxy = intval($fleet_start_galaxy);
		$updatefleet_start_system = intval($fleet_start_system);
		$updatefleet_start_planet = intval($fleet_start_planet);
		$updatefleet_start_type = intval($fleet_start_type);
		$updatefleet_end_time = intval($fleet_end_time);
		$updatefleet_end_stay = intval($fleet_end_stay);
		$updatefleet_end_galaxy = intval($fleet_end_galaxy);
		$updatefleet_end_system = intval($fleet_end_system);
		$updatefleet_end_planet = intval($fleet_end_planet);
		$updatefleet_end_type = intval($fleet_end_type);
		$updatefleet_taget_owner = intval($fleet_taget_owner);
		$updatefleet_resource_metal = $fleet_resource_metal;
		$updatefleet_resource_crystal = $fleet_resource_crystal;
		$updatefleet_resource_deuterium = $fleet_resource_deuterium;
		$updatefleet_target_owner = intval($fleet_target_owner);
		$updatefleet_group = intval($fleet_group);
		$updatefleet_mess = intval($fleet_mess);
		$updatestart_time = intval($start_time);

		
        $statement = $this->_getUpdateStatement();
        $result = $statement->execute(array(
		':fleet_id'=>$updatefleet_id,
		':fleet_owner'=>$updatefleet_owner,
		':fleet_mission'=>$updatefleet_mission,
		':fleet_amount'=>$updatefleet_amount,
		':fleet_array'=>$updatefleet_array,
		':fleet_start_time'=>$updatefleet_start_time,
		':fleet_start_galaxy'=>$updatefleet_start_galaxy,
		':fleet_start_system'=>$updatefleet_start_system,
		':fleet_start_planet'=>$updatefleet_start_planet,
		':fleet_start_type'=>$updatefleet_start_type,
		':fleet_end_time'=>$updatefleet_end_time,
		':fleet_end_stay'=>$updatefleet_end_stay,
		':fleet_end_galaxy'=>$updatefleet_end_galaxy,
		':fleet_end_system'=>$updatefleet_end_system,
		':fleet_end_planet'=>$updatefleet_end_planet,
		':fleet_end_type'=>$updatefleet_end_type,
		':fleet_taget_owner'=>$updatefleet_taget_owner,
		':fleet_resource_metal'=>$updatefleet_resource_metal,
		':fleet_resource_crystal'=>$updatefleet_resource_crystal,
		':fleet_resource_deuterium'=>$updatefleet_resource_deuterium,
		':fleet_target_owner'=>$updatefleet_target_owner,
		':fleet_group'=>$updatefleet_group,
		':fleet_mess'=>$updatefleet_mess,
		':start_time'=>$updatestart_time
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
        return $this->getWriteAdapter()->exec('TRUNCATE TABLE game_fleets');
    }
}