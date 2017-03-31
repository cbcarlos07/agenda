<?php
/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 23/03/2017
 * Time: 12:24
 */



$cdprestador      = 0;
$maquina        = "";
$consultorio    = "";
$acao           = $_POST['acao'];


if(isset($_POST['prestador']))
    $cdprestador = $_POST['prestador'];

if(isset($_POST['maquina']))
    $maquina = $_POST['maquina'];

if(isset($_POST['consultorio']))
    $consultorio = $_POST['consultorio'];



switch ($acao){
    case 'C':
        cadastrar($cdprestador, $maquina, $consultorio);
        break;
    case 'B':
        buscar($cdprestador, $maquina);
        break;
}

function cadastrar($cdprestador, $maquina, $consultorio){
    include_once "beans/Prestadores.class.php";
    include_once "controller/Prestador_Controller.class.php";
    //echo "Cadastrar \n";
    $prestador = new Prestadores();

    $prestador->setId($cdprestador);
    $prestador->setValor(getvalor($maquina)); //obtendo o valor cadastrado da maquina
    $prestador->setMaquina($maquina);

    $prestadorController = new Prestador_Controller();
    $possuiConsultorio = $prestadorController->getPossuiMaquina($cdprestador);
    //echo "Possui cadastro: ".$possuiConsultorio."\n";
    $atend = $prestadorController->getEstaAtendendo($cdprestador); //essa linha diz se o prestador já está atendendo [true] ou não [false]
   // echo "Esta atendendo: ".$atend;
    if($atend == 0){
        $prestadorController->insertVaiAtender($cdprestador, $maquina);
    }else{
        $prestadorController->updateVaiAtender($cdprestador, $maquina);
    }
   // $prestadorController->insertVaiAtender($cdprestador, $maquina);
    if($possuiConsultorio){
       $teste = $prestadorController->updateConsultorio($prestador);

    //echo "Update: ".$teste;
    }else{
        $teste = $prestadorController->insertConsultorio($prestador);
        //echo $teste."\n";

     }
    //echo "Update: ".$teste;
    if($teste){
        echo json_encode(array("retorno"=> 1, "valor" => getvalor($maquina)));
    }else{
        echo json_encode(array("retorno"=> 0));
    }

}


function buscar($cdprestador, $maquina){
    include_once "beans/Prestadores.class.php";
    include_once "controller/Prestador_Controller.class.php";
    $prestadorController = new Prestador_Controller();
    $prestador = new Prestadores();
    $prestador = $prestadorController->getLocalPrestador($cdprestador); //essa linha o nome da maquina e o consultorio do computador do médico
    $teste = $prestadorController->getEstaAtendendo($cdprestador); //essa linha diz se o prestador já está atendendo [true] ou não [false]

   /* if(!$teste){
        $prestadorController->insertVaiAtender($cdprestador, $maquina);
    }*/
    if($prestador->getMaquina() != ""){
        echo json_encode(array("maquina"=> $prestador->getMaquina(), "valor" => $prestador->getValor(), "atende" => $teste));
    }else{
        echo json_encode(array("maquina"=> 0));
    }
}

function getvalor($maquina){
    include_once "controller/Prestador_Controller.class.php";

    $prestadorController = new Prestador_Controller();
    $valor = $prestadorController->getLocalValor($maquina);
    return $valor;
}














