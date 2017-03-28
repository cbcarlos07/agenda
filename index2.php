<?php
 $maquina = $_POST['maquina'];
 $valor   = $_POST['sala'];
 echo "Sala: ".$valor;
  session_start();

  $_SESSION['maquina'] = $maquina;
  $_SESSION['sala'] = $sala;

  header('location: lista.php');

?>