<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$nome = strtoupper($_GET['nome']);
require_once './controller/Prestador_Controller.class.php';
require_once './beans/Prestadores.class.php';
require_once './servicos/PrestadorListIterator.class.php';
$p = new Prestador_Controller();
if($nome == ""){
    $nome = "%";
}else{
    $nome = "%".$nome."%";
}
$prestadorList_in = $p->lista($nome);
$pLista = new PrestadoresListIterator($prestadorList_in);
$prest =  new Prestadores();
while ($pLista->hasNextPrestadores()){
    $prest = $pLista->getNextPrestadores();
 ?>
<div class="col-xs-12 col-sm-4 col-lg-3">
 <div  class="list-group">
        <A href="lista.php?codigo=<?php echo $prest->getId(); ?>&&nome=<?php echo $prest->getNome(); ?>" class="btn btn-default list-group-item" id="#<?php echo $prest->getId(); ?>" role="button" aria-pressed="true" onclick="medico(<?php echo $prest->getId(); ?>);">
           <span><?php echo $prest->getNome(); ?></span> 
        </a>
  </div>    
</div>                                
<?php
}   
 ?>