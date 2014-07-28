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

class game_chat extends BaseModel
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
					->prepare('SELECT * FROM game_chat ORDER BY `id` DESC');
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
                ->prepare('SELECT * FROM game_chat WHERE `messageid`=:messageid or`user`=:user or`message`=:message or`timestamp`=:timestamp  LIMIT 1');
        }

        return $this->_selectStatement;
    }

    public function select($messageid,$user,$message,$timestamp)
    {
		// securité
		$selectmessageid = intval($messageid);
		$selectuser = $user;
		$selectmessage = $message;
		$selecttimestamp = intval($timestamp);

		
		
		$statement = $this->_getSelectStatement();
        $statement->execute(array(
		':messageid'=>$selectmessageid,
		':user'=>$selectuser,
		':message'=>$selectmessage,
		':timestamp'=>$selecttimestamp
        ));

        return $statement->fetchAll();
    }
	/****************BEGIN INSERT****************/	

	protected function _getInsertStatement()
    {
        if ($this->_insertStatement === null) {
            $this->_insertStatement = $this->getWriteAdapter()
                ->prepare('INSERT INTO game_chat(`messageid`,`user`,`message`,`timestamp`) VALUES(:messageid,:user,:message,:timestamp)');
        }

        return $this->_insertStatement;
    }

    /**
     */
    public function insert($messageid,$user,$message,$timestamp)
    {
		// 
		$insertmessageid = intval($messageid);
		$insertuser = $user;
		$insertmessage = $message;
		$inserttimestamp = intval($timestamp);

	
        $statement = $this->_getInsertStatement();
        $result = $statement->execute(array(
		':messageid'=>$insertmessageid,
		':user'=>$insertuser,
		':message'=>$insertmessage,
		':timestamp'=>$inserttimestamp
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
                ->prepare('DELETE FROM game_chat WHERE `id`=:id;');
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
                ->prepare('UPDATE game_chat SET `messageid`=:messageid,`user`=:user,`message`=:message,`timestamp`=:timestamp WHERE ');
        }

        return $this->_updateStatement;
    }

    public function update($messageid,$user,$message,$timestamp)
    {
		//securité
		$updatemessageid = intval($messageid);
		$updateuser = $user;
		$updatemessage = $message;
		$updatetimestamp = intval($timestamp);

		
        $statement = $this->_getUpdateStatement();
        $result = $statement->execute(array(
		':messageid'=>$updatemessageid,
		':user'=>$updateuser,
		':message'=>$updatemessage,
		':timestamp'=>$updatetimestamp
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
        return $this->getWriteAdapter()->exec('TRUNCATE TABLE game_chat');
    }
}