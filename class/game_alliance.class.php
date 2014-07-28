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

class game_alliance extends BaseModel
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
					->prepare('SELECT * FROM game_alliance ORDER BY `id` DESC');
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
                ->prepare('SELECT * FROM game_alliance WHERE `id`=:id or`ally_name`=:ally_name or`ally_tag`=:ally_tag or`ally_owner`=:ally_owner or`ally_register_time`=:ally_register_time or`ally_description`=:ally_description or`ally_web`=:ally_web or`ally_text`=:ally_text or`ally_image`=:ally_image or`ally_request`=:ally_request or`ally_request_waiting`=:ally_request_waiting or`ally_request_notallow`=:ally_request_notallow or`ally_owner_range`=:ally_owner_range or`ally_ranks`=:ally_ranks or`ally_members`=:ally_members  LIMIT 1');
        }

        return $this->_selectStatement;
    }

    public function select($id,$ally_name,$ally_tag,$ally_owner,$ally_register_time,$ally_description,$ally_web,$ally_text,$ally_image,$ally_request,$ally_request_waiting,$ally_request_notallow,$ally_owner_range,$ally_ranks,$ally_members)
    {
		// securité
		$selectid = $id;
		$selectally_name = $ally_name;
		$selectally_tag = $ally_tag;
		$selectally_owner = intval($ally_owner);
		$selectally_register_time = intval($ally_register_time);
		$selectally_description = $ally_description;
		$selectally_web = $ally_web;
		$selectally_text = $ally_text;
		$selectally_image = $ally_image;
		$selectally_request = $ally_request;
		$selectally_request_waiting = $ally_request_waiting;
		$selectally_request_notallow = $ally_request_notallow;
		$selectally_owner_range = $ally_owner_range;
		$selectally_ranks = $ally_ranks;
		$selectally_members = intval($ally_members);

		
		
		$statement = $this->_getSelectStatement();
        $statement->execute(array(
		':id'=>$selectid,
		':ally_name'=>$selectally_name,
		':ally_tag'=>$selectally_tag,
		':ally_owner'=>$selectally_owner,
		':ally_register_time'=>$selectally_register_time,
		':ally_description'=>$selectally_description,
		':ally_web'=>$selectally_web,
		':ally_text'=>$selectally_text,
		':ally_image'=>$selectally_image,
		':ally_request'=>$selectally_request,
		':ally_request_waiting'=>$selectally_request_waiting,
		':ally_request_notallow'=>$selectally_request_notallow,
		':ally_owner_range'=>$selectally_owner_range,
		':ally_ranks'=>$selectally_ranks,
		':ally_members'=>$selectally_members
        ));

        return $statement->fetchAll();
    }
	/****************BEGIN INSERT****************/	

	protected function _getInsertStatement()
    {
        if ($this->_insertStatement === null) {
            $this->_insertStatement = $this->getWriteAdapter()
                ->prepare('INSERT INTO game_alliance(`ally_name`,`ally_tag`,`ally_owner`,`ally_register_time`,`ally_description`,`ally_web`,`ally_text`,`ally_image`,`ally_request`,`ally_request_waiting`,`ally_request_notallow`,`ally_owner_range`,`ally_ranks`,`ally_members`) VALUES(:ally_name,:ally_tag,:ally_owner,:ally_register_time,:ally_description,:ally_web,:ally_text,:ally_image,:ally_request,:ally_request_waiting,:ally_request_notallow,:ally_owner_range,:ally_ranks,:ally_members)');
        }

        return $this->_insertStatement;
    }

    /**
     */
    public function insert($ally_name,$ally_tag,$ally_owner,$ally_register_time,$ally_description,$ally_web,$ally_text,$ally_image,$ally_request,$ally_request_waiting,$ally_request_notallow,$ally_owner_range,$ally_ranks,$ally_members)
    {
		// 
		$insertally_name = $ally_name;
		$insertally_tag = $ally_tag;
		$insertally_owner = intval($ally_owner);
		$insertally_register_time = intval($ally_register_time);
		$insertally_description = $ally_description;
		$insertally_web = $ally_web;
		$insertally_text = $ally_text;
		$insertally_image = $ally_image;
		$insertally_request = $ally_request;
		$insertally_request_waiting = $ally_request_waiting;
		$insertally_request_notallow = $ally_request_notallow;
		$insertally_owner_range = $ally_owner_range;
		$insertally_ranks = $ally_ranks;
		$insertally_members = intval($ally_members);

	
        $statement = $this->_getInsertStatement();
        $result = $statement->execute(array(
		':ally_name'=>$insertally_name,
		':ally_tag'=>$insertally_tag,
		':ally_owner'=>$insertally_owner,
		':ally_register_time'=>$insertally_register_time,
		':ally_description'=>$insertally_description,
		':ally_web'=>$insertally_web,
		':ally_text'=>$insertally_text,
		':ally_image'=>$insertally_image,
		':ally_request'=>$insertally_request,
		':ally_request_waiting'=>$insertally_request_waiting,
		':ally_request_notallow'=>$insertally_request_notallow,
		':ally_owner_range'=>$insertally_owner_range,
		':ally_ranks'=>$insertally_ranks,
		':ally_members'=>$insertally_members
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
                ->prepare('DELETE FROM game_alliance WHERE `id`=:id;');
        }
        return $this->_deleteoneStatement;
    }


    public function delete($eingeladen)
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
                ->prepare('UPDATE game_alliance SET `ally_name`=:ally_name,`ally_tag`=:ally_tag,`ally_owner`=:ally_owner,`ally_register_time`=:ally_register_time,`ally_description`=:ally_description,`ally_web`=:ally_web,`ally_text`=:ally_text,`ally_image`=:ally_image,`ally_request`=:ally_request,`ally_request_waiting`=:ally_request_waiting,`ally_request_notallow`=:ally_request_notallow,`ally_owner_range`=:ally_owner_range,`ally_ranks`=:ally_ranks,`ally_members`=:ally_members WHERE `id`=:id');
        }

        return $this->_updateStatement;
    }

    public function update($id,$ally_name,$ally_tag,$ally_owner,$ally_register_time,$ally_description,$ally_web,$ally_text,$ally_image,$ally_request,$ally_request_waiting,$ally_request_notallow,$ally_owner_range,$ally_ranks,$ally_members)
    {
		//securité
		$updateid = $id;
		$updateally_name = $ally_name;
		$updateally_tag = $ally_tag;
		$updateally_owner = intval($ally_owner);
		$updateally_register_time = intval($ally_register_time);
		$updateally_description = $ally_description;
		$updateally_web = $ally_web;
		$updateally_text = $ally_text;
		$updateally_image = $ally_image;
		$updateally_request = $ally_request;
		$updateally_request_waiting = $ally_request_waiting;
		$updateally_request_notallow = $ally_request_notallow;
		$updateally_owner_range = $ally_owner_range;
		$updateally_ranks = $ally_ranks;
		$updateally_members = intval($ally_members);

		
        $statement = $this->_getUpdateStatement();
        $result = $statement->execute(array(
		':id'=>$updateid,
		':ally_name'=>$updateally_name,
		':ally_tag'=>$updateally_tag,
		':ally_owner'=>$updateally_owner,
		':ally_register_time'=>$updateally_register_time,
		':ally_description'=>$updateally_description,
		':ally_web'=>$updateally_web,
		':ally_text'=>$updateally_text,
		':ally_image'=>$updateally_image,
		':ally_request'=>$updateally_request,
		':ally_request_waiting'=>$updateally_request_waiting,
		':ally_request_notallow'=>$updateally_request_notallow,
		':ally_owner_range'=>$updateally_owner_range,
		':ally_ranks'=>$updateally_ranks,
		':ally_members'=>$updateally_members
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
        return $this->getWriteAdapter()->exec('TRUNCATE TABLE game_alliance');
    }
}