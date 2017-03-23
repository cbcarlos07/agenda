<?php
/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 23/03/2017
 * Time: 09:58
 */
$maquina      = $_POST['maquina'];
$atendimento  = $_POST['atendimento'];

include "controller/Paciente_Controller.class.php";
$pacienteController = new Paciente_Controller();

$triagem      = $pacienteController->getCdTriagemAtendimento($atendimento);

//echo 'Triagem: '.$triagem;

$teste       =  $pacienteController->chamarPaciente($maquina, $atendimento, $triagem);
//echo "Retorno: ".$teste;
if($teste){
    echo json_encode(array("retorno" => 1));    
}else{
    echo json_encode(array("retorno" => 0));
}


