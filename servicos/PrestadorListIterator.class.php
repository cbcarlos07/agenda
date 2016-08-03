<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of PrestadoresIterator
 *
 * @author CARLOS
 */
class PrestadoresListIterator {
    protected $prestadorList;
    protected $currentPrestadores = 0;

    public function __construct(PrestadoresList $prestadorList_in) {
      $this->prestadorList = $prestadorList_in;
    }
    public function getCurrentPrestadores() {
      if (($this->currentPrestadores > 0) && 
          ($this->prestadorList->getPrestadoresCount() >= $this->currentPrestadores)) {
        return $this->prestadorList->getPrestadores($this->currentPrestadores);
      }
    }
    public function getNextPrestadores() {
      if ($this->hasNextPrestadores()) {
        return $this->prestadorList->getPrestadores(++$this->currentPrestadores);
      } else {
        return NULL;
      }
    }
    public function hasNextPrestadores() {
      if ($this->prestadorList->getPrestadoresCount() > $this->currentPrestadores) {
        return TRUE;
      } else {
        return FALSE;
      }
    }
}