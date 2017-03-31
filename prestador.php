<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$_valor = $_GET['valor'];

if($_valor == ""){
    $_valor = '%';
}
require_once '/controller/Prestador_Controller.class.php';
require_once '/beans/Prestadores.class.php';
require_once './servicos/PrestadorListIterator.class.php';

$pc = new Prestador_Controller();
$prestadorList_in = $pc->lista($_valor);
$prestadorListIterator = new PrestadoresListIterator($prestadorList_in);

$prestador = new Prestadores();
//$prestadores = [
while($prestadorListIterator->hasNextPrestadores()){
    $prestador = $prestadorListIterator->getCurrentPrestadores();
 ?>
<A href="lista.php?codigo=<?php echo $prestador->getId(); ?>&&nome=<?php echo $prestador->getNome(); ?>"
   class="btn btn-default list-group-item" id="#<?php echo $prest->getId(); ?>"
   role="button"
   aria-pressed="true"
   onclick="medico(<?php echo $prest->getId(); ?>);">
       <span><?php echo $prestador->getNome(); ?></span>
   </a>
<?php
   
    
}