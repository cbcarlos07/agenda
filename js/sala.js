/**
 * Created by carlos.bruno on 27/03/2017.
 */
$('.novo-item').on('click',function () {
     location.href = 'salacad.php';
});

function salvar() {
    //alert('Salvar');
    jQuery('#form-sala').submit(function () {
      //  alert('Submit');
        var acao     = document.getElementById('acao').value;
        var id       = document.getElementById('id').value;
        var maquina  = document.getElementById('maquina').value;
        var auxiliar = document.getElementById('auxiliar').value;
        var sala     = document.getElementById('sala').value;
     //   alert(auxiliar);
        $.ajax({
           dataType   : 'json',
           type       : 'post',
           beforeSend : carregando,
           error      : errosend,
           url        : 'sala.php',
           data       : {
               acao     : acao,
               maquina  : maquina,
               sala     : sala,
               auxiliar : auxiliar,
               id      : id
           },
           success     : function (result) {
            //   alert('Retorno: '+result.retorno);
               if(result.retorno == 1){
                    sucesso('Opera&ccedil;&atilde;o realizada com sucesso!');
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
    mensagem.empty().html('<p class="alert alert-danger"><strong>Opa!</strong> Ocorreu um erro ao tentar alterar</p>').fadeIn("fast");
}

function erroRestricao(){
    var mensagem = $('.mensagem');
    mensagem.empty().html('<p class="alert alert-danger"><strong>Restrito!</strong> Voc&ecirc; n&atilde;o tem permiss&atilde;o para acessar esse sistema </p>').fadeIn("fast");
}

function sucesso(msg){
    var mensagem = $('.mensagem');
    mensagem.empty().html('<p class="alert alert-success"><strong>OK.</strong> '+msg+' </p>').fadeIn("fast");
    setTimeout(function (){
        location.href = "adm.php"
    },1500);
    //window.setTimeout()
    //delay(2000);
}

$('#search').on('keyup',function () {
    var pesquisa = document.getElementById('search').value;
    var corpo = $('#table');
    $.ajax({
        type    : 'post',
        url     : 'sala.php',
        data    : {
            acao    : 'P',
            maquina : pesquisa
        },
        success : function (data) {
            corpo.find("tr").remove();
            corpo.append(data);
            var mensagem = $('.mensagem');
            mensagem.empty().html('<p></p>');
        }
    });


});


$('.btn-cancelar').on('click', function () {
    //  alert('Cancelar');
      $('#voltar-modal').modal('show');
    $('.btn-yes').on('click', function () {
       location.href = 'adm.php'
    });
});

$('.btn-acao').on('click',function () {
   var id   = $(this).data('id');
   var acao = $(this).data('acao');

   if(acao == 'A'){
    var form = $('<form action="salaalt.php" method="post">' +
                '<input type="hidden" name="id" value="'+id+'">'+
                '</form>');
    $('body').append(form);
    form.submit();
   }else{
     $('#excluir-modal').modal('show');
     var maquina = $(this).data('maquina');
     $('span.maquina').text(maquina);
     $('.btn-yes').on('click', function () {
         //alert('Sim');
         $.ajax({
             dataType   : 'json',
             type       : 'post',
             url        : 'sala.php',
             data       : {
                 id      : id,
                 maquina : maquina,
                 acao   : 'E'

             },
             success    : function (data) {
                 if(data.retorno == 1){
                     $('#excluir-modal').modal('hide');
                     sucesso('Item exclu&iacute;do com sucesso!');


                 }
             }
         });
     })

   }
});