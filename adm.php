<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->


<?php
session_start();
$valor = isset($_SESSION['usuario']) ? 'S' : 'N';
if($valor == 'N'){
    header('location: .');
}
echo "Sesssao: ".$valor;
include "beans/Sala.class.php";
include "controller/Sala_Controller.class.php";
include "servicos/SalaListIterator.class.php";


$sala =  new Sala();
$salaController = new Sala_Controller();
$lista = $salaController->getListaSala('');
$salaListIterator = new SalaListIterator($lista);
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
        <link rel="shortcut icon" href="img/ham.png">
        <script src="js/jquery.js"></script>
        <script src="js/tooltip.js"></script>
    </head>
    <body >
    <?php include "barra2.php"; ?>

    <div class="modal fade" id="excluir-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Excluir</h4>
                </div>
                <div class="modal-body">
                    <p>Deseja relamente excluir <b><span class="maquina"></span></b> ?</p>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-primary btn-yes">Sim</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">N&atilde;o</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


        <div id="main" class="container ">
            <div class=" col-xs-12 col-sm-3 col-md-3 col-lg-3" ><h3 class="h3">Cadastro de M&aacute;quina</h3></div>
            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5" >

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="form-pesquisa">
                    <input type="hidden" name="acao" value="P">
                    <div class="input-group h2">
                        <input  name="search"  id="search" class="form-control">
                        <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit" >
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                          </span>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <a href="#" data-url="salacad.php" class="btn btn-primary novo-item" style="margin-top: 15px;">Novo Item</a>
            </div>
            <div class="row"></div>



            <div class="table">
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <div class="mensagem alert "></div>
                </div>
                <div class="col-lg-4"></div>
                <table class="table table-responsive table-hover">
                    <thead>
                      <th>#</th>
                      <th>M&aacute;quina</th>
                      <th>Consult&oacute;rio</th>
                      <th></th>
                    </thead>
                    <tbody id="table">
                      <?php
                          while ($salaListIterator->hasNextSala()) {
                              $sala = $salaListIterator->getNextSala();

                              ?>
                              <tr>
                                  <td><?php echo $sala->getCdSala(); ?></td>
                                  <td><?php echo $sala->getDsMaquina(); ?></td>
                                  <td><?php echo $sala->getDsConsultorio(); ?></td>
                                  <td class="actions">
                                        <a href="#" data-id="<?php echo $sala->getCdSala(); ?>"  data-acao="A" class="btn btn-success btn-acao">Alterar</a>
                                        <a href="#" data-id="<?php echo $sala->getCdSala(); ?>" data-maquina="<?php echo $sala->getDsMaquina(); ?>"data-acao="E" class="btn btn-danger btn-acao">Excluir</a>
                                  </td>
                              </tr>
                              <?php
                          }
                    ?>
                    </tbody>
                </table>
            </div>

            
        </div> <!-- /#main -->
        <script src="js/jquery.min.js"></script>
        


        <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/sala.js"></script>


    </body>
</html>
