<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->



<html>
    <head>
        <title>Lista de Espera</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

    <div class="modal fade" id="voltar-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Sair da tela</h4>
                </div>
                <div class="modal-body">
                    <p>Deseja realmente cancelar a opera&ccedil;&atilde;o atual ?</p>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-primary btn-yes">Sim</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">N&atilde;o</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


        <div id="main" class="container ">

            <h3 style="text-align: center">Cadastro de Sala</h3>
            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5" style="margin-left: 355px;">
            <form id="form-sala" method="post" >
                <div class="mensagem alert "></div>
                <div class="panel panel-default" >
                    <div class="panel-body">

                            <input type="hidden" id="id" value="0">
                            <input type="hidden" id="auxiliar" value="0">
                            <input type="hidden" id="acao" value="C">
                            <div class="form-group col-xs-12 col-md-12 col-md-12 col-lg-12">
                                <label for="maquina">M&aacute;quina</label>
                                <input  id="maquina" placeholder="M&aacute;quina" class="form-control" required="">
                            </div>
                            <div class="row"></div>
                            <div class="form-group col-xs-12 col-md-12 col-md-12 col-lg-12">
                                <label for="sala">Consult&oacute;rio / Sala</label>
                                <input  id="sala" placeholder="Consult&oacute;rio / Sala" class="form-control" required="">
                            </div>

                    </div>
                    <div class="panel-footer ">
                        <div style="margin-left: 25%;">
                            <button class="btn btn-success " onclick="salvar()">Salvar</button>
                            <a class="btn btn-default btn-cancelar" >Cancelar</a>
                        </div>
                    </div>
                </div>
            </form>
            </div>



            
        </div> <!-- /#main -->
        <script src="js/jquery.min.js"></script>
        


        <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/sala.js"></script>


    </body>
</html>
