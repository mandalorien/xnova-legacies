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
class game_notes extends BaseModel
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
					->prepare('SELECT * FROM game_notes ORDER BY `id` DESC');
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
                ->prepare('SELECT * FROM game_notes WHERE `id`=:id or`owner`=:owner or`time`=:time or`priority`=:priority or`title`=:title or`text`=:text  LIMIT 1');
        }

        return $this->_selectStatement;
    }

    public function select($id,$owner,$time,$priority,$title,$text)
    {
		// securité
		$selectid = $id;
		$selectowner = intval($owner);
		$selecttime = intval($time);
		$selectpriority = $priority;
		$selecttitle = $title;
		$selecttext = $text;

		
		
		$statement = $this->_getSelectStatement();
        $statement->execute(array(
		':id'=>$selectid,
		':owner'=>$selectowner,
		':time'=>$selecttime,
		':priority'=>$selectpriority,
		':title'=>$selecttitle,
		':text'=>$selecttext
        ));

        return $statement->fetchAll();
    }
	/****************BEGIN INSERT****************/	

	protected function _getInsertStatement()
    {
        if ($this->_insertStatement === null) {
            $this->_insertStatement = $this->getWriteAdapter()
                ->prepare('INSERT INTO game_notes(`owner`,`time`,`priority`,`title`,`text`) VALUES(:owner,:time,:priority,:title,:text)');
        }

        return $this->_insertStatement;
    }

    /**
     */
    public function insert($owner,$time,$priority,$title,$text)
    {
		// 
		$insertowner = intval($owner);
		$inserttime = intval($time);
		$insertpriority = $priority;
		$inserttitle = $title;
		$inserttext = $text;

	
        $statement = $this->_getInsertStatement();
        $result = $statement->execute(array(
		':owner'=>$insertowner,
		':time'=>$inserttime,
		':priority'=>$insertpriority,
		':title'=>$inserttitle,
		':text'=>$inserttext
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
                ->prepare('DELETE FROM game_notes WHERE `id`=:id;');
        }
        return $this->_deleteoneStatement;
    }


    public function delete($reason)
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
                ->prepare('UPDATE game_notes SET `owner`=:owner,`time`=:time,`priority`=:priority,`title`=:title,`text`=:text WHERE `id`=:id');
        }

        return $this->_updateStatement;
    }

    public function update($id,$owner,$time,$priority,$title,$text)
    {
		//securité
		$updateid = $id;
		$updateowner = intval($owner);
		$updatetime = intval($time);
		$updatepriority = $priority;
		$updatetitle = $title;
		$updatetext = $text;

		
        $statement = $this->_getUpdateStatement();
        $result = $statement->execute(array(
		':id'=>$updateid,
		':owner'=>$updateowner,
		':time'=>$updatetime,
		':priority'=>$updatepriority,
		':title'=>$updatetitle,
		':text'=>$updatetext
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
        return $this->getWriteAdapter()->exec('TRUNCATE TABLE game_notes');
    }
}