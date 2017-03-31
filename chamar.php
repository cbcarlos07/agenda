<?php
/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 23/03/2017
 * Time: 09:58
 */
$maquina      = $_POST['maquina'];
$atendimento  = $_POST['atendimento'];
$chamada      = $_POST['chamada'];

include "controller/Paciente_Controller.class.php";
$pacienteController = new Paciente_Controller();

$triagem      = $pacienteController->getCdTriagemAtendimento($atendimento);

//echo 'Triagem: '.$triagem;

$teste       =  $pacienteController->chamarPaciente($maquina, $atendimento, $triagem);
//echo "Retorno: ".$teste;
$boolChamada = false;
//echo "Chamada: ".$chamada;
if($chamada == 0){
   $boolChamada = $pacienteController->insertNrChamada($atendimento);
}
else{
    $boolChamada = $pacienteController->updateNrChamada($atendimento, $chamada + 1);
}


if($teste){
    echo json_encode(array("retorno" => 1));    
}else{
    echo json_encode(array("retorno" => 0));
}


