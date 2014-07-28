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

class game_statpoints extends BaseModel
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
					->prepare('SELECT * FROM game_statpoints ORDER BY `id` DESC');
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
                ->prepare('SELECT * FROM game_statpoints WHERE `id_owner`=:id_owner or`id_ally`=:id_ally or`stat_type`=:stat_type or`stat_code`=:stat_code or`tech_rank`=:tech_rank or`tech_old_rank`=:tech_old_rank or`tech_points`=:tech_points or`tech_count`=:tech_count or`build_rank`=:build_rank or`build_old_rank`=:build_old_rank or`build_points`=:build_points or`build_count`=:build_count or`defs_rank`=:defs_rank or`defs_old_rank`=:defs_old_rank or`defs_points`=:defs_points or`defs_count`=:defs_count or`fleet_rank`=:fleet_rank or`fleet_old_rank`=:fleet_old_rank or`fleet_points`=:fleet_points or`fleet_count`=:fleet_count or`pertes_rank`=:pertes_rank or`pertes_old_rank`=:pertes_old_rank or`pertes_points`=:pertes_points or`pertes_count`=:pertes_count or`total_rank`=:total_rank or`total_old_rank`=:total_old_rank or`total_points`=:total_points or`total_count`=:total_count or`stat_date`=:stat_date  LIMIT 1');
        }

        return $this->_selectStatement;
    }

    public function select($id_owner,$id_ally,$stat_type,$stat_code,$tech_rank,$tech_old_rank,$tech_points,$tech_count,$build_rank,$build_old_rank,$build_points,$build_count,$defs_rank,$defs_old_rank,$defs_points,$defs_count,$fleet_rank,$fleet_old_rank,$fleet_points,$fleet_count,$pertes_rank,$pertes_old_rank,$pertes_points,$pertes_count,$total_rank,$total_old_rank,$total_points,$total_count,$stat_date)
    {
		// securité
		$selectid_owner = intval($id_owner);
		$selectid_ally = intval($id_ally);
		$selectstat_type = intval($stat_type);
		$selectstat_code = intval($stat_code);
		$selecttech_rank = intval($tech_rank);
		$selecttech_old_rank = intval($tech_old_rank);
		$selecttech_points = $tech_points;
		$selecttech_count = intval($tech_count);
		$selectbuild_rank = intval($build_rank);
		$selectbuild_old_rank = intval($build_old_rank);
		$selectbuild_points = $build_points;
		$selectbuild_count = intval($build_count);
		$selectdefs_rank = intval($defs_rank);
		$selectdefs_old_rank = intval($defs_old_rank);
		$selectdefs_points = $defs_points;
		$selectdefs_count = intval($defs_count);
		$selectfleet_rank = intval($fleet_rank);
		$selectfleet_old_rank = intval($fleet_old_rank);
		$selectfleet_points = $fleet_points;
		$selectfleet_count = intval($fleet_count);
		$selectpertes_rank = intval($pertes_rank);
		$selectpertes_old_rank = intval($pertes_old_rank);
		$selectpertes_points = $pertes_points;
		$selectpertes_count = intval($pertes_count);
		$selecttotal_rank = intval($total_rank);
		$selecttotal_old_rank = intval($total_old_rank);
		$selecttotal_points = $total_points;
		$selecttotal_count = intval($total_count);
		$selectstat_date = intval($stat_date);

		
		
		$statement = $this->_getSelectStatement();
        $statement->execute(array(
		':id_owner'=>$selectid_owner,
		':id_ally'=>$selectid_ally,
		':stat_type'=>$selectstat_type,
		':stat_code'=>$selectstat_code,
		':tech_rank'=>$selecttech_rank,
		':tech_old_rank'=>$selecttech_old_rank,
		':tech_points'=>$selecttech_points,
		':tech_count'=>$selecttech_count,
		':build_rank'=>$selectbuild_rank,
		':build_old_rank'=>$selectbuild_old_rank,
		':build_points'=>$selectbuild_points,
		':build_count'=>$selectbuild_count,
		':defs_rank'=>$selectdefs_rank,
		':defs_old_rank'=>$selectdefs_old_rank,
		':defs_points'=>$selectdefs_points,
		':defs_count'=>$selectdefs_count,
		':fleet_rank'=>$selectfleet_rank,
		':fleet_old_rank'=>$selectfleet_old_rank,
		':fleet_points'=>$selectfleet_points,
		':fleet_count'=>$selectfleet_count,
		':pertes_rank'=>$selectpertes_rank,
		':pertes_old_rank'=>$selectpertes_old_rank,
		':pertes_points'=>$selectpertes_points,
		':pertes_count'=>$selectpertes_count,
		':total_rank'=>$selecttotal_rank,
		':total_old_rank'=>$selecttotal_old_rank,
		':total_points'=>$selecttotal_points,
		':total_count'=>$selecttotal_count,
		':stat_date'=>$selectstat_date
        ));

        return $statement->fetchAll();
    }
	/****************BEGIN INSERT****************/	

	protected function _getInsertStatement()
    {
        if ($this->_insertStatement === null) {
            $this->_insertStatement = $this->getWriteAdapter()
                ->prepare('INSERT INTO game_statpoints(`id_owner`,`id_ally`,`stat_type`,`stat_code`,`tech_rank`,`tech_old_rank`,`tech_points`,`tech_count`,`build_rank`,`build_old_rank`,`build_points`,`build_count`,`defs_rank`,`defs_old_rank`,`defs_points`,`defs_count`,`fleet_rank`,`fleet_old_rank`,`fleet_points`,`fleet_count`,`pertes_rank`,`pertes_old_rank`,`pertes_points`,`pertes_count`,`total_rank`,`total_old_rank`,`total_points`,`total_count`,`stat_date`) VALUES(:id_owner,:id_ally,:stat_type,:stat_code,:tech_rank,:tech_old_rank,:tech_points,:tech_count,:build_rank,:build_old_rank,:build_points,:build_count,:defs_rank,:defs_old_rank,:defs_points,:defs_count,:fleet_rank,:fleet_old_rank,:fleet_points,:fleet_count,:pertes_rank,:pertes_old_rank,:pertes_points,:pertes_count,:total_rank,:total_old_rank,:total_points,:total_count,:stat_date)');
        }

        return $this->_insertStatement;
    }

    /**
     */
    public function insert($id_owner,$id_ally,$stat_type,$stat_code,$tech_rank,$tech_old_rank,$tech_points,$tech_count,$build_rank,$build_old_rank,$build_points,$build_count,$defs_rank,$defs_old_rank,$defs_points,$defs_count,$fleet_rank,$fleet_old_rank,$fleet_points,$fleet_count,$pertes_rank,$pertes_old_rank,$pertes_points,$pertes_count,$total_rank,$total_old_rank,$total_points,$total_count,$stat_date)
    {
		// 
		$insertid_owner = intval($id_owner);
		$insertid_ally = intval($id_ally);
		$insertstat_type = intval($stat_type);
		$insertstat_code = intval($stat_code);
		$inserttech_rank = intval($tech_rank);
		$inserttech_old_rank = intval($tech_old_rank);
		$inserttech_points = $tech_points;
		$inserttech_count = intval($tech_count);
		$insertbuild_rank = intval($build_rank);
		$insertbuild_old_rank = intval($build_old_rank);
		$insertbuild_points = $build_points;
		$insertbuild_count = intval($build_count);
		$insertdefs_rank = intval($defs_rank);
		$insertdefs_old_rank = intval($defs_old_rank);
		$insertdefs_points = $defs_points;
		$insertdefs_count = intval($defs_count);
		$insertfleet_rank = intval($fleet_rank);
		$insertfleet_old_rank = intval($fleet_old_rank);
		$insertfleet_points = $fleet_points;
		$insertfleet_count = intval($fleet_count);
		$insertpertes_rank = intval($pertes_rank);
		$insertpertes_old_rank = intval($pertes_old_rank);
		$insertpertes_points = $pertes_points;
		$insertpertes_count = intval($pertes_count);
		$inserttotal_rank = intval($total_rank);
		$inserttotal_old_rank = intval($total_old_rank);
		$inserttotal_points = $total_points;
		$inserttotal_count = intval($total_count);
		$insertstat_date = intval($stat_date);

	
        $statement = $this->_getInsertStatement();
        $result = $statement->execute(array(
		':id_owner'=>$insertid_owner,
		':id_ally'=>$insertid_ally,
		':stat_type'=>$insertstat_type,
		':stat_code'=>$insertstat_code,
		':tech_rank'=>$inserttech_rank,
		':tech_old_rank'=>$inserttech_old_rank,
		':tech_points'=>$inserttech_points,
		':tech_count'=>$inserttech_count,
		':build_rank'=>$insertbuild_rank,
		':build_old_rank'=>$insertbuild_old_rank,
		':build_points'=>$insertbuild_points,
		':build_count'=>$insertbuild_count,
		':defs_rank'=>$insertdefs_rank,
		':defs_old_rank'=>$insertdefs_old_rank,
		':defs_points'=>$insertdefs_points,
		':defs_count'=>$insertdefs_count,
		':fleet_rank'=>$insertfleet_rank,
		':fleet_old_rank'=>$insertfleet_old_rank,
		':fleet_points'=>$insertfleet_points,
		':fleet_count'=>$insertfleet_count,
		':pertes_rank'=>$insertpertes_rank,
		':pertes_old_rank'=>$insertpertes_old_rank,
		':pertes_points'=>$insertpertes_points,
		':pertes_count'=>$insertpertes_count,
		':total_rank'=>$inserttotal_rank,
		':total_old_rank'=>$inserttotal_old_rank,
		':total_points'=>$inserttotal_points,
		':total_count'=>$inserttotal_count,
		':stat_date'=>$insertstat_date
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
                ->prepare('DELETE FROM game_statpoints WHERE `id`=:id;');
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
                ->prepare('UPDATE game_statpoints SET `id_owner`=:id_owner,`id_ally`=:id_ally,`stat_type`=:stat_type,`stat_code`=:stat_code,`tech_rank`=:tech_rank,`tech_old_rank`=:tech_old_rank,`tech_points`=:tech_points,`tech_count`=:tech_count,`build_rank`=:build_rank,`build_old_rank`=:build_old_rank,`build_points`=:build_points,`build_count`=:build_count,`defs_rank`=:defs_rank,`defs_old_rank`=:defs_old_rank,`defs_points`=:defs_points,`defs_count`=:defs_count,`fleet_rank`=:fleet_rank,`fleet_old_rank`=:fleet_old_rank,`fleet_points`=:fleet_points,`fleet_count`=:fleet_count,`pertes_rank`=:pertes_rank,`pertes_old_rank`=:pertes_old_rank,`pertes_points`=:pertes_points,`pertes_count`=:pertes_count,`total_rank`=:total_rank,`total_old_rank`=:total_old_rank,`total_points`=:total_points,`total_count`=:total_count,`stat_date`=:stat_date WHERE ');
        }

        return $this->_updateStatement;
    }

    public function update($id_owner,$id_ally,$stat_type,$stat_code,$tech_rank,$tech_old_rank,$tech_points,$tech_count,$build_rank,$build_old_rank,$build_points,$build_count,$defs_rank,$defs_old_rank,$defs_points,$defs_count,$fleet_rank,$fleet_old_rank,$fleet_points,$fleet_count,$pertes_rank,$pertes_old_rank,$pertes_points,$pertes_count,$total_rank,$total_old_rank,$total_points,$total_count,$stat_date)
    {
		//securité
		$updateid_owner = intval($id_owner);
		$updateid_ally = intval($id_ally);
		$updatestat_type = intval($stat_type);
		$updatestat_code = intval($stat_code);
		$updatetech_rank = intval($tech_rank);
		$updatetech_old_rank = intval($tech_old_rank);
		$updatetech_points = $tech_points;
		$updatetech_count = intval($tech_count);
		$updatebuild_rank = intval($build_rank);
		$updatebuild_old_rank = intval($build_old_rank);
		$updatebuild_points = $build_points;
		$updatebuild_count = intval($build_count);
		$updatedefs_rank = intval($defs_rank);
		$updatedefs_old_rank = intval($defs_old_rank);
		$updatedefs_points = $defs_points;
		$updatedefs_count = intval($defs_count);
		$updatefleet_rank = intval($fleet_rank);
		$updatefleet_old_rank = intval($fleet_old_rank);
		$updatefleet_points = $fleet_points;
		$updatefleet_count = intval($fleet_count);
		$updatepertes_rank = intval($pertes_rank);
		$updatepertes_old_rank = intval($pertes_old_rank);
		$updatepertes_points = $pertes_points;
		$updatepertes_count = intval($pertes_count);
		$updatetotal_rank = intval($total_rank);
		$updatetotal_old_rank = intval($total_old_rank);
		$updatetotal_points = $total_points;
		$updatetotal_count = intval($total_count);
		$updatestat_date = intval($stat_date);

		
        $statement = $this->_getUpdateStatement();
        $result = $statement->execute(array(
		':id_owner'=>$updateid_owner,
		':id_ally'=>$updateid_ally,
		':stat_type'=>$updatestat_type,
		':stat_code'=>$updatestat_code,
		':tech_rank'=>$updatetech_rank,
		':tech_old_rank'=>$updatetech_old_rank,
		':tech_points'=>$updatetech_points,
		':tech_count'=>$updatetech_count,
		':build_rank'=>$updatebuild_rank,
		':build_old_rank'=>$updatebuild_old_rank,
		':build_points'=>$updatebuild_points,
		':build_count'=>$updatebuild_count,
		':defs_rank'=>$updatedefs_rank,
		':defs_old_rank'=>$updatedefs_old_rank,
		':defs_points'=>$updatedefs_points,
		':defs_count'=>$updatedefs_count,
		':fleet_rank'=>$updatefleet_rank,
		':fleet_old_rank'=>$updatefleet_old_rank,
		':fleet_points'=>$updatefleet_points,
		':fleet_count'=>$updatefleet_count,
		':pertes_rank'=>$updatepertes_rank,
		':pertes_old_rank'=>$updatepertes_old_rank,
		':pertes_points'=>$updatepertes_points,
		':pertes_count'=>$updatepertes_count,
		':total_rank'=>$updatetotal_rank,
		':total_old_rank'=>$updatetotal_old_rank,
		':total_points'=>$updatetotal_points,
		':total_count'=>$updatetotal_count,
		':stat_date'=>$updatestat_date
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
        return $this->getWriteAdapter()->exec('TRUNCATE TABLE game_statpoints');
    }
}