<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Usuario_Controller {
    public function recuperarEmpresa ($user){
        require_once './model/Usuario_DAO.class.php';
        $ud = new Usuario_DAO();
        $teste = $ud->recuperarEmpresa($user);
        return $teste;
    }
    
    public function recuperarSenha ($user){
        require_once './model/Usuario_DAO.class.php';
        $ud = new Usuario_DAO();
        $teste = $ud->recuperarSenha($user);
        return $teste;
    }
    public function verificarPapel ($login){
        require_once './model/Usuario_DAO.class.php';
        $ud = new Usuario_DAO();
        $teste = $ud->verificarPapel($login);
        return $teste;
    }
}