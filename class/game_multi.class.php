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

class game_multi extends BaseModel
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
					->prepare('SELECT * FROM game_multi ORDER BY `id` DESC');
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
                ->prepare('SELECT * FROM game_multi WHERE `id`=:id or`player`=:player or`sharer`=:sharer or`reason`=:reason  LIMIT 1');
        }

        return $this->_selectStatement;
    }

    public function select($id,$player,$sharer,$reason)
    {
		// securité
		$selectid = intval($id);
		$selectplayer = $player;
		$selectsharer = $sharer;
		$selectreason = $reason;

		
		
		$statement = $this->_getSelectStatement();
        $statement->execute(array(
		':id'=>$selectid,
		':player'=>$selectplayer,
		':sharer'=>$selectsharer,
		':reason'=>$selectreason
        ));

        return $statement->fetchAll();
    }
	/****************BEGIN INSERT****************/	

	protected function _getInsertStatement()
    {
        if ($this->_insertStatement === null) {
            $this->_insertStatement = $this->getWriteAdapter()
                ->prepare('INSERT INTO game_multi(`player`,`sharer`,`reason`) VALUES(:player,:sharer,:reason)');
        }

        return $this->_insertStatement;
    }

    /**
     */
    public function insert($player,$sharer,$reason)
    {
		// 
		$insertplayer = $player;
		$insertsharer = $sharer;
		$insertreason = $reason;

	
        $statement = $this->_getInsertStatement();
        $result = $statement->execute(array(
		':player'=>$insertplayer,
		':sharer'=>$insertsharer,
		':reason'=>$insertreason
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
                ->prepare('DELETE FROM game_multi WHERE `id`=:id;');
        }
        return $this->_deleteoneStatement;
    }


    public function delete($message_text)
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
                ->prepare('UPDATE game_multi SET `player`=:player,`sharer`=:sharer,`reason`=:reason WHERE `id`=:id');
        }

        return $this->_updateStatement;
    }

    public function update($id,$player,$sharer,$reason)
    {
		//securité
		$updateid = intval($id);
		$updateplayer = $player;
		$updatesharer = $sharer;
		$updatereason = $reason;

		
        $statement = $this->_getUpdateStatement();
        $result = $statement->execute(array(
		':id'=>$updateid,
		':player'=>$updateplayer,
		':sharer'=>$updatesharer,
		':reason'=>$updatereason
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
        return $this->getWriteAdapter()->exec('TRUNCATE TABLE game_multi');
    }
}