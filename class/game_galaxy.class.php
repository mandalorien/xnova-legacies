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

class game_galaxy extends BaseModel
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
					->prepare('SELECT * FROM game_galaxy ORDER BY `id` DESC');
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
                ->prepare('SELECT * FROM game_galaxy WHERE `galaxy`=:galaxy or`system`=:system or`planet`=:planet or`id_planet`=:id_planet or`metal`=:metal or`crystal`=:crystal or`id_luna`=:id_luna or`luna`=:luna  LIMIT 1');
        }

        return $this->_selectStatement;
    }

    public function select($galaxy,$system,$planet,$id_planet,$metal,$crystal,$id_luna,$luna)
    {
		// securité
		$selectgalaxy = intval($galaxy);
		$selectsystem = intval($system);
		$selectplanet = intval($planet);
		$selectid_planet = intval($id_planet);
		$selectmetal = $metal;
		$selectcrystal = $crystal;
		$selectid_luna = intval($id_luna);
		$selectluna = intval($luna);

		
		
		$statement = $this->_getSelectStatement();
        $statement->execute(array(
		':galaxy'=>$selectgalaxy,
		':system'=>$selectsystem,
		':planet'=>$selectplanet,
		':id_planet'=>$selectid_planet,
		':metal'=>$selectmetal,
		':crystal'=>$selectcrystal,
		':id_luna'=>$selectid_luna,
		':luna'=>$selectluna
        ));

        return $statement->fetchAll();
    }
	/****************BEGIN INSERT****************/	

	protected function _getInsertStatement()
    {
        if ($this->_insertStatement === null) {
            $this->_insertStatement = $this->getWriteAdapter()
                ->prepare('INSERT INTO game_galaxy(`galaxy`,`system`,`planet`,`id_planet`,`metal`,`crystal`,`id_luna`,`luna`) VALUES(:galaxy,:system,:planet,:id_planet,:metal,:crystal,:id_luna,:luna)');
        }

        return $this->_insertStatement;
    }

    /**
     */
    public function insert($galaxy,$system,$planet,$id_planet,$metal,$crystal,$id_luna,$luna)
    {
		// 
		$insertgalaxy = intval($galaxy);
		$insertsystem = intval($system);
		$insertplanet = intval($planet);
		$insertid_planet = intval($id_planet);
		$insertmetal = $metal;
		$insertcrystal = $crystal;
		$insertid_luna = intval($id_luna);
		$insertluna = intval($luna);

	
        $statement = $this->_getInsertStatement();
        $result = $statement->execute(array(
		':galaxy'=>$insertgalaxy,
		':system'=>$insertsystem,
		':planet'=>$insertplanet,
		':id_planet'=>$insertid_planet,
		':metal'=>$insertmetal,
		':crystal'=>$insertcrystal,
		':id_luna'=>$insertid_luna,
		':luna'=>$insertluna
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
                ->prepare('DELETE FROM game_galaxy WHERE `id`=:id;');
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
                ->prepare('UPDATE game_galaxy SET `galaxy`=:galaxy,`system`=:system,`planet`=:planet,`id_planet`=:id_planet,`metal`=:metal,`crystal`=:crystal,`id_luna`=:id_luna,`luna`=:luna WHERE ');
        }

        return $this->_updateStatement;
    }

    public function update($galaxy,$system,$planet,$id_planet,$metal,$crystal,$id_luna,$luna)
    {
		//securité
		$updategalaxy = intval($galaxy);
		$updatesystem = intval($system);
		$updateplanet = intval($planet);
		$updateid_planet = intval($id_planet);
		$updatemetal = $metal;
		$updatecrystal = $crystal;
		$updateid_luna = intval($id_luna);
		$updateluna = intval($luna);

		
        $statement = $this->_getUpdateStatement();
        $result = $statement->execute(array(
		':galaxy'=>$updategalaxy,
		':system'=>$updatesystem,
		':planet'=>$updateplanet,
		':id_planet'=>$updateid_planet,
		':metal'=>$updatemetal,
		':crystal'=>$updatecrystal,
		':id_luna'=>$updateid_luna,
		':luna'=>$updateluna
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
        return $this->getWriteAdapter()->exec('TRUNCATE TABLE game_galaxy');
    }
}