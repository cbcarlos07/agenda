/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var mensagem = $('.mensagem');

function logar(){
       // alert('logar');

        jQuery('#login-form').submit(function(){
       //     alert('Submit');
            //var dados = jQuery( this ).serialize();
            var usuario = document.getElementById("login").value;
            var senha = document.getElementById("senha").value;

            //var cracha = $('#cracha').value;
            //alert("Usuario: "+usuario+" Senha: "+senha);
            //console.log("Usuario: "+usuario+" Senha: "+senha);
            $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: "usuario.php",
                    beforeSend: carregando,
                    data: {
                        'usuario' : usuario,
                        'senha'   : senha,
                        'acao'     : 'L'
                    },
                    success: function( data )
                    {
                        //var retorno = data.retorno;
                       // alert(data.retorno);

                        console.log("Data: "+data.retorno);
                        if(data.retorno == 1){
                            sucesso();
                          }
                        else if(data.retorno == 2){
                            erroRestricao();
                        }
                        else{
                            errosend();
                            $('input[name="senha"]').css("border-color","red").focus();
                            $('input[name="loginname"]').css("border-color","red").focus();
                       }
                    }
            });

        return false;
        });
    }
    
    

function carregando(){
        var mensagem = $('.mensagem');
        //alert('Carregando: '+mensagem);
        mensagem.empty().html('<p class="alert alert-warning"><img src="img/loading.gif" alt="Carregando..."> Verificando dados!</p>').fadeIn("fast");
        setTimeout(function (){
            
        },300);
        
  }

function errosend(){
        var mensagem = $('.mensagem');
        mensagem.empty().html('<p class="alert alert-danger"><strong>Opa!</strong> Por favor, verifique seu login e/ou sua senha</p>').fadeIn("fast");
}

function erroRestricao(){
    var mensagem = $('.mensagem');
    mensagem.empty().html('<p class="alert alert-danger"><strong>Restrito!</strong> Voc&ecirc; n&atilde;o tem permiss&atilde;o para acessar esse sistema </p>').fadeIn("fast");
}

function sucesso(msg){
        var mensagem = $('.mensagem');
        mensagem.empty().html('<p class="alert alert-success"><strong>OK.</strong> Estamos redirecionando <img src="img/loading.gif" alt="Carregando..."></p>').fadeIn("fast");                
        setTimeout(function (){
            location.href = "adm.php"
        },1500);
        //window.setTimeout()
        //delay(2000);
}

function buscar(){
    //alert('Buscar');
    var usuario = document.getElementById("login").value;
    jQuery.post( 'usuario.php', {'usuario': usuario, 'acao' : 'E'}, function(data) {
        //alert( 'response: ' + data.response );
        $('input[name="loginname"]').css("border-color","none");
        var x = document.getElementById("empresa");
        //alert(data.response);
        console.log(data.response);
        //console.log(data.nome);
        x.value = data.response;


    },'json');
}