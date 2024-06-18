<?php
require_once 'core/config.inc.php';
if (first_config()) {
    header("Location: first.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, inital-scale=1.0">
    <title>TR1 - HelpDesk</title>
    <link rel="shortcut icon" href="img/favicon.png" type="image/png">
    <link rel="stylesheet" href="<?php echo site_url() ?>adm/assets/css/foundation.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo site_url() ?>adm/assets/css/core.css">
    <link rel="stylesheet" href="<?php echo site_url() ?>adm/assets/css/login.css">
    <link rel="stylesheet" href="<?php echo site_url() ?>adm/assets/css/jquery.toast.min.css">
    <script src="<?php echo site_url() ?>adm/assets/js/vendor/jquery.js" type="text/javascript"></script>
    <script src="<?php echo site_url() ?>adm/assets/js/jquery.toast.js" type="text/javascript"></script>
</head>
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
            <img src="<?php echo site_url() ?>adm/assets/img/logo_login.png" class="mt-40">
            <div class="row">
                <div class="large-60 font mt-40">
                    HelpDesk - TR1
                </div>
            </div>
            <div class="row bg-bd mt-20">
                <div class="large-60 font mt-15 mb-15">
                    Bem vindo, insira seus dados para continuar
                </div>
            </div>
            <div class="row bg-bd mt-5">
                <div class="large-60 mt-15 mb-5">
                    <div class="row">
                        <div class="large-60">
                            <form method="post" action="core/login.php" enctype="multipart/form-data"
                                  class="form-login align-center">
                                <div class="row mt-5">
                                    <div class="large-60">
                                        <div class="title-input">
                                            Login
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="large-60 align-center">
                                        <input type="text" name="login" required>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="large-60">
                                        <div class="title-input">
                                            Senha:
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="large-60 align-center">
                                        <input type="password" name="senha" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="large-60 align-center">
                                        <input type="submit" value="ENTRAR" class="mt-10" required>
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
</body>
</html>