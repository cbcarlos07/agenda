<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of SalaIterator
 *
 * @author CARLOS
 */
class SalaListIterator {
    protected $salaList;
    protected $currentSala = 0;

    public function __construct(SalaList $salaList_in) {
      $this->salaList = $salaList_in;
    }
    public function getCurrentSala() {
      if (($this->currentSala > 0) && 
          ($this->salaList->getSalaCount() >= $this->currentSala)) {
        return $this->salaList->getSala($this->currentSala);
      }
    }
    public function getNextSala() {
      if ($this->hasNextSala()) {
        return $this->salaList->getSala(++$this->currentSala);
      } else {
        return NULL;
      }
    }
    public function hasNextSala() {
      if ($this->salaList->getSalaCount() > $this->currentSala) {
        return TRUE;
      } else {
        return FALSE;
      }
    }
}