<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$usuario = "";
$acao = $_POST['acao'];
$senha = "";
$usuario = "";
if(isset($_POST['senha'])){
    $senha = strtoupper($_POST['senha']);
}
if(isset($_POST['usuario'])){
    $usuario = strtoupper($_POST['usuario']);
}




switch ($acao){
    case 'E':
        recuperarEmpresa($usuario);
        break;
    case 'L':
        login($usuario, $senha);
        break;
    case 'S':
        sair();
}

function recuperarEmpresa($usuario){
    require_once './controller/Usuario_Controller.class.php';

    $usuario_Controller = new Usuario_Controller();
    $empresa = $usuario_Controller->recuperarEmpresa($usuario);
    //echo "Recuperar empresa";
    //echo json_encode(array('response' => 1));
    echo json_encode(array('response' => $empresa));
    
}


function login ($usuario, $senha){
    require_once './controller/Usuario_Controller.class.php';
    $usuario_Controller = new Usuario_Controller();

    
    $pwd = $usuario_Controller->recuperarSenha($usuario);
    //echo "Senha do banco: $pwd Senha do usuario: $senha\n";
    $nutricao = $usuario_Controller->verificarPapel($usuario);
  //  echo "Senha rec: ".$pwd."<br>";
    if($pwd == $senha){
        if($nutricao){
            session_start();
            $_SESSION['usuario'] = $usuario;
            echo json_encode(array("retorno" => 1));
        }else{
            echo json_encode(array("retorno" => 2));
        }

    }else{
        echo json_encode(array("retorno" => 0));;
    }
    

}

function sair(){
    session_start();

    unset($_SESSION['usuario']);
    $_SESSION['usuario'] = null;
    header('location: .');
    session_destroy();
    session_commit();
}

