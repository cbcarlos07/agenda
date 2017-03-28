<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class SalaList {
    private $_sala = array();
    private $_salaCount = 0;
    public function __construct() {
    }
    public function getSalaCount() {
      return $this->_salaCount;
    }
    private function setSalaCount($newCount) {
      $this->_salaCount = $newCount;
    }
    public function getSala($_salaNumberToGet) {
      if ( (is_numeric($_salaNumberToGet)) && 
           ($_salaNumberToGet <= $this->getSalaCount())) {
           return $this->_sala[$_salaNumberToGet];
         } else {
           return NULL;
         }
    }
    public function addSala(Sala $_sala_in) {
      $this->setSalaCount($this->getSalaCount() + 1);
      $this->_sala[$this->getSalaCount()] = $_sala_in;
      return $this->getSalaCount();
    }
    public function removeSala(Sala $_sala_in) {
      $counter = 0;
      while (++$counter <= $this->getSalaCount()) {
        if ($_sala_in->getAuthorAndTitle() == 
          $this->_sala[$counter]->getAuthorAndTitle())
          {
            for ($x = $counter; $x < $this->getSalaCount(); $x++) {
              $this->_sala[$x] = $this->_sala[$x + 1];
          }
          $this->setSalaCount($this->getSalaCount() - 1);
        }
      }
      return $this->getSalaCount();
    }
}
