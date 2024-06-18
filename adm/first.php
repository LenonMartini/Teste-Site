<?php
require_once 'core/config.inc.php';

$url = (str_replace('adm/first.php','',"http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"));
if (!first_config()) redirect('login.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, inital-scale=1.0">
    <title>TR1 - HelpDesk</title>
    <link rel="shortcut icon" href="img/favicon.png" type="image/png">
    <link rel="stylesheet" href="assets/css/foundation.min.css">
    <link rel="stylesheet" href="assets/css/core.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/jquery.toast.min.css">
    <script src="assets/js/vendor/jquery.js" type="text/javascript"></script>
    <script src="assets/js/jquery.toast.js" type="text/javascript"></script>
</head>
<style>
    label {
        display: block;
        /*width: 100%;*/
    }

    .form-login input[type=text] {
        width: 100%;
        padding: 10px
    }
</style>
<body>
<script>
    $(function () {
        <?php
        if(flash_data('erro_login')){
        ?>
        $.toast({
            heading: 'Erro',
            text: 'Credenciais inválidas',
            icon: 'error',
            position: 'top-right'
        });
        <?php
        }
        ?>
    });
</script>
<div class="grid-container">
    <div class="grid-x">

        <div class="large-14 align-center">
            &nbsp;
        </div>
        <div class="large-32 align-center">
            <img src="assets/img/logo_login.png" class="mt-40">
            <div class="row">
                <div class="large-60 font mt-40">
                    Primeira configuração
                </div>
            </div>
            <div class="row bg-bd mt-20">
                <div class="large-60 font mt-15 mb-15">
                    Bem vindo, insira os dados para configurar o adm
                </div>
            </div>
            <div class="row bg-bd mt-5">
                <div class="large-60 mt-15 mb-5" style="padding: 0 20px;">
                    <div class="row">
                        <div class="large-60">
                            <form method="post" action="core/init.php" enctype="multipart/form-data"
                                  class="form-login text-left">
                                <input type="hidden" value="<?php echo realpath(getcwd()."/../")."/"?>" name="path">
                                <input type="hidden" value="<?php echo $url?>" name="url">
                                <div class="row">
                                    <div class="large-60 text-left">
                                        <label>Titulo do site
                                            <input type="text" name="titulo" required placeholder="Agrobona">
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="large-60 text-left">
                                        <label>Servidor do banco
                                            <input type="text" name="banco_host" required value="localhost">
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="large-60 text-left">
                                        <label>Nome do banco
                                            <input type="text" name="banco_nome" required>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="large-60 text-left">
                                        <label>Usuário do banco
                                            <input type="text" name="banco_usuario" required>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="large-60 text-left">
                                        <label>Senha do banco
                                            <input type="text" name="banco_senha" >
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="large-60 text-left">
                                        <label>Usuário do site
                                            <input type="text" name="site_user" >
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="large-60 text-left">
                                        <label>Senha do site
                                            <input type="text" name="site_senha" >
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="large-60 text-center">
                                        <input type="submit" value="SALVAR" class="mt-10" required>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="large-14 align-center">
            &nbsp;
        </div>
    </div>
</div>
<script>
    $(function () {
        $(".form-login").submit(function (event) {
            event.preventDefault();
            var $form = $(this),
                term = $form.serialize(),
                url = $form.attr("action");
            var posting = $.post(url, term);
            posting.done(function (data) {
                if(data.result){
                    window.location.href = 'login.php';
                }
                else{
                    $.toast({
                        heading: 'Erro',
                        text: data.text,
                        icon: 'error',
                        position: 'top-right'
                    });
                }
            });
        });
    });
</script>
</body>
</html>
