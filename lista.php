<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
 session_start();
include "timezone.php";

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
    $cd_prestador = $_SESSION['cd_prestador'];
    $_SESSION['cd_prestador'] = $cd_prestador;
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

if(isset($_POST['sala'])){
    $sala = $_POST['sala'];
    $_SESSION['sala'] = $sala;
}else{
    $sala = $_SESSION['sala'];
    $_SESSION['sala'] = $sala;
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
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/agenda.css" rel="stylesheet">
        <link href="css/jquery.datetimepicker.min.css" rel="stylesheet">
        <link href="css/autocomplete.css" rel="stylesheet">
        <link href="css/login.css" rel="stylesheet">
        <link rel="shortcut icon" href="img/ham.png">        
        <script src="js/jquery.js"></script>
        <script src="js/tooltip.js"></script>
    </head>
    <body >

    <!-- Modal -->
    <div class="modal fade" id="consultorio-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalLabel">Alterar do consult&oacute;rio <b><span  class="nome"></span></b> para:</h4>
                </div>
                <div class="modal-body">


                    <div class="lista-consultorio" >
                        <div >
                            <?php
                            include "beans/Sala.class.php";
                            include "controller/Sala_Controller.class.php";
                            include "servicos/SalaListIterator.class.php";
                            include "controller/Prestador_Controller.class.php";
                            $room = new Sala();
                            $prestaddorController = new Prestador_Controller();
                            $salaController = new Sala_Controller();
                            $lista = $salaController->getListaSala("");
                            $salaListIterator = new SalaListIterator($lista);
                            while($salaListIterator->hasNextSala()){
                                $room = $salaListIterator->getNextSala();
                                $ind = $prestaddorController->consultorioLivre($room->getDsMaquina());
                                $linha = "btn-success";
                                $ocupado = "";
                                if($ind > 0){
                                    $linha = "btn-danger";
                                    $ocupado = "(ocupado)";
                                }
                                ?>
                                <a href="#"
                                   class="btn <?php echo $linha; ?> btn-block btn-01"
                                   role="button" aria-pressed="true"
                                   onclick="changePlace('<?php echo $room->getDsMaquina(); ?>',<?php echo $cd_prestador; ?>)"
                                >
                                    <span><?php echo $room->getDsConsultorio()." ".$ocupado; ?></span>
                                </a>
                                <?php
                            }
                            ?>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href=".">Lista de Espera de Paciente</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#"
                           data-toggle="modal"
                           data-target="#login-modal">Gerenciar</a>
                    </li>

                    <li class="active dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $sala; ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#" data-consultorio="<?php echo $sala; ?>"
                                   data-toggle="modal"
                                   data-target="#consultorio-modal"
                                   class="btn-alterar"
                                >
                                    <span class="glyphicon glyphicon-wrench"></span> Alterar consult&oacute;rio
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </nav>


    <!-- Modal -->
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog" role="document">
            <form id="login-form" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modalLabel">Fa&ccedil;a login para gerenciar</h4>
                    </div>
                    <div class="modal-body">
                        <div class="mensagem">
                            <p class="alert"></p>
                        </div>

                        <div class="form-group">
                            <div class="iconInput">
                                <i class="glyphicon glyphicon-user"></i>
                                <input type="text" class="form-control" placeholder="Login" id="login" onblur="buscar()"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="iconInput">
                                <i class="glyphicon glyphicon-lock"></i>
                                <input type="password" class="form-control" placeholder="Senha" id="senha" />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="iconInput">
                                <i class="glyphicon glyphicon-briefcase"></i>
                                <input type="text" class="form-control" placeholder="Empresa" id="empresa" required=""/>
                            </div>
                        </div>



                    </div>
                    <div class="modal-footer" >
                        <button type="submit"  class="btn btn-primary btn-block btn-logar" onclick="logar()">Logar</button>

                    </div>
                </div>
            </form>
        </div>
    </div>


        <div id="main" class="container-fluid ">
            <br>

            <div class="col-md-12 " >
                <div style="text-align: center;"><h3 style="font-weight: bold;"><?php echo $nm_prestador; ?></h3></div>
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
                               $ordem = 0;
                               while ($pacienteList->hasNextPaciente()){
                                   $paciente = $pacienteList->getNextPaciente();
                                   $prioridade = $paciente->getPrioridade();
                                    $maiorAtdMedico = $paciente->getPrevisaoHora();




                                   $nrchamda = "<b>".$pc->getNrChamada($paciente->getCodigoAtendimento())."</b>";
                                   $nrchamda1 = $pc->getNrChamada($paciente->getCodigoAtendimento());

                                   if($paciente->getNum() == "ATENDIDO"){
                                       $num = "<img src='./img/published.png' title='Atendido'>";
                                       $previsao = "";

                                   }else if ($paciente->getNum() == "EM ATENDIMENTO")
                                   {
                                       $num = "<img src='./img/ESTETOS.png' title='Em atendimento' height=25>";
                                       $previsao = "";
                                   }
                                   else{

                                       //$num = $paciente->getNum();
                                       if($prioridade == "NORMAL"){
                                           //posicionando o numero dentro da coluna
                                           $num = "<img src='./img/normal.png' height='30'>
                                                        <div style='text-align: center;'><p >   " .$ordem. " </p></div>
                                                ";
                                       }elseif($prioridade == "SEM SENHA"){
                                           $num = "<img src='./img/semsenha.png' height='30'>
                                                        <div style='text-align: center;'><p >   " .$ordem. " </p></div>
                                                   ";
                                       }
                                       elseif($prioridade == "PRIORIDADE"){
                                           $num = "<img src='./img/PRIORIDADE.png' height='30'>
                                                              <div style='text-align: center;'><p >   " .$ordem. " </p></div>
                                                         ";
                                       }
                                       $ordem++;
                                       $previsao = getPrevisao($paciente->getMediaFloat(), $maiorAtdMedico, $ordem);
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
                                       <td align="center"><?php echo $previsao; ?></td>
                                       <td align="center"><a href="#div" onclick="toolTip('<b><?php echo $prioridade; ?></b>', 150, 200)"  onmouseout="toolTip()"><?php echo $num; ?></a></td>
                                       <?php
                                        if($paciente->getSenha() == ''){
                                            $chamada = '';
                                        }else{

                                            $chamada = "<a href='#' data-chamada='".$nrchamda1."' data-atendimento='".$paciente->getCodigoAtendimento()."' data-maquina='$maquina' class='btn-chamar'>
                                                            <img src='img/speaker.png' width='30'>
                                                         </a>";

                                        }
                                       ?>
                                       <td align="center"><?php echo $chamada." ".$nrchamda; ?></td>
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
        <script type="text/javascript" src="js/acaologin.js"></script>
    </body>
</html>

<?php
function getPrevisao($media, $maior, $ordem){
     //previsao +( media * 1) = previsaonova
    //$previsao = $maior + ($media * $ordem);
    $dateTime = DateTime::createFromFormat('d/m/Y H:i:s', $maior, new DateTimeZone('America/Manaus'));
    $media = "0".str_replace(",",".",$media);
    $maiorTimeStamp = $timestamp = $dateTime->getTimestamp();

    return date("H:i:s", $maiorTimeStamp +(( (24*3600) * $media)* $ordem));
  //  return $media;
}
?>
