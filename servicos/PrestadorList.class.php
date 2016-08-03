<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class PrestadoresList {
    private $_prestador = array();
    private $_prestadorCount = 0;
    public function __construct() {
    }
    public function getPrestadoresCount() {
      return $this->_prestadorCount;
    }
    private function setPrestadoresCount($newCount) {
      $this->_prestadorCount = $newCount;
    }
    public function getPrestadores($_prestadorNumberToGet) {
      if ( (is_numeric($_prestadorNumberToGet)) && 
           ($_prestadorNumberToGet <= $this->getPrestadoresCount())) {
           return $this->_prestador[$_prestadorNumberToGet];
         } else {
           return NULL;
         }
    }
    public function addPrestadores(Prestadores $_prestador_in) {
      $this->setPrestadoresCount($this->getPrestadoresCount() + 1);
      $this->_prestador[$this->getPrestadoresCount()] = $_prestador_in;
      return $this->getPrestadoresCount();
    }
    public function removePrestadores(Prestadores $_prestador_in) {
      $counter = 0;
      while (++$counter <= $this->getPrestadoresCount()) {
        if ($_prestador_in->getAuthorAndTitle() == 
          $this->_prestador[$counter]->getAuthorAndTitle())
          {
            for ($x = $counter; $x < $this->getPrestadoresCount(); $x++) {
              $this->_prestador[$x] = $this->_prestador[$x + 1];
          }
          $this->setPrestadoresCount($this->getPrestadoresCount() - 1);
        }
      }
      return $this->getPrestadoresCount();
    }
}
