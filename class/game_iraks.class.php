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

class game_iraks extends BaseModel
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
					->prepare('SELECT * FROM game_iraks ORDER BY `id` DESC');
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
                ->prepare('SELECT * FROM game_iraks WHERE `id`=:id or`zeit`=:zeit or`galaxy`=:galaxy or`system`=:system or`planet`=:planet or`galaxy_angreifer`=:galaxy_angreifer or`system_angreifer`=:system_angreifer or`planet_angreifer`=:planet_angreifer or`owner`=:owner or`zielid`=:zielid or`anzahl`=:anzahl or`primaer`=:primaer  LIMIT 1');
        }

        return $this->_selectStatement;
    }

    public function select($id,$zeit,$galaxy,$system,$planet,$galaxy_angreifer,$system_angreifer,$planet_angreifer,$owner,$zielid,$anzahl,$primaer)
    {
		// securité
		$selectid = $id;
		$selectzeit = intval($zeit);
		$selectgalaxy = intval($galaxy);
		$selectsystem = intval($system);
		$selectplanet = intval($planet);
		$selectgalaxy_angreifer = intval($galaxy_angreifer);
		$selectsystem_angreifer = intval($system_angreifer);
		$selectplanet_angreifer = intval($planet_angreifer);
		$selectowner = intval($owner);
		$selectzielid = intval($zielid);
		$selectanzahl = intval($anzahl);
		$selectprimaer = intval($primaer);

		
		
		$statement = $this->_getSelectStatement();
        $statement->execute(array(
		':id'=>$selectid,
		':zeit'=>$selectzeit,
		':galaxy'=>$selectgalaxy,
		':system'=>$selectsystem,
		':planet'=>$selectplanet,
		':galaxy_angreifer'=>$selectgalaxy_angreifer,
		':system_angreifer'=>$selectsystem_angreifer,
		':planet_angreifer'=>$selectplanet_angreifer,
		':owner'=>$selectowner,
		':zielid'=>$selectzielid,
		':anzahl'=>$selectanzahl,
		':primaer'=>$selectprimaer
        ));

        return $statement->fetchAll();
    }
	/****************BEGIN INSERT****************/	

	protected function _getInsertStatement()
    {
        if ($this->_insertStatement === null) {
            $this->_insertStatement = $this->getWriteAdapter()
                ->prepare('INSERT INTO game_iraks(`zeit`,`galaxy`,`system`,`planet`,`galaxy_angreifer`,`system_angreifer`,`planet_angreifer`,`owner`,`zielid`,`anzahl`,`primaer`) VALUES(:zeit,:galaxy,:system,:planet,:galaxy_angreifer,:system_angreifer,:planet_angreifer,:owner,:zielid,:anzahl,:primaer)');
        }

        return $this->_insertStatement;
    }

    /**
     */
    public function insert($zeit,$galaxy,$system,$planet,$galaxy_angreifer,$system_angreifer,$planet_angreifer,$owner,$zielid,$anzahl,$primaer)
    {
		// 
		$insertzeit = intval($zeit);
		$insertgalaxy = intval($galaxy);
		$insertsystem = intval($system);
		$insertplanet = intval($planet);
		$insertgalaxy_angreifer = intval($galaxy_angreifer);
		$insertsystem_angreifer = intval($system_angreifer);
		$insertplanet_angreifer = intval($planet_angreifer);
		$insertowner = intval($owner);
		$insertzielid = intval($zielid);
		$insertanzahl = intval($anzahl);
		$insertprimaer = intval($primaer);

	
        $statement = $this->_getInsertStatement();
        $result = $statement->execute(array(
		':zeit'=>$insertzeit,
		':galaxy'=>$insertgalaxy,
		':system'=>$insertsystem,
		':planet'=>$insertplanet,
		':galaxy_angreifer'=>$insertgalaxy_angreifer,
		':system_angreifer'=>$insertsystem_angreifer,
		':planet_angreifer'=>$insertplanet_angreifer,
		':owner'=>$insertowner,
		':zielid'=>$insertzielid,
		':anzahl'=>$insertanzahl,
		':primaer'=>$insertprimaer
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
                ->prepare('DELETE FROM game_iraks WHERE `id`=:id;');
        }
        return $this->_deleteoneStatement;
    }


    public function delete($luna)
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
                ->prepare('UPDATE game_iraks SET `zeit`=:zeit,`galaxy`=:galaxy,`system`=:system,`planet`=:planet,`galaxy_angreifer`=:galaxy_angreifer,`system_angreifer`=:system_angreifer,`planet_angreifer`=:planet_angreifer,`owner`=:owner,`zielid`=:zielid,`anzahl`=:anzahl,`primaer`=:primaer WHERE `id`=:id');
        }

        return $this->_updateStatement;
    }

    public function update($id,$zeit,$galaxy,$system,$planet,$galaxy_angreifer,$system_angreifer,$planet_angreifer,$owner,$zielid,$anzahl,$primaer)
    {
		//securité
		$updateid = $id;
		$updatezeit = intval($zeit);
		$updategalaxy = intval($galaxy);
		$updatesystem = intval($system);
		$updateplanet = intval($planet);
		$updategalaxy_angreifer = intval($galaxy_angreifer);
		$updatesystem_angreifer = intval($system_angreifer);
		$updateplanet_angreifer = intval($planet_angreifer);
		$updateowner = intval($owner);
		$updatezielid = intval($zielid);
		$updateanzahl = intval($anzahl);
		$updateprimaer = intval($primaer);

		
        $statement = $this->_getUpdateStatement();
        $result = $statement->execute(array(
		':id'=>$updateid,
		':zeit'=>$updatezeit,
		':galaxy'=>$updategalaxy,
		':system'=>$updatesystem,
		':planet'=>$updateplanet,
		':galaxy_angreifer'=>$updategalaxy_angreifer,
		':system_angreifer'=>$updatesystem_angreifer,
		':planet_angreifer'=>$updateplanet_angreifer,
		':owner'=>$updateowner,
		':zielid'=>$updatezielid,
		':anzahl'=>$updateanzahl,
		':primaer'=>$updateprimaer
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
        return $this->getWriteAdapter()->exec('TRUNCATE TABLE game_iraks');
    }
}