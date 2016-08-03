<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php

session_start();
if(!isset($_POST['datepicker'])){
                    $data = date('d/m/Y');
                    $_SESSION['data'] = $data;
                }else{
                    $data = $_POST['datepicker'];
                    $_SESSION['data'] = $data;
                }
                
if(isset($_GET['codigo'])){
    $cd_prestador = $_GET['codigo'];
    $_SESSION['codigo'] = $cd_prestador;
}else{
    $cd_prestador = $_SESSION['codigo'];
    $_SESSION['codigo'] = $cd_prestador;
}

if(isset($_GET['nome'])){
    $nm_prestador = $_GET['nome'];
    $_SESSION['nome'] = $nm_prestador;
}else{
    $nm_prestador = $_SESSION['nome'];
    $_SESSION['nome'] = $nm_prestador;
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
        <script>
          function getDate(){
               var dt; 
               var data = new Date();
                var dia = data.getDate();
                if (dia.toString().length == 1)
                  dia = "0"+dia;
                var mes = data.getMonth()+1;
                if (mes.toString().length == 1)
                  mes = "0"+mes;
                var ano = data.getFullYear();  
                 dt = dia+"/"+mes+"/"+ano;
               $("#datepicker").val(dt);
               console.log(dt);
          }
        </script>
    </head>
    <body >
        <!-- Modal -->
<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalLabel">Excluir Item</h4>
            </div>
            <div class="modal-body">Deseja realmente excluir este item? </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Sim</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">N&atilde;o</button>
            </div>
        </div>
    </div>
</div>
        
        <?php
         include './barra.php';
        ?>
        <div id="main" class="container-fluid ">
            <br>
            <div class="col-md-12 ">
                <center><h3 style="font-weight: bold;"><?php echo $_SESSION['nome']; ?></h3></center>
            </div>
            
          <!--  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">-->
                    <div class="row col-md-12 "> 
                      
                         
                             <center> 
                                 <div class="form-group formulario  " >
                                        <!-- <label for="data-agenda">Data</label> -->
                                         <input type="text" name="datepicker" id="datepicker" value="<?php echo $data;  ?>" size="10" class="form-control data-agenda"  />
                                 </div>
                             </center>   
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
                <?php
                require_once './controller/Paciente_Controller.class.php';
                require_once './servicos/PacienteListIterator.class.php';
                require_once './beans/Paciente.class.php';
                
                
                $pc =  new Paciente_Controller();
                $paciente = new Paciente();
                $pacienteList_in =  $pc->lista( $_SESSION['data'], $_SESSION['codigo']);
                $pacienteList = new PacienteListIterator($pacienteList_in);
                
                
                        
                ?>
            <div class="tab-content col-md-12 ">
                <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <th>Observa&ccedil;&atilde;o</th><th>Hora da Agenda</th><th>Paciente</th><th>Idade</th><th>Recep&ccedil;&atilde;o</th><th><center>Espera</center></th><th>Previs&atilde;o</th><th>Status</th>
                               </thead>
                               <?php
                                while ($pacienteList->hasNextPaciente()){
                                    $paciente = $pacienteList->getNextPaciente();
                                    if($paciente->getNum() == "ATENDIDO"){
                                        $num = "<img src='./img/published.png' title='Atendido'>";
                                    }else if ($paciente->getNum() == "EM ATENDIMENTO")
                                    {
                                          $num = "<img src='./img/ESTETOS.png' title='Em atendimento' height=25>";
                                        } 
                                        else{
                                         //$num = $paciente->getNum();
                                      
                                      $num = "<img src=./img/boneco1.png>
                                                 <center><p >   ".$paciente->getNum()." </p></center>
                                            </div>";
                                       
                                   
                                    }
                               ?>
                               <tr>
                                   <td align="center"><?php echo $paciente->getObs(); ?></td>  
                                   <td align="center"><?php echo $paciente->getHora(); ?></td>  
                                   <td><?php echo $paciente->getPaciente(); ?></td>  
                                   <td><?php echo $paciente->getIdade(); ?></td>  
                                   <td align="center"><?php echo $paciente->getHoraAtendimento(); ?></td>
                                   <td align="center"><?php echo $paciente->getEspera(); ?></td>
                                   <td align="center"><?php echo $paciente->getPrevisaoHora(); ?></td>
                                   <td align="center"><?php echo $num; ?></td>  
                                   
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
        
        <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/jquery.mockjax.js"></script>
        <script type="text/javascript" src="js/jquery.autocomplete.js"></script>
        <script type="text/javascript" src="js/countries.js"></script>
        <script type="text/javascript" src="js/demo.js"></script>
    </body>
</html>
