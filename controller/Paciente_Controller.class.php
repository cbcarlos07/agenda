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
}