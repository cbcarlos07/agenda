<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
include "timezone.php";
session_start();
require_once "beans/Data.class.php";
require_once "controller/Data_Controller.class.php";

$objData = new Data();
$dataController = new Data_Controller();
$objData = $dataController->getDataDB();

if(!isset($_POST['datepicker'])){
                    $data = $objData->getData();
                    $_SESSION['data'] = $data;

                }else{
                    $data = $_POST['datepicker'];
                    $_SESSION['data'] = $data;
                }



if(isset($_POST['cd_prestador'])){
    $cd_prestador = $_POST['cd_prestador'];
    $_SESSION['cd_prestador'] = $cd_prestador;
}else{
    $cd_prestador = $_SESSION['cd_pestador'];
    $_SESSION['cd_pestador'] = $cd_prestador;
}

if(isset($_POST['nome'])){
    $nm_prestador = $_POST['nome'];
    $_SESSION['nome'] = $nm_prestador;
}else{
    $nm_prestador = $_SESSION['nome'];
    $_SESSION['nome'] = $nm_prestador;
}

if(isset($_POST['maquina'])){
    $maquina = $_POST['maquina'];
    $_SESSION['maquina'] = $maquina;
}else{
    $maquina = $_SESSION['maquina'];
    $_SESSION['maquina'] = $maquina;
}

?>
<html>
    <head>
        <title>Lista de Espera</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="refresh" content="30">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/agenda.css" rel="stylesheet">
        <link href="css/jquery.datetimepicker.min.css" rel="stylesheet">
        <link href="css/autocomplete.css" rel="stylesheet">
        <link rel="shortcut icon" href="img/ham.png">        
        <script src="js/jquery.js.js"></script>
        <script src="js/tooltip.js"></script>
    </head>
    <body >

        
        <?php
         include './barra.php';
        ?>
        <div id="main" class="container-fluid ">
            <br>

            <div class="col-md-12 " >
                <div style="text-align: center;"><h3 style="font-weight: bold;"><?php echo $_SESSION['nome']; ?></h3></div>
                 <div class="col-md-11 " align="right">
                     <?php
                     require_once './controller/Paciente_Controller.class.php';
                     require_once './servicos/PacienteListIterator.class.php';
                     require_once './beans/Paciente.class.php';
                
                
                    $pc =  new Paciente_Controller();
                    $paciente = new Paciente();
                    $paciente1 = new Paciente();
                    $pacienteList_in =  $pc->lista( $_SESSION['data'], $_SESSION['cd_prestador']);
                    $pacienteList = new PacienteListIterator($pacienteList_in);
                    $pacienteList1 = new PacienteListIterator($pacienteList_in);
                     $media = "";
                    if ($pacienteList1->hasNextPaciente()){
                        $paciente1 = $pacienteList1->getNextPaciente();
                        $media = $paciente1->getMedia();
                }           
                echo "M&Eacute;DIA: ".$media;
                     ?>
                    
                </div>
            </div>
           
            
          <!--  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">-->
                    <div class="row col-md-12 ">
                      
                         
                             <div style="margin: auto 43.4%;">
                                 <div class="form-group formulario  " >
                                        <!-- <label for="data-agenda">Data</label> -->
                                         <input type="text" name="datepicker" id="datepicker" value="<?php echo $data;  ?>" size="10" class="form-control data-agenda"  />
                                 </div>
                             </div>
                         <!--</div>-->
                         <!--<div class="col-md-6"> -->

                          <!--   <div class="botao col-md-6">
                                 <button type="submit" class="btn btn-primary">
                                         <span class="glyphicon glyphicon-search"></span>
                                          Buscar
                                </button>
                            </div>  
                          -->
                         
                       
                     </div>
           <!--  </form>-->
            <div class="row"></div>
            <div class="col-md-3"></div>
            <div class="row col-md-6">
                <div class="mensagem alert " style="text-align: center; position: absolute; margin-left: 32%"></div>
            </div>
            <div class="row"></div>
            <br> <br> <br>
            <div class="col-md-3"></div>

            <div class="tab-content col-md-12 ">
                <div class="table-responsive">
                    <table class="table" >
                          <!-- CABEÇA~LHO DA TABELA -->
                                <thead>
                                <th>Observa&ccedil;&atilde;o</th>
                                <th>Hora da Agenda</th>
                                <th>Paciente</th>
                                <th>Idade</th>
                                <th>Recep&ccedil;&atilde;o</th>
                                <TH>Situa&ccedil;&atilde;o</TH>
                                <th
                                        style="text-align: center;">Espera
                                </th>
                                <th>Previs&atilde;o</th>
                                <th>Status</th>
                                <th></th>

                               </thead>
                               <?php
                               while ($pacienteList->hasNextPaciente()){
                                   $paciente = $pacienteList->getNextPaciente();
                                   $prioridade = $paciente->getPrioridade();
                                   if($paciente->getNum() == "ATENDIDO"){
                                       $num = "<img src='./img/published.png' title='Atendido'>";
                                   }else if ($paciente->getNum() == "EM ATENDIMENTO")
                                   {
                                       $num = "<img src='./img/ESTETOS.png' title='Em atendimento' height=25>";
                                   }
                                   else{
                                       //$num = $paciente->getNum();
                                       if($prioridade == "NORMAL"){
                                           //posicionando o numero dentro da coluna
                                           $num = "<img src='./img/normal.png' height='30'>
                                                        <div style='text-align: center;'><p >   " .$paciente->getNum(). " </p></div>
                                                   </div>";
                                       }elseif($prioridade == "SEM SENHA"){
                                           $num = "<img src='./img/semsenha.png' height='30'>
                                                        <div style='text-align: center;'><p >   " .$paciente->getNum(). " </p></div>
                                                   </div>";
                                       }
                                       elseif($prioridade == "PRIORIDADE"){
                                           $num = "<img src='./img/PRIORIDADE.png' height='30'>
                                                              <div style='text-align: center;'><p >   " .$paciente->getNum(). " </p></div>
                                                         </div>";
                                       }

                                   }
                                   ?>
                                   <tr>
                                       <td align="center"><?php echo $paciente->getObs(); ?></td>
                                       <td align="center"><?php echo $paciente->getHora(); ?></td>
                                       <td><?php echo $paciente->getPaciente(); ?></td>
                                       <td><?php echo $paciente->getIdade(); ?></td>
                                       <td align="center"><?php echo $paciente->getHoraAtendimento(); ?></td>
                                       <td align="center"><?php echo $paciente->getSituacao(); ?></td>
                                       <td align="center"><?php echo $paciente->getEspera(); ?></td>
                                       <td align="center"><?php echo $paciente->getPrevisaoHora(); ?></td>
                                       <td align="center"><a href="#div" onclick="toolTip('<b><?php echo $prioridade; ?></b>', 150, 200)"  onmouseout="toolTip()"><?php echo $num; ?></a></td>
                                       <?php
                                        if($paciente->getSenha() == ''){
                                            $chamada = '';
                                        }else{
                                            $chamada = "<a href='#' data-atendimento='".$paciente->getCodigoAtendimento()."' data-maquina='$maquina' class='btn-chamar'><img src='img/speaker.png' width='30'></a>";
                                        }
                                       ?>
                                       <td align="center"><?php echo $chamada; ?></td>
                                   </tr>
                               <?php 
                                }
                               ?>
                               <tbody>
                               </tbody>    
                            </table>
                    </div>   
            </div>
            
        </div> <!-- /#main -->
        <script src="js/jquery.min.js"></script>
        
        <script type="text/javascript" src="js/jquery.datetimepicker.full.js"></script>
        <script>
            
            $("#datepicker").datetimepicker({
                timepicker: false,
                format: 'd/m/Y',
                
            });
            $.datetimepicker.setLocale('pt-BR');
            
            
        </script>
        

        <script type="text/javascript" src="js/bootstrap.min.js"></script>




        <script type="text/javascript" src="js/func.js"></script>
    </body>
</html>
