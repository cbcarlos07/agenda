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

$('.btn-prestador').on('click',function () {
	var id   = $(this).data('id');
    var nome = $(this).data('nome');
    var url  = $(this).data('url');
    var form = $('<form action="'+url+'" method="post">'+
				   '<input type="hidden" value="'+id+'" name="codigo" />'+
				   '<input type="hidden" value="'+nome+'" name="nome" />'+
			   '</form>');
    $('body').append(form);
    form.submit();
});


