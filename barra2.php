

<nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="adm.php">Lista de Sala</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#" data-acao="S" class="btn-sair">Sair</a></li>

                    </ul>
                </div>
            </div>
        </nav>

<script>
    $('.btn-sair').on('click', function () {

       var form = $('<form action="usuario.php" method="post">' +
                    '<input type="hidden" value="S" name="acao"> ' +
                    '</form>');
       $('body').append(form);
       form.submit();
    });
</script>
