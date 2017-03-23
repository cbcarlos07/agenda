<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Prestador_Controller {
    
    public function lista ($nome){
        require_once '/model/Prestadores_DAO.class.php';
        $pd = new Prestadores_DAO();
        $lista = $pd->lista($nome);
        return $lista;
                
    }

    public function getLocalPrestador($prestador){
        require_once '/model/Prestadores_DAO.class.php';
        $pd = new Prestadores_DAO();
        $lista = $pd->getLocalPrestador($prestador);
        return $lista;
    }

    public function insertConsultorio(Prestadores $prestador){
        require_once '/model/Prestadores_DAO.class.php';
        $pd = new Prestadores_DAO();
        $lista = $pd->insertConsultorio($prestador);
        return $lista;
    }

    public function getLocalValor($maquina){
        require_once '/model/Prestadores_DAO.class.php';
        $pd = new Prestadores_DAO();
        $lista = $pd->getLocalValor($maquina);
        return $lista;
    }
}