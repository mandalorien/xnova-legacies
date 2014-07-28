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

class game_declared extends BaseModel
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
					->prepare('SELECT * FROM game_declared ORDER BY `id` DESC');
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
                ->prepare('SELECT * FROM game_declared WHERE `declarator`=:declarator or`declared_1`=:declared_1 or`declared_2`=:declared_2 or`declared_3`=:declared_3 or`reason`=:reason or`declarator_name`=:declarator_name  LIMIT 1');
        }

        return $this->_selectStatement;
    }

    public function select($declarator,$declared_1,$declared_2,$declared_3,$reason,$declarator_name)
    {
		// securité
		$selectdeclarator = $declarator;
		$selectdeclared_1 = $declared_1;
		$selectdeclared_2 = $declared_2;
		$selectdeclared_3 = $declared_3;
		$selectreason = $reason;
		$selectdeclarator_name = $declarator_name;

		
		
		$statement = $this->_getSelectStatement();
        $statement->execute(array(
		':declarator'=>$selectdeclarator,
		':declared_1'=>$selectdeclared_1,
		':declared_2'=>$selectdeclared_2,
		':declared_3'=>$selectdeclared_3,
		':reason'=>$selectreason,
		':declarator_name'=>$selectdeclarator_name
        ));

        return $statement->fetchAll();
    }
	/****************BEGIN INSERT****************/	

	protected function _getInsertStatement()
    {
        if ($this->_insertStatement === null) {
            $this->_insertStatement = $this->getWriteAdapter()
                ->prepare('INSERT INTO game_declared(`declarator`,`declared_1`,`declared_2`,`declared_3`,`reason`,`declarator_name`) VALUES(:declarator,:declared_1,:declared_2,:declared_3,:reason,:declarator_name)');
        }

        return $this->_insertStatement;
    }

    /**
     */
    public function insert($declarator,$declared_1,$declared_2,$declared_3,$reason,$declarator_name)
    {
		// 
		$insertdeclarator = $declarator;
		$insertdeclared_1 = $declared_1;
		$insertdeclared_2 = $declared_2;
		$insertdeclared_3 = $declared_3;
		$insertreason = $reason;
		$insertdeclarator_name = $declarator_name;

	
        $statement = $this->_getInsertStatement();
        $result = $statement->execute(array(
		':declarator'=>$insertdeclarator,
		':declared_1'=>$insertdeclared_1,
		':declared_2'=>$insertdeclared_2,
		':declared_3'=>$insertdeclared_3,
		':reason'=>$insertreason,
		':declarator_name'=>$insertdeclarator_name
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
                ->prepare('DELETE FROM game_declared WHERE `id`=:id;');
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
                ->prepare('UPDATE game_declared SET `declarator`=:declarator,`declared_1`=:declared_1,`declared_2`=:declared_2,`declared_3`=:declared_3,`reason`=:reason,`declarator_name`=:declarator_name WHERE ');
        }

        return $this->_updateStatement;
    }

    public function update($declarator,$declared_1,$declared_2,$declared_3,$reason,$declarator_name)
    {
		//securité
		$updatedeclarator = $declarator;
		$updatedeclared_1 = $declared_1;
		$updatedeclared_2 = $declared_2;
		$updatedeclared_3 = $declared_3;
		$updatereason = $reason;
		$updatedeclarator_name = $declarator_name;

		
        $statement = $this->_getUpdateStatement();
        $result = $statement->execute(array(
		':declarator'=>$updatedeclarator,
		':declared_1'=>$updatedeclared_1,
		':declared_2'=>$updatedeclared_2,
		':declared_3'=>$updatedeclared_3,
		':reason'=>$updatereason,
		':declarator_name'=>$updatedeclarator_name
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
        return $this->getWriteAdapter()->exec('TRUNCATE TABLE game_declared');
    }
}