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

class game_annonce extends BaseModel
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
					->prepare('SELECT * FROM game_annonce ORDER BY `id` DESC');
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
                ->prepare('SELECT * FROM game_annonce WHERE `id`=:id or`user`=:user or`id_user`=:id_user or`galaxie`=:galaxie or`systeme`=:systeme or`planet`=:planet or`metala`=:metala or`cristala`=:cristala or`deuta`=:deuta or`metals`=:metals or`cristals`=:cristals or`deuts`=:deuts  LIMIT 1');
        }

        return $this->_selectStatement;
    }

    public function select($id,$user,$id_user,$galaxie,$systeme,$planet,$metala,$cristala,$deuta,$metals,$cristals,$deuts)
    {
		// securité
		$selectid = intval($id);
		$selectuser = $user;
		$selectid_user = intval($id_user);
		$selectgalaxie = intval($galaxie);
		$selectsysteme = intval($systeme);
		$selectplanet = intval($planet);
		$selectmetala = $metala;
		$selectcristala = $cristala;
		$selectdeuta = $deuta;
		$selectmetals = $metals;
		$selectcristals = $cristals;
		$selectdeuts = $deuts;

		
		
		$statement = $this->_getSelectStatement();
        $statement->execute(array(
		':id'=>$selectid,
		':user'=>$selectuser,
		':id_user'=>$selectid_user,
		':galaxie'=>$selectgalaxie,
		':systeme'=>$selectsysteme,
		':planet'=>$selectplanet,
		':metala'=>$selectmetala,
		':cristala'=>$selectcristala,
		':deuta'=>$selectdeuta,
		':metals'=>$selectmetals,
		':cristals'=>$selectcristals,
		':deuts'=>$selectdeuts
        ));

        return $statement->fetchAll();
    }
	/****************BEGIN INSERT****************/	

	protected function _getInsertStatement()
    {
        if ($this->_insertStatement === null) {
            $this->_insertStatement = $this->getWriteAdapter()
                ->prepare('INSERT INTO game_annonce(`user`,`id_user`,`galaxie`,`systeme`,`planet`,`metala`,`cristala`,`deuta`,`metals`,`cristals`,`deuts`) VALUES(:user,:id_user,:galaxie,:systeme,:planet,:metala,:cristala,:deuta,:metals,:cristals,:deuts)');
        }

        return $this->_insertStatement;
    }

    /**
     */
    public function insert($user,$id_user,$galaxie,$systeme,$planet,$metala,$cristala,$deuta,$metals,$cristals,$deuts)
    {
		// 
		$insertuser = $user;
		$insertid_user = intval($id_user);
		$insertgalaxie = intval($galaxie);
		$insertsysteme = intval($systeme);
		$insertplanet = intval($planet);
		$insertmetala = $metala;
		$insertcristala = $cristala;
		$insertdeuta = $deuta;
		$insertmetals = $metals;
		$insertcristals = $cristals;
		$insertdeuts = $deuts;

	
        $statement = $this->_getInsertStatement();
        $result = $statement->execute(array(
		':user'=>$insertuser,
		':id_user'=>$insertid_user,
		':galaxie'=>$insertgalaxie,
		':systeme'=>$insertsysteme,
		':planet'=>$insertplanet,
		':metala'=>$insertmetala,
		':cristala'=>$insertcristala,
		':deuta'=>$insertdeuta,
		':metals'=>$insertmetals,
		':cristals'=>$insertcristals,
		':deuts'=>$insertdeuts
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
                ->prepare('DELETE FROM game_annonce WHERE `id`=:id;');
        }
        return $this->_deleteoneStatement;
    }


    public function delete($ally_members)
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
                ->prepare('UPDATE game_annonce SET `user`=:user,`id_user`=:id_user,`galaxie`=:galaxie,`systeme`=:systeme,`planet`=:planet,`metala`=:metala,`cristala`=:cristala,`deuta`=:deuta,`metals`=:metals,`cristals`=:cristals,`deuts`=:deuts WHERE `id`=:id');
        }

        return $this->_updateStatement;
    }

    public function update($id,$user,$id_user,$galaxie,$systeme,$planet,$metala,$cristala,$deuta,$metals,$cristals,$deuts)
    {
		//securité
		$updateid = intval($id);
		$updateuser = $user;
		$updateid_user = intval($id_user);
		$updategalaxie = intval($galaxie);
		$updatesysteme = intval($systeme);
		$updateplanet = intval($planet);
		$updatemetala = $metala;
		$updatecristala = $cristala;
		$updatedeuta = $deuta;
		$updatemetals = $metals;
		$updatecristals = $cristals;
		$updatedeuts = $deuts;

		
        $statement = $this->_getUpdateStatement();
        $result = $statement->execute(array(
		':id'=>$updateid,
		':user'=>$updateuser,
		':id_user'=>$updateid_user,
		':galaxie'=>$updategalaxie,
		':systeme'=>$updatesysteme,
		':planet'=>$updateplanet,
		':metala'=>$updatemetala,
		':cristala'=>$updatecristala,
		':deuta'=>$updatedeuta,
		':metals'=>$updatemetals,
		':cristals'=>$updatecristals,
		':deuts'=>$updatedeuts
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
        return $this->getWriteAdapter()->exec('TRUNCATE TABLE game_annonce');
    }
}