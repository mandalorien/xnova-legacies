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

class game_errors extends BaseModel
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
					->prepare('SELECT * FROM game_errors ORDER BY `id` DESC');
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
                ->prepare('SELECT * FROM game_errors WHERE `error_id`=:error_id or`error_sender`=:error_sender or`error_time`=:error_time or`error_type`=:error_type or`error_text`=:error_text  LIMIT 1');
        }

        return $this->_selectStatement;
    }

    public function select($error_id,$error_sender,$error_time,$error_type,$error_text)
    {
		// securité
		$selecterror_id = $error_id;
		$selecterror_sender = $error_sender;
		$selecterror_time = intval($error_time);
		$selecterror_type = $error_type;
		$selecterror_text = $error_text;

		
		
		$statement = $this->_getSelectStatement();
        $statement->execute(array(
		':error_id'=>$selecterror_id,
		':error_sender'=>$selecterror_sender,
		':error_time'=>$selecterror_time,
		':error_type'=>$selecterror_type,
		':error_text'=>$selecterror_text
        ));

        return $statement->fetchAll();
    }
	/****************BEGIN INSERT****************/	

	protected function _getInsertStatement()
    {
        if ($this->_insertStatement === null) {
            $this->_insertStatement = $this->getWriteAdapter()
                ->prepare('INSERT INTO game_errors(`error_id`,`error_sender`,`error_time`,`error_type`,`error_text`) VALUES(:error_id,:error_sender,:error_time,:error_type,:error_text)');
        }

        return $this->_insertStatement;
    }

    /**
     */
    public function insert($error_id,$error_sender,$error_time,$error_type,$error_text)
    {
		// 
		$inserterror_id = $error_id;
		$inserterror_sender = $error_sender;
		$inserterror_time = intval($error_time);
		$inserterror_type = $error_type;
		$inserterror_text = $error_text;

	
        $statement = $this->_getInsertStatement();
        $result = $statement->execute(array(
		':error_id'=>$inserterror_id,
		':error_sender'=>$inserterror_sender,
		':error_time'=>$inserterror_time,
		':error_type'=>$inserterror_type,
		':error_text'=>$inserterror_text
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
                ->prepare('DELETE FROM game_errors WHERE `id`=:id;');
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
                ->prepare('UPDATE game_errors SET `error_id`=:error_id,`error_sender`=:error_sender,`error_time`=:error_time,`error_type`=:error_type,`error_text`=:error_text WHERE ');
        }

        return $this->_updateStatement;
    }

    public function update($error_id,$error_sender,$error_time,$error_type,$error_text)
    {
		//securité
		$updateerror_id = $error_id;
		$updateerror_sender = $error_sender;
		$updateerror_time = intval($error_time);
		$updateerror_type = $error_type;
		$updateerror_text = $error_text;

		
        $statement = $this->_getUpdateStatement();
        $result = $statement->execute(array(
		':error_id'=>$updateerror_id,
		':error_sender'=>$updateerror_sender,
		':error_time'=>$updateerror_time,
		':error_type'=>$updateerror_type,
		':error_text'=>$updateerror_text
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
        return $this->getWriteAdapter()->exec('TRUNCATE TABLE game_errors');
    }
}