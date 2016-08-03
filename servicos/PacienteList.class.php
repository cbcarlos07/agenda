<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class PacienteList {
    private $_paciente = array();
    private $_pacienteCount = 0;
    public function __construct() {
    }
    public function getPacienteCount() {
      return $this->_pacienteCount;
    }
    private function setPacienteCount($newCount) {
      $this->_pacienteCount = $newCount;
    }
    public function getPaciente($_pacienteNumberToGet) {
      if ( (is_numeric($_pacienteNumberToGet)) && 
           ($_pacienteNumberToGet <= $this->getPacienteCount())) {
           return $this->_paciente[$_pacienteNumberToGet];
         } else {
           return NULL;
         }
    }
    public function addPaciente(Paciente $_paciente_in) {
      $this->setPacienteCount($this->getPacienteCount() + 1);
      $this->_paciente[$this->getPacienteCount()] = $_paciente_in;
      return $this->getPacienteCount();
    }
    public function removePaciente(Paciente $_paciente_in) {
      $counter = 0;
      while (++$counter <= $this->getPacienteCount()) {
        if ($_paciente_in->getAuthorAndTitle() == 
          $this->_paciente[$counter]->getAuthorAndTitle())
          {
            for ($x = $counter; $x < $this->getPacienteCount(); $x++) {
              $this->_paciente[$x] = $this->_paciente[$x + 1];
          }
          $this->setPacienteCount($this->getPacienteCount() - 1);
        }
      }
      return $this->getPacienteCount();
    }
}
