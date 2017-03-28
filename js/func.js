var req;

// FUNÇÃO PARA BUSCA NOTICIA
function buscarNoticias(valor) {

// Verificando Browser
if(window.XMLHttpRequest) {
   req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
   req = new ActiveXObject("Microsoft.XMLHTTP");
}

// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var url = "prestador.php?valor="+valor;

// Chamada do método open para processar a requisição
req.open("Get", url, true);

// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {

	// Exibe a mensagem "Buscando Noticias..." enquanto carrega
	if(req.readyState == 1) {
		document.getElementById('searchlist').innerHTML = 'Buscando Noticias...';
	}

	// Verifica se o Ajax realizou todas as operações corretamente
	if(req.readyState == 4 && req.status == 200) {

	// Resposta retornada pelo busca.php
	var resposta = req.responseText;

	// Abaixo colocamos a(s) resposta(s) na div resultado
	document.getElementById('searchlist').innerHTML = resposta;
	}
}
req.send(null);
}/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*$('.btn-prestador').on('click',function () {
	var id   = $(this).data('id');
    var nome = $(this).data('nome');
    var url  = $(this).data('url');
    var form = $('<form action="'+url+'" method="post">'+
				   '<input type="hidden" value="'+id+'" name="codigo" />'+
				   '<input type="hidden" value="'+nome+'" name="nome" />'+
			   '</form>');
    $('body').append(form);
    form.submit();
});*/

/*

$('.btn-prestador').on('click',function () {
   var id   = $(this).data('id');
   var nome = $(this).data('nome');
   var url  = $(this).data('url');
  // alert(nome);
    $('.btn-01').on('click', function () {
        var valor   = $(this).data('id');
        var form = $('<form action="'+url+'" method="post">'+
            '<input type="hidden" value="'+id+'" name="codigo" />'+
            '<input type="hidden" value="'+nome+'" name="nome" />'+
            '<input type="hidden" value="'+valor+'" name="valor" />'+
            '</form>');
        $('body').append(form);
        form.submit();


    });

 });
*/

var cd_prestador;
var nome;
var salvo;
var consultorio;
var maquina;
$('.btn-prestador').on('click',function () {
   // alert('Prestador');

    var id   = $(this).data('id');
    nome = $(this).data('nome');
    cd_prestador = id;
    $.ajax({
        url         : 'modalprestador.php',
        dataType    : 'json',
        type        : 'post',
        beforeSend  : carregando,
        data        : {
            'prestador'   : id,
            'acao'        : 'B'
        },
        success     : function (data) {
          //   alert(data.maquina);
              console.log("Atende: "+data.atende);
              //alert("Atende: "+data.atende);
            if(data.maquina == ""){ //se ainda não possui setor salvo para o médico
                $('#consultorio-modal').modal();
                $('.lista-consultorio').css('display','block');
                salvo = false;


            }else{
                if(data.atende == true){ //ja comecou a atender? se sim...
                    var form = $('<form action="lista.php" method="post">' +
                                '<input type="hidden" name="cd_prestador" value="'+cd_prestador+'"/>'+
                                '<input type="hidden" name="nome" value="'+nome+'"/>'+
                                '<input type="hidden" name="maquina" value="'+data.maquina+'"/>'+
                                '<input type="hidden" name="sala" value="'+data.valor+'"/>'+
                                '</form>');

                    $('body').append(form);
                    form.submit();

                }else{
                    $('#consultorio-modal').modal('show');
                    consultorio = data.valor;
                    $('span.nome').text(data.valor);
                    $('.consultorio').css('display','block');
                    $('.modal-footer').css('display','block');
                    salvo = true;
                    consultorio = data.valor;
                    //alert('Maquina: '+data.maquina);
                    maquina = data.maquina;
                }

            }
        }
    });




});

// alert(nome);
function escolherConsultrio(maquina, sala) {
            //alert('Consultorio: '+sala);
            //  alert('Salvar');
            $.ajax({
                url         : 'modalprestador.php',
                dataType    : 'json',
                type        : 'post',
                data        : {
                    'prestador'   : cd_prestador,
                    'maquina'     : maquina,
                    'consultorio' : sala,
                    'acao'        : 'C'
                },
                success     : function (data) {
                   // alert('Retorno escolher: '+data.retorno);
                    if(data.retorno == 1){ //se ainda não possui setor salvo para o médico
                        console.log('Salvo com sucesso!');
                        //  alert('Salvo com sucesso')
                        var form = $('<form action="lista.php" method="post">'+
                            '<input type="hidden" value="'+cd_prestador+'" name="cd_prestador" />'+
                            '<input type="hidden" value="'+nome+'" name="nome" />'+
                            '<input type="hidden" value="'+maquina+'" name="maquina" />'+
                            '<input type="hidden" value="'+sala+'" name="sala" />'+
                            '</form>');
                        $('body').append(form);
                        form.submit();

                    }else{
                        //   alert('Nao salvou');
                        console.log('Não salvou');
                    }
                }
            });
      //  }





    }


function changePlace(maquina, cd_prestador) {
   var sala  = "";
   var reload = 0;
    $.ajax({
        url         : 'modalprestador.php',
        dataType    : 'json',
        type        : 'post',
        data        : {
            'prestador'   : cd_prestador,
            'maquina'     : maquina,
            'acao'        : 'C'
        },
        success     : function (data) {
             //alert('Retorno escolher: '+data.retorno);
           // reload = data.retorno;
            if(data.retorno == 1){ //se ainda não possui setor salvo para o médico
                console.log('Salvo com sucesso!');
                //  alert('Salvo com sucesso')
                sala = data.valor;
                var form = $('<form action="lista.php" method="post">'+
                    '<input type="hidden" value="'+maquina+'" name="maquina" />'+
                    '<input type="hidden" value="'+sala+'" name="sala" />'+
                    '</form>');
                $('body').append(form);
                form.submit();

            }else{
                //   alert('Nao salvou');
                console.log('Não salvou');
            }
        }
    });
    //  }







}




function clicar(id, nome, url) {
    //alert('Alert: '+id);
    var form = $('<form action="'+url+'" method="post">'+
        '<input type="hidden" value="'+id+'" name="codigo" />'+
        '<input type="hidden" value="'+nome+'" name="nome" />'+
        '</form>');
    $('body').append(form);
    form.submit();
};

$('.btn-chamar').on('click', function () {
    var atendimento = $(this).data('atendimento');
    var maquina     = $(this).data('maquina');
    $.ajax({
       url         : 'chamar.php',
       dataType    : 'json',
       type        : 'post',
       beforeSend  : carregando,
       data        : {
           'maquina'     : maquina,
           'atendimento' : atendimento
       },
       success     : function (data) {
            if(data.retorno == 1){
                sucess('Chamada efetuada com sucesso!');
            }else{
                errosend('N&atilde;o foi poss&iacute;vel chamar paciente')
            }
       }
    });
});

function carregando(){
    var mensagem = $('.mensagem');
    //alert('Carregando: '+mensagem);
    mensagem.empty().html('<span class="alert alert-warning"><img src="img/loading.gif" alt="Carregando..."> Verificando dados!</span>').fadeIn("fast");


}


function sucess(msg){
    //alert("Mensagem: "+msg);
    var mensagem = $('.mensagem');
    mensagem.empty().html('<span class="alert alert-success"><strong>OK. </strong>'+msg+'</span>').fadeIn("fast");
    setTimeout(function (){
        location.reload();
    },2000);
}


function errosend(msg){
    var mensagem = $('.mensagem');
    mensagem.empty().html('<span class="alert alert-danger">'+msg+'</span>').fadeIn("fast");
}


$('.btn-yes').on('click', function () {
    //alert("Prestador: "+cd_prestador);

    var form = $('<form action="lista.php" method="post">'+
        '<input type="hidden" value="'+cd_prestador+'" name="cd_prestador" />'+
        '<input type="hidden" value="'+nome+'" name="nome" />'+
        '<input type="hidden" value="'+maquina+'" name="maquina" />'+
        '<input type="hidden" value="'+consultorio+'" name="sala" />'+
        '</form>');
    $('body').append(form);
    form.submit();
});

$('.btn-nao').on('click', function () {
    //$('.consultorio').css('display','none');
    $('.consultorio').fadeOut('3000');
    $('.modal-footer').fadeOut('3000');
    $('.lista-consultorio').fadeIn('3000');
});

$('.btn-alterar').on('click', function () {
   var sala = $(this).data('consultorio');

   $('span.nome').text(sala);
});



