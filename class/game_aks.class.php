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

class game_aks extends BaseModel
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
					->prepare('SELECT * FROM game_aks ORDER BY `id` DESC');
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
                ->prepare('SELECT * FROM game_aks WHERE `id`=:id or`name`=:name or`teilnehmer`=:teilnehmer or`flotten`=:flotten or`ankunft`=:ankunft or`galaxy`=:galaxy or`system`=:system or`planet`=:planet or`planet_type`=:planet_type or`eingeladen`=:eingeladen  LIMIT 1');
        }

        return $this->_selectStatement;
    }

    public function select($id,$name,$teilnehmer,$flotten,$ankunft,$galaxy,$system,$planet,$planet_type,$eingeladen)
    {
		// securité
		$selectid = $id;
		$selectname = $name;
		$selectteilnehmer = $teilnehmer;
		$selectflotten = $flotten;
		$selectankunft = intval($ankunft);
		$selectgalaxy = intval($galaxy);
		$selectsystem = intval($system);
		$selectplanet = intval($planet);
		$selectplanet_type = intval($planet_type);
		$selecteingeladen = $eingeladen;

		
		
		$statement = $this->_getSelectStatement();
        $statement->execute(array(
		':id'=>$selectid,
		':name'=>$selectname,
		':teilnehmer'=>$selectteilnehmer,
		':flotten'=>$selectflotten,
		':ankunft'=>$selectankunft,
		':galaxy'=>$selectgalaxy,
		':system'=>$selectsystem,
		':planet'=>$selectplanet,
		':planet_type'=>$selectplanet_type,
		':eingeladen'=>$selecteingeladen
        ));

        return $statement->fetchAll();
    }
	/****************BEGIN INSERT****************/	

	protected function _getInsertStatement()
    {
        if ($this->_insertStatement === null) {
            $this->_insertStatement = $this->getWriteAdapter()
                ->prepare('INSERT INTO game_aks(`name`,`teilnehmer`,`flotten`,`ankunft`,`galaxy`,`system`,`planet`,`planet_type`,`eingeladen`) VALUES(:name,:teilnehmer,:flotten,:ankunft,:galaxy,:system,:planet,:planet_type,:eingeladen)');
        }

        return $this->_insertStatement;
    }

    /**
     */
    public function insert($name,$teilnehmer,$flotten,$ankunft,$galaxy,$system,$planet,$planet_type,$eingeladen)
    {
		// 
		$insertname = $name;
		$insertteilnehmer = $teilnehmer;
		$insertflotten = $flotten;
		$insertankunft = intval($ankunft);
		$insertgalaxy = intval($galaxy);
		$insertsystem = intval($system);
		$insertplanet = intval($planet);
		$insertplanet_type = intval($planet_type);
		$inserteingeladen = $eingeladen;

	
        $statement = $this->_getInsertStatement();
        $result = $statement->execute(array(
		':name'=>$insertname,
		':teilnehmer'=>$insertteilnehmer,
		':flotten'=>$insertflotten,
		':ankunft'=>$insertankunft,
		':galaxy'=>$insertgalaxy,
		':system'=>$insertsystem,
		':planet'=>$insertplanet,
		':planet_type'=>$insertplanet_type,
		':eingeladen'=>$inserteingeladen
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
                ->prepare('DELETE FROM game_aks WHERE `id`=:id;');
        }
        return $this->_deleteoneStatement;
    }


    public function delete()
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
                ->prepare('UPDATE game_aks SET `name`=:name,`teilnehmer`=:teilnehmer,`flotten`=:flotten,`ankunft`=:ankunft,`galaxy`=:galaxy,`system`=:system,`planet`=:planet,`planet_type`=:planet_type,`eingeladen`=:eingeladen WHERE `id`=:id');
        }

        return $this->_updateStatement;
    }

    public function update($id,$name,$teilnehmer,$flotten,$ankunft,$galaxy,$system,$planet,$planet_type,$eingeladen)
    {
		//securité
		$updateid = $id;
		$updatename = $name;
		$updateteilnehmer = $teilnehmer;
		$updateflotten = $flotten;
		$updateankunft = intval($ankunft);
		$updategalaxy = intval($galaxy);
		$updatesystem = intval($system);
		$updateplanet = intval($planet);
		$updateplanet_type = intval($planet_type);
		$updateeingeladen = $eingeladen;

		
        $statement = $this->_getUpdateStatement();
        $result = $statement->execute(array(
		':id'=>$updateid,
		':name'=>$updatename,
		':teilnehmer'=>$updateteilnehmer,
		':flotten'=>$updateflotten,
		':ankunft'=>$updateankunft,
		':galaxy'=>$updategalaxy,
		':system'=>$updatesystem,
		':planet'=>$updateplanet,
		':planet_type'=>$updateplanet_type,
		':eingeladen'=>$updateeingeladen
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
        return $this->getWriteAdapter()->exec('TRUNCATE TABLE game_aks');
    }
}