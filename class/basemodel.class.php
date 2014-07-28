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
 
abstract class BaseModel
{
    private $_readAdapter = null;
    private $_writeAdapter = null;

    public function __construct(PDO $readAdapter, PDO $writeAdapter = null)
    {
        $this->_readAdapter = $readAdapter;
        if ($writeAdapter === null) {
            $this->_writeAdapter = $this->_readAdapter;
        } else {
            $this->_writeAdapter = $writeAdapter;
        }
    }

    /**
     * @return PDO
     */
    public function getReadAdapter()
    {
        return $this->_readAdapter;
    }

    /**
     * @return PDO
     */
    public function getWriteAdapter()
    {
        return $this->_writeAdapter;
    }

    /**
     * @param PDO $readAdapter
     * @return BaseModel
     */
    public function setReadAdapter(PDO $readAdapter)
    {
        $this->_readAdapter = $readAdapter;

        return $this;
    }

    /**
     * @param PDO $writeAdapter
     * @return BaseModel
     */
    public function setWriteAdapter(PDO $writeAdapter)
    {
        $this->_writeAdapter = $writeAdapter;

        return $this;
    }
}