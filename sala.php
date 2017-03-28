<?php
/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 27/03/2017
 * Time: 12:10
 */
$acao = $_POST['acao'];
$id      = 0;
$maquina = "";
$sala    = "";
$aux     = "";


if(isset($_POST['id'])){
    $id = $_POST['id'];
}

if(isset($_POST['maquina'])){
    $maquina = $_POST['maquina'];
}

if(isset($_POST['sala'])){
    $sala = $_POST['sala'];
}

if(isset($_POST['auxiliar'])){
    $aux = $_POST['auxiliar'];
}

switch ($acao){
    case 'C':
        cadastrar($maquina, $sala);
        break;
    case 'A':
        alterar($id, $maquina, $sala, $aux);
        break;
    case 'E':
        excluir($id, $maquina);
        break;
    case 'P':
        pesquisa($maquina);
        break;
}


function cadastrar($maquina, $room){
    include_once "beans/Sala.class.php";
    include_once "controller/Sala_Controller.class.php";

    $sala = new Sala();
    $salaController = new Sala_Controller();

    $sala->setDsMaquina($maquina);
    $sala->setDsConsultorio($room);
    $teste = $salaController->insert($sala);

    if($teste){
        echo json_encode(array("retorno" => 1));
    }else{
        echo json_encode(array("retorno" => 0));
    }
}

function alterar($codigo, $maquina, $room, $aux){
    include_once "beans/Sala.class.php";
    include_once "controller/Sala_Controller.class.php";

    $sala = new Sala();
    $salaController = new Sala_Controller();
    $sala->setCdSala($codigo);
    $sala->setDsMaquina($maquina);
    $sala->setDsConsultorio($room);
    $sala->setDsMaquinaAux($aux);
    $teste = $salaController->update($sala);

    if($teste){
        echo json_encode(array("retorno" => 1));
    }else{
        echo json_encode(array("retorno" => 0));
    }
}


function excluir($codigo, $maquina){
    include_once "beans/Sala.class.php";
    include_once "controller/Sala_Controller.class.php";


    $salaController = new Sala_Controller();
    $teste = $salaController->delete($codigo, $maquina);

    if($teste){
        echo json_encode(array("retorno" => 1));
    }else{
        echo json_encode(array("retorno" => 0));
    }
}

function pesquisa($maquina){
    include_once "beans/Sala.class.php";
    include_once "controller/Sala_Controller.class.php";
    include_once "servicos/SalaListIterator.class.php";

    $sala = new Sala();
    $salaController = new Sala_Controller();
    $lista = $salaController->getListaSala($maquina);

    $salaListiterator = new SalaListIterator($lista);
    $texto = "";
    while ($salaListiterator->hasNextSala()){
        $sala = $salaListiterator->getNextSala();
        $texto .= "<tr>
                       <td>".$sala->getCdSala()."</td>
                       <td>".$sala->getDsMaquina()."</td>
                       <td>".$sala->getDsConsultorio()."</td>
                   </tr>";
    }

    echo $texto;
}