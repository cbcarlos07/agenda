<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
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
       
        <link rel="shortcut icon" href="img/ham.png">        
        <script src="js/jquery.js.js"></script>
        <script src="js/busca.js"></script>
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
        
        <?php
         include 'barra.php';
        ?>
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
                                
                                <A href="#" data-url="lista.php"
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
                var form = "#"+id;
                console.log("Log: "+form);
               $(id).submit();
               //alert('Tes '+form);
            }
         
        </script>
        
       
        <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.mockjax.js"></script>
        <script type="text/javascript" src="js/jquery.autocomplete.js"></script>
        <script type="text/javascript" src="js/countries.js"></script>
        <script type="text/javascript" src="js/demo.js"></script>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        
        <script type="text/javascript" src="js/func.js"></script>
    </body>
</html>
