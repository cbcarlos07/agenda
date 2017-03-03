<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Data_Controller {
    
    public function getDataDB (){
        require_once '/model/Data_DAO.class.php';
        $pd = new Data_DAO();
        $lista = $pd->getDataDB();
        return $lista;
                
    }
}