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

class game_banned extends BaseModel
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
					->prepare('SELECT * FROM game_banned ORDER BY `id` DESC');
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
                ->prepare('SELECT * FROM game_banned WHERE `id`=:id or`who`=:who or`theme`=:theme or`who2`=:who2 or`time`=:time or`longer`=:longer or`author`=:author or`email`=:email  LIMIT 1');
        }

        return $this->_selectStatement;
    }

    public function select($id,$who,$theme,$who2,$time,$longer,$author,$email)
    {
		// securité
		$selectid = $id;
		$selectwho = $who;
		$selecttheme = $theme;
		$selectwho2 = $who2;
		$selecttime = intval($time);
		$selectlonger = intval($longer);
		$selectauthor = $author;
		$selectemail = $email;

		
		
		$statement = $this->_getSelectStatement();
        $statement->execute(array(
		':id'=>$selectid,
		':who'=>$selectwho,
		':theme'=>$selecttheme,
		':who2'=>$selectwho2,
		':time'=>$selecttime,
		':longer'=>$selectlonger,
		':author'=>$selectauthor,
		':email'=>$selectemail
        ));

        return $statement->fetchAll();
    }
	/****************BEGIN INSERT****************/	

	protected function _getInsertStatement()
    {
        if ($this->_insertStatement === null) {
            $this->_insertStatement = $this->getWriteAdapter()
                ->prepare('INSERT INTO game_banned(`who`,`theme`,`who2`,`time`,`longer`,`author`,`email`) VALUES(:who,:theme,:who2,:time,:longer,:author,:email)');
        }

        return $this->_insertStatement;
    }

    /**
     */
    public function insert($who,$theme,$who2,$time,$longer,$author,$email)
    {
		// 
		$insertwho = $who;
		$inserttheme = $theme;
		$insertwho2 = $who2;
		$inserttime = intval($time);
		$insertlonger = intval($longer);
		$insertauthor = $author;
		$insertemail = $email;

	
        $statement = $this->_getInsertStatement();
        $result = $statement->execute(array(
		':who'=>$insertwho,
		':theme'=>$inserttheme,
		':who2'=>$insertwho2,
		':time'=>$inserttime,
		':longer'=>$insertlonger,
		':author'=>$insertauthor,
		':email'=>$insertemail
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
                ->prepare('DELETE FROM game_banned WHERE `id`=:id;');
        }
        return $this->_deleteoneStatement;
    }


    public function delete($deuts)
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
                ->prepare('UPDATE game_banned SET `who`=:who,`theme`=:theme,`who2`=:who2,`time`=:time,`longer`=:longer,`author`=:author,`email`=:email WHERE `id`=:id');
        }

        return $this->_updateStatement;
    }

    public function update($id,$who,$theme,$who2,$time,$longer,$author,$email)
    {
		//securité
		$updateid = $id;
		$updatewho = $who;
		$updatetheme = $theme;
		$updatewho2 = $who2;
		$updatetime = intval($time);
		$updatelonger = intval($longer);
		$updateauthor = $author;
		$updateemail = $email;

		
        $statement = $this->_getUpdateStatement();
        $result = $statement->execute(array(
		':id'=>$updateid,
		':who'=>$updatewho,
		':theme'=>$updatetheme,
		':who2'=>$updatewho2,
		':time'=>$updatetime,
		':longer'=>$updatelonger,
		':author'=>$updateauthor,
		':email'=>$updateemail
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
        return $this->getWriteAdapter()->exec('TRUNCATE TABLE game_banned');
    }
}