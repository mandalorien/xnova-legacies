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

class game_messages extends BaseModel
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
					->prepare('SELECT * FROM game_messages ORDER BY `id` DESC');
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
                ->prepare('SELECT * FROM game_messages WHERE `message_id`=:message_id or`message_owner`=:message_owner or`message_sender`=:message_sender or`message_time`=:message_time or`message_type`=:message_type or`message_from`=:message_from or`message_subject`=:message_subject or`message_text`=:message_text  LIMIT 1');
        }

        return $this->_selectStatement;
    }

    public function select($message_id,$message_owner,$message_sender,$message_time,$message_type,$message_from,$message_subject,$message_text)
    {
		// securité
		$selectmessage_id = $message_id;
		$selectmessage_owner = intval($message_owner);
		$selectmessage_sender = intval($message_sender);
		$selectmessage_time = intval($message_time);
		$selectmessage_type = intval($message_type);
		$selectmessage_from = $message_from;
		$selectmessage_subject = $message_subject;
		$selectmessage_text = $message_text;

		
		
		$statement = $this->_getSelectStatement();
        $statement->execute(array(
		':message_id'=>$selectmessage_id,
		':message_owner'=>$selectmessage_owner,
		':message_sender'=>$selectmessage_sender,
		':message_time'=>$selectmessage_time,
		':message_type'=>$selectmessage_type,
		':message_from'=>$selectmessage_from,
		':message_subject'=>$selectmessage_subject,
		':message_text'=>$selectmessage_text
        ));

        return $statement->fetchAll();
    }
	/****************BEGIN INSERT****************/	

	protected function _getInsertStatement()
    {
        if ($this->_insertStatement === null) {
            $this->_insertStatement = $this->getWriteAdapter()
                ->prepare('INSERT INTO game_messages(`message_id`,`message_owner`,`message_sender`,`message_time`,`message_type`,`message_from`,`message_subject`,`message_text`) VALUES(:message_id,:message_owner,:message_sender,:message_time,:message_type,:message_from,:message_subject,:message_text)');
        }

        return $this->_insertStatement;
    }

    /**
     */
    public function insert($message_id,$message_owner,$message_sender,$message_time,$message_type,$message_from,$message_subject,$message_text)
    {
		// 
		$insertmessage_id = $message_id;
		$insertmessage_owner = intval($message_owner);
		$insertmessage_sender = intval($message_sender);
		$insertmessage_time = intval($message_time);
		$insertmessage_type = intval($message_type);
		$insertmessage_from = $message_from;
		$insertmessage_subject = $message_subject;
		$insertmessage_text = $message_text;

	
        $statement = $this->_getInsertStatement();
        $result = $statement->execute(array(
		':message_id'=>$insertmessage_id,
		':message_owner'=>$insertmessage_owner,
		':message_sender'=>$insertmessage_sender,
		':message_time'=>$insertmessage_time,
		':message_type'=>$insertmessage_type,
		':message_from'=>$insertmessage_from,
		':message_subject'=>$insertmessage_subject,
		':message_text'=>$insertmessage_text
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
                ->prepare('DELETE FROM game_messages WHERE `id`=:id;');
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
                ->prepare('UPDATE game_messages SET `message_id`=:message_id,`message_owner`=:message_owner,`message_sender`=:message_sender,`message_time`=:message_time,`message_type`=:message_type,`message_from`=:message_from,`message_subject`=:message_subject,`message_text`=:message_text WHERE ');
        }

        return $this->_updateStatement;
    }

    public function update($message_id,$message_owner,$message_sender,$message_time,$message_type,$message_from,$message_subject,$message_text)
    {
		//securité
		$updatemessage_id = $message_id;
		$updatemessage_owner = intval($message_owner);
		$updatemessage_sender = intval($message_sender);
		$updatemessage_time = intval($message_time);
		$updatemessage_type = intval($message_type);
		$updatemessage_from = $message_from;
		$updatemessage_subject = $message_subject;
		$updatemessage_text = $message_text;

		
        $statement = $this->_getUpdateStatement();
        $result = $statement->execute(array(
		':message_id'=>$updatemessage_id,
		':message_owner'=>$updatemessage_owner,
		':message_sender'=>$updatemessage_sender,
		':message_time'=>$updatemessage_time,
		':message_type'=>$updatemessage_type,
		':message_from'=>$updatemessage_from,
		':message_subject'=>$updatemessage_subject,
		':message_text'=>$updatemessage_text
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
        return $this->getWriteAdapter()->exec('TRUNCATE TABLE game_messages');
    }
}