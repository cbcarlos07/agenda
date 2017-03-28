<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Sala_Controller {

    public function insert(Sala $sala){
        require_once '/model/SalaDAO.class.php';
        $pd = new SalaDAO();
        $lista = $pd->insert($sala);
        return $lista;
                
    }

    public function update(Sala $sala){
        require_once '/model/SalaDAO.class.php';
        $pd = new SalaDAO();
        $lista = $pd->update($sala);
        return $lista;

    }

    public function delete($sala, $maquina){
        require_once '/model/SalaDAO.class.php';
        $pd = new SalaDAO();
        $lista = $pd->delete($sala, $maquina);
        return $lista;

    }

    public function getListaSala($maquina){
        require_once '/model/SalaDAO.class.php';
        $pd = new SalaDAO();
        $lista = $pd->getListaSala($maquina);
        return $lista;
    }

    public function getSala($maquina){
        require_once '/model/SalaDAO.class.php';
        $pd = new SalaDAO();
        $lista = $pd->getSala($maquina);
        return $lista;
    }

}