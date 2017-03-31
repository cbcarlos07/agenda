<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();
include "timezone.php";
?>
<html>
<head>
    <title>Lista de Espera</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="refresh" content="30">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/agenda.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/jquery.datetimepicker.min.css" rel="stylesheet">
    <link href="css/autocomplete.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/ham.png">
    <script src="js/jquery.js"></script>
    <script src="js/busca.js"></script>
</head>
<body>


<?php
include 'barra.php';
?>




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


<!-- Modal -->
<div class="modal fade" id="consultorio-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalLabel">Em qual consult&oacute;rio est&aacute; o m&eacute;dico?</h4>
            </div>
            <div class="modal-body">
                <div class="consultorio" style="display: none">
                    O m&eacute;dico est&aacute; no consult&oacute;rio <b><span class="nome"></span></b>?
                </div>

                <div class="lista-consultorio" style="display: none;">
                    <div >
                        <?php
                          include "beans/Sala.class.php";
                          include "controller/Sala_Controller.class.php";
                          include "controller/Prestador_Controller.class.php";
                          include "servicos/SalaListIterator.class.php";
                          $sala = new Sala();

                          $salaController = new Sala_Controller();
                          $prestaddorController = new Prestador_Controller();
                          $lista = $salaController->getListaSala("");
                          $salaListIterator = new SalaListIterator($lista);
                          while($salaListIterator->hasNextSala()){
                              $sala = $salaListIterator->getNextSala();
                              $ind = $prestaddorController->consultorioLivre($sala->getDsMaquina());
                              $linha = "btn-success";
                              $ocupado = "";
                              if($ind > 0){
                                  $linha = "btn-danger";
                                  $ocupado = "(ocupado)";
                              }

                          ?>
                              <a href="#"
                                 data-toggle="modal"
                                 data-target="#consultorio-modal"
                                 class="btn <?php echo $linha; ?> btn-block btn-01"
                                 role="button" aria-pressed="true"
                                 onclick="escolherConsultrio('<?php echo $sala->getDsMaquina(); ?>','<?php echo $sala->getDsConsultorio(); ?>')"
                              >
                                  <span><?php echo $sala->getDsConsultorio()." ".$ocupado; ?></span>
                              </a>
                        <?php
                          }
                        ?>


                    </div>
                </div>
                <div class="modal-footer" style="display: none">
                    <a href="#" type="button"  class="btn btn-primary btn-yes">Sim</a>
                    <button type="button" class="btn btn-default btn-nao" >N&atilde;o</button>
                </div>
            </div>
        </div>
    </div>
</div>

    <div id="main" class="container-fluid">

        <div style="text-align: center;"><h2 class="btn btn-primary btn-block titulo">LISTA DE PRESTADORES</h2>    </div>


        <!-- Validation -->
        <div class="form-group col-lg-12">
            <div class="form-group has-feedback">

                <input type="text" class="form-control" id="busca" onkeyUp="carregar()" placeholder="Pesquisar M&eacute;dico"/>
                <span class="glyphicon glyphicon-search form-control-feedback"></span>
            </div>


        </div>
        <div row>
            <div class="card card-block" >
                <div class="list-group medicos" id="searchlist">
                    <?php
                    require_once './controller/Prestador_Controller.class.php';
                    require_once './beans/Prestadores.class.php';
                    require_once './servicos/PrestadorListIterator.class.php';
                    $p = new Prestador_Controller();
                    $prestadorList_in = $p->lista('%');
                    $pLista = new PrestadoresListIterator($prestadorList_in);
                    $prest =  new Prestadores();
                    while ($pLista->hasNextPrestadores()){
                        $prest = $pLista->getNextPrestadores();
                        ?>
                        <div class="col-xs-12 col-sm-4 col-lg-3">
                            <div  class="list-group">

                                <a href="#" data-url="lista.php"
                                   data-toggle="modal"
                                   data-id="<?php echo $prest->getId(); ?>"
                                   data-nome="<?php echo $prest->getNome(); ?>"
                                   class="btn btn-default list-group-item btn-prestador"
                                   role="button" aria-pressed="true"
                                >
                                    <span><?php echo $prest->getNome(); ?></span>
                                </a>

                            </div>
                        </div>


                        <?php
                    }
                    ?>



                </div>
            </div>
        </div>

    </div> <!-- /#main -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.datetimepicker.full.js"></script>
    <script>

        $("#datepicker").datetimepicker({
            timepicker: false,
            format: 'd/m/Y',

        });
        $.datetimepicker.setLocale('pt-BR');


    </script>
    <script>
        function medico(id){




            // **************************************************
            var form = "#"+id;
            console.log("Log: "+form);
            $(id).submit();
            //alert('Tes '+form);
        }

    </script>


    <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/func.js"></script>
    <script type="text/javascript" src="js/acaologin.js"></script>
</body>
</html>
