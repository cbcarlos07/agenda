<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Paciente_Controller {
    
    public function lista($data, $medico){
        require_once '/model/Paciente_DAO.class.php';
        $pd = new Paciente_DAO();
        $lista = $pd->lista($data, $medico);
        return $lista;
                
    }

    public function getCdTriagemAtendimento($atendimento){
        require_once '/model/Paciente_DAO.class.php';
        $pd = new Paciente_DAO();
        $lista = $pd->getCdTriagemAtendimento($atendimento);
        return $lista;
    }

    public function chamarPaciente($maquina,$atendimento, $triagem){
        require_once '/model/Paciente_DAO.class.php';
        $pd = new Paciente_DAO();
        $lista = $pd->chamarPaciente($maquina,$atendimento, $triagem);
        return $lista;
    }

    public function getNrChamada($atendimento){
        require_once '/model/Paciente_DAO.class.php';
        $pd = new Paciente_DAO();
        $lista = $pd->getNrChamada($atendimento);
        return $lista;
    }

    public function insertNrChamada($atendimento){
        require_once '/model/Paciente_DAO.class.php';
        $pd = new Paciente_DAO();
        $lista = $pd->insertNrChamada($atendimento);
        return $lista;
    }

    public function updateNrChamada($atendimento, $chamada){
        require_once '/model/Paciente_DAO.class.php';
        $pd = new Paciente_DAO();
        $lista = $pd->updateNrChamada($atendimento, $chamada);
        return $lista;
    }
}