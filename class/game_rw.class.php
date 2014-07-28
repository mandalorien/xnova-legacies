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

class game_rw extends BaseModel
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
					->prepare('SELECT * FROM game_rw ORDER BY `id` DESC');
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
                ->prepare('SELECT * FROM game_rw WHERE `id_owner1`=:id_owner1 or`id_owner2`=:id_owner2 or`owners`=:owners or`rid`=:rid or`raport`=:raport or`a_zestrzelona`=:a_zestrzelona or`time`=:time  LIMIT 1');
        }

        return $this->_selectStatement;
    }

    public function select($id_owner1,$id_owner2,$owners,$rid,$raport,$a_zestrzelona,$time)
    {
		// securité
		$selectid_owner1 = intval($id_owner1);
		$selectid_owner2 = intval($id_owner2);
		$selectowners = $owners;
		$selectrid = $rid;
		$selectraport = $raport;
		$selecta_zestrzelona = $a_zestrzelona;
		$selecttime = intval($time);

		
		
		$statement = $this->_getSelectStatement();
        $statement->execute(array(
		':id_owner1'=>$selectid_owner1,
		':id_owner2'=>$selectid_owner2,
		':owners'=>$selectowners,
		':rid'=>$selectrid,
		':raport'=>$selectraport,
		':a_zestrzelona'=>$selecta_zestrzelona,
		':time'=>$selecttime
        ));

        return $statement->fetchAll();
    }
	/****************BEGIN INSERT****************/	

	protected function _getInsertStatement()
    {
        if ($this->_insertStatement === null) {
            $this->_insertStatement = $this->getWriteAdapter()
                ->prepare('INSERT INTO game_rw(`id_owner1`,`id_owner2`,`owners`,`rid`,`raport`,`a_zestrzelona`,`time`) VALUES(:id_owner1,:id_owner2,:owners,:rid,:raport,:a_zestrzelona,:time)');
        }

        return $this->_insertStatement;
    }

    /**
     */
    public function insert($id_owner1,$id_owner2,$owners,$rid,$raport,$a_zestrzelona,$time)
    {
		// 
		$insertid_owner1 = intval($id_owner1);
		$insertid_owner2 = intval($id_owner2);
		$insertowners = $owners;
		$insertrid = $rid;
		$insertraport = $raport;
		$inserta_zestrzelona = $a_zestrzelona;
		$inserttime = intval($time);

	
        $statement = $this->_getInsertStatement();
        $result = $statement->execute(array(
		':id_owner1'=>$insertid_owner1,
		':id_owner2'=>$insertid_owner2,
		':owners'=>$insertowners,
		':rid'=>$insertrid,
		':raport'=>$insertraport,
		':a_zestrzelona'=>$inserta_zestrzelona,
		':time'=>$inserttime
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
                ->prepare('DELETE FROM game_rw WHERE `id`=:id;');
        }
        return $this->_deleteoneStatement;
    }


    public function delete($text)
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
                ->prepare('UPDATE game_rw SET `id_owner1`=:id_owner1,`id_owner2`=:id_owner2,`owners`=:owners,`rid`=:rid,`raport`=:raport,`a_zestrzelona`=:a_zestrzelona,`time`=:time WHERE ');
        }

        return $this->_updateStatement;
    }

    public function update($id_owner1,$id_owner2,$owners,$rid,$raport,$a_zestrzelona,$time)
    {
		//securité
		$updateid_owner1 = intval($id_owner1);
		$updateid_owner2 = intval($id_owner2);
		$updateowners = $owners;
		$updaterid = $rid;
		$updateraport = $raport;
		$updatea_zestrzelona = $a_zestrzelona;
		$updatetime = intval($time);

		
        $statement = $this->_getUpdateStatement();
        $result = $statement->execute(array(
		':id_owner1'=>$updateid_owner1,
		':id_owner2'=>$updateid_owner2,
		':owners'=>$updateowners,
		':rid'=>$updaterid,
		':raport'=>$updateraport,
		':a_zestrzelona'=>$updatea_zestrzelona,
		':time'=>$updatetime
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
        return $this->getWriteAdapter()->exec('TRUNCATE TABLE game_rw');
    }
}