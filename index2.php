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
        <link href="css/style.css" rel="stylesheet">
        <link href="css/agenda.css" rel="stylesheet">
        <link href="css/jquery.datetimepicker.min.css" rel="stylesheet">
        <link href="css/autocomplete.css" rel="stylesheet">
        <link rel="shortcut icon" href="img/ham.png">        
        <script src="js/jquery.js.js"></script>
    </head>
    <body>
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
        
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Lista de Espera de Paciente</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#">Início</a></li>
                        <li><a href="#">Opções</a></li>
                        <li><a href="#">Perfil</a></li>
                        <li><a href="#">Ajuda</a></li>                        
                    </ul>
                </div>
            </div>
        </nav>
        <div id="main" class="container-fluid">
            <div class="row col-md-3 ">
                <div class="row form">
                    <form>
                        <div class="form-group">
                            <label for="data-agenda">Data</label>
                            <input type="text" id="datepicker"  size="10" class="form-control data-agenda" />
                        </div>
                        
                        
                        <hr />
                        
                        <div class="form-group">
                            <label for="data-agenda">Prestador</label>
                            
                            <input type="text" name="country" id="autocomplete"  size="10" class="form-control" />
                            <div id="selection"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                
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
        
        <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.mockjax.js"></script>
        <script type="text/javascript" src="js/jquery.autocomplete.js"></script>
        <script type="text/javascript" src="js/countries.js"></script>
        <script type="text/javascript" src="js/demo.js"></script>
    </body>
</html>
