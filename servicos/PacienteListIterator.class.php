<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of PacienteIterator
 *
 * @author CARLOS
 */
class PacienteListIterator {
    protected $pacienteList;
    protected $currentPaciente = 0;

    public function __construct(PacienteList $pacienteList_in) {
      $this->pacienteList = $pacienteList_in;
    }
    public function getCurrentPaciente() {
      if (($this->currentPaciente > 0) && 
          ($this->pacienteList->getPacienteCount() >= $this->currentPaciente)) {
        return $this->pacienteList->getPaciente($this->currentPaciente);
      }
    }
    public function getNextPaciente() {
      if ($this->hasNextPaciente()) {
        return $this->pacienteList->getPaciente(++$this->currentPaciente);
      } else {
        return NULL;
      }
    }
    public function hasNextPaciente() {
      if ($this->pacienteList->getPacienteCount() > $this->currentPaciente) {
        return TRUE;
      } else {
        return FALSE;
      }
    }
}