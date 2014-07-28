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

class game_lunas extends BaseModel
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
					->prepare('SELECT * FROM game_lunas ORDER BY `id` DESC');
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
                ->prepare('SELECT * FROM game_lunas WHERE `id`=:id or`id_luna`=:id_luna or`name`=:name or`image`=:image or`destruyed`=:destruyed or`id_owner`=:id_owner or`galaxy`=:galaxy or`system`=:system or`lunapos`=:lunapos or`temp_min`=:temp_min or`temp_max`=:temp_max or`diameter`=:diameter  LIMIT 1');
        }

        return $this->_selectStatement;
    }

    public function select($id,$id_luna,$name,$image,$destruyed,$id_owner,$galaxy,$system,$lunapos,$temp_min,$temp_max,$diameter)
    {
		// securité
		$selectid = $id;
		$selectid_luna = intval($id_luna);
		$selectname = $name;
		$selectimage = $image;
		$selectdestruyed = intval($destruyed);
		$selectid_owner = intval($id_owner);
		$selectgalaxy = intval($galaxy);
		$selectsystem = intval($system);
		$selectlunapos = intval($lunapos);
		$selecttemp_min = intval($temp_min);
		$selecttemp_max = intval($temp_max);
		$selectdiameter = intval($diameter);

		
		
		$statement = $this->_getSelectStatement();
        $statement->execute(array(
		':id'=>$selectid,
		':id_luna'=>$selectid_luna,
		':name'=>$selectname,
		':image'=>$selectimage,
		':destruyed'=>$selectdestruyed,
		':id_owner'=>$selectid_owner,
		':galaxy'=>$selectgalaxy,
		':system'=>$selectsystem,
		':lunapos'=>$selectlunapos,
		':temp_min'=>$selecttemp_min,
		':temp_max'=>$selecttemp_max,
		':diameter'=>$selectdiameter
        ));

        return $statement->fetchAll();
    }
	/****************BEGIN INSERT****************/	

	protected function _getInsertStatement()
    {
        if ($this->_insertStatement === null) {
            $this->_insertStatement = $this->getWriteAdapter()
                ->prepare('INSERT INTO game_lunas(`id_luna`,`name`,`image`,`destruyed`,`id_owner`,`galaxy`,`system`,`lunapos`,`temp_min`,`temp_max`,`diameter`) VALUES(:id_luna,:name,:image,:destruyed,:id_owner,:galaxy,:system,:lunapos,:temp_min,:temp_max,:diameter)');
        }

        return $this->_insertStatement;
    }

    /**
     */
    public function insert($id_luna,$name,$image,$destruyed,$id_owner,$galaxy,$system,$lunapos,$temp_min,$temp_max,$diameter)
    {
		// 
		$insertid_luna = intval($id_luna);
		$insertname = $name;
		$insertimage = $image;
		$insertdestruyed = intval($destruyed);
		$insertid_owner = intval($id_owner);
		$insertgalaxy = intval($galaxy);
		$insertsystem = intval($system);
		$insertlunapos = intval($lunapos);
		$inserttemp_min = intval($temp_min);
		$inserttemp_max = intval($temp_max);
		$insertdiameter = intval($diameter);

	
        $statement = $this->_getInsertStatement();
        $result = $statement->execute(array(
		':id_luna'=>$insertid_luna,
		':name'=>$insertname,
		':image'=>$insertimage,
		':destruyed'=>$insertdestruyed,
		':id_owner'=>$insertid_owner,
		':galaxy'=>$insertgalaxy,
		':system'=>$insertsystem,
		':lunapos'=>$insertlunapos,
		':temp_min'=>$inserttemp_min,
		':temp_max'=>$inserttemp_max,
		':diameter'=>$insertdiameter
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
                ->prepare('DELETE FROM game_lunas WHERE `id`=:id;');
        }
        return $this->_deleteoneStatement;
    }


    public function delete($primaer)
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
                ->prepare('UPDATE game_lunas SET `id_luna`=:id_luna,`name`=:name,`image`=:image,`destruyed`=:destruyed,`id_owner`=:id_owner,`galaxy`=:galaxy,`system`=:system,`lunapos`=:lunapos,`temp_min`=:temp_min,`temp_max`=:temp_max,`diameter`=:diameter WHERE `id`=:id');
        }

        return $this->_updateStatement;
    }

    public function update($id,$id_luna,$name,$image,$destruyed,$id_owner,$galaxy,$system,$lunapos,$temp_min,$temp_max,$diameter)
    {
		//securité
		$updateid = $id;
		$updateid_luna = intval($id_luna);
		$updatename = $name;
		$updateimage = $image;
		$updatedestruyed = intval($destruyed);
		$updateid_owner = intval($id_owner);
		$updategalaxy = intval($galaxy);
		$updatesystem = intval($system);
		$updatelunapos = intval($lunapos);
		$updatetemp_min = intval($temp_min);
		$updatetemp_max = intval($temp_max);
		$updatediameter = intval($diameter);

		
        $statement = $this->_getUpdateStatement();
        $result = $statement->execute(array(
		':id'=>$updateid,
		':id_luna'=>$updateid_luna,
		':name'=>$updatename,
		':image'=>$updateimage,
		':destruyed'=>$updatedestruyed,
		':id_owner'=>$updateid_owner,
		':galaxy'=>$updategalaxy,
		':system'=>$updatesystem,
		':lunapos'=>$updatelunapos,
		':temp_min'=>$updatetemp_min,
		':temp_max'=>$updatetemp_max,
		':diameter'=>$updatediameter
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
        return $this->getWriteAdapter()->exec('TRUNCATE TABLE game_lunas');
    }
}