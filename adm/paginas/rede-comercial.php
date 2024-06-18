<?php
    include('../core/config.inc.php');
    if(!$_SESSION['usu_id'] || !isset($_SESSION['usu_id'])) redirect(site_url('adm'));

    if (isset($_POST['id'])) {
        $id = (int) $_POST['id'];

        $endereco1 = mysqli_real_escape_string($dataBase, addslashes($_POST['endereco1']));
        $link1_google_maps = mysqli_real_escape_string($dataBase, $_POST['link1_google_maps']);

        $endereco2 = mysqli_real_escape_string($dataBase, addslashes($_POST['endereco2']));
        $link2_google_maps = mysqli_real_escape_string($dataBase, $_POST['link2_google_maps']);

        $endereco3 = mysqli_real_escape_string($dataBase, addslashes($_POST['endereco3']));
        $link3_google_maps = mysqli_real_escape_string($dataBase, $_POST['link3_google_maps']);

        $endereco4 = mysqli_real_escape_string($dataBase, addslashes($_POST['endereco4']));
        $link4_google_maps = mysqli_real_escape_string($dataBase, $_POST['link4_google_maps']);

        $sql_update = "UPDATE tb_pagina_rede_comercial SET 
                        endereco1 = '$endereco1',
                        link1_google_maps = '$link1_google_maps', 
                        endereco2 = '$endereco2', 
                        link2_google_maps = '$link2_google_maps',
                        endereco3 = '$endereco3',
                        link3_google_maps = '$link3_google_maps',
                        endereco4 = '$endereco4',
                        link4_google_maps = '$link4_google_maps'
                        WHERE id = '$id'";

        if ($dataBase->query($sql_update)){
            toast("Sucesso", "Informações editadas com sucesso",1);
        } else {
            toast("Erro", "Erro ao editar as informações", 0);
        }
    }

?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN | <?= $title_site?></title>
    <link rel="stylesheet" href="<?= site_url()?>adm/assets/css/foundation.css">
    <link rel="stylesheet" href="<?= site_url()?>adm/assets/css/hamburgers.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
          integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= site_url()?>adm/assets/css/app.css">
    <link rel="stylesheet" href="<?= site_url()?>adm/assets/js/menu/jquery.mmenu.all.css">
    <link rel="stylesheet" href="<?= site_url()?>adm/assets/js/menu/extensions/positioning/jquery.mmenu.positioning.css">
    <link rel="stylesheet" href="<?= site_url()?>adm/assets/js/menu/extensions/shadows/jquery.mmenu.shadows.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.foundation.min.css">
    <link rel="stylesheet" href="<?= site_url() ?>adm/assets/css/jquery.toast.min.css">
    <link rel="icon" href="<?= site_url() ?>adm/assets/img/fav.png">
    <script src="<?= site_url()?>adm/assets/js/vendor/jquery.js"></script>
    <script src="<?= site_url()?>adm/assets/js/menu/jquery.mmenu.all.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="<?= site_url() ?>adm/assets/js/jquery.toast.js" type="text/javascript"></script>
    <style>
        .sub-menu li{
            width: 150px;
        }
        .list-img img + img{
            margin-left: 10px;
        }
        textarea {
            resize: none;
        }

        .d-flex { display: flex !important; }

        .align-items-center { align-items: center !important; }
        .justify-content-center { justify-content: center !important; }
        .justify-content-between { justify-content: space-between !important; }
    </style>
</head>
<body>
<div class="grid-container bar-top cell-padding">
    <div class="grid-x">
        <div class="large-5 show-for-medium">
            <a href="<?= site_url('adm')?>"><img src="<?= site_url()?>adm/assets/img/home.png"> Principal</a>
        </div>
        <div class="large-1 text-center div show-for-medium">
            <div></div>
        </div>
        <div class="large-50 small-40" style="padding-left: 15px">
            Cliente: <?= $title_site?>
        </div>
        <div class="large-4 small-20 text-right">
            <a style="color: #444" href="../core/logout.php">SAIR <img src="<?= site_url()?>adm/assets/img/exit.png"></a>
        </div>
    </div>
</div>

<div class="grid-container fluid ">
    <div class="grid-x">
        <div class="cell div-full"></div>
    </div>
</div>

<div class="grid-container main cell-padding">
    <div class="grid-x">
        <div class="large-10 small-30">
            <a href="<?= site_url('adm')?>"><img src="<?= site_url()?>adm/assets/img/tr1.png"></a>
        </div>
        <div class="small-30 text-right show-for-small-only" id="for-mobile">
            <div class="hamburger hamburger--3dx" id="bot-menu">
                <div class="hamburger-box">
                    <div class="hamburger-inner"></div>
                </div>
            </div>
        </div>
        <div class="large-50 cell banner-top"></div>
        <div class="cell menu-bar show-for-large">
            <div class="grid-x">
                <div class="large-36 menu-main">
                    <nav id="menu">
                        <ul class="menu expanded" style="z-index:999">
                            <li>
                                <a>
                                    <div class="icon-hover" style="background-image: url('<?= site_url()?>adm/assets/img/cont.png')"></div>
                                    PÁGINAS
                                    <i class="fas fa-chevron-down menu-down"></i>
                                </a>
                                <ul class="sub-menu">
                                    <li><a href="<?= site_url('adm/paginas/home.php')?>">- HOMEPAGE</a></li>
                                    <li><a href="<?= site_url('adm/paginas/institucional.php')?>">- INSTITUCIONAL</a></li>
                                </ul>
                            </li>
                            <li class="sub">
                                <a>
                                    <div class="icon-hover" style="background-image: url('<?= site_url()?>adm/assets/img/cont.png')"></div>
                                    CONTEÚDOS
                                    <i class="fas fa-chevron-down menu-down"></i>
                                </a>
                                <ul class="sub-menu">
                                    <li><a href="<?= site_url('adm/banners')?>">- BANNERS</a></li>
                                    <li><a href="<?= site_url('adm/feedback-clientes')?>">- FEEDBACK CLIENTES</a></li>                                                   
                                </ul>
                            </li>
                            <li class="sub">
                                <a>
                                    <div class="icon-hover cart" style="background-image: url('http://ambatur.com.br/adm/assets/img/prod.png')"></div>
                                    PRODUTOS
                                    <i class="fas fa-chevron-down menu-down"></i>
                                </a>
                                <ul class="sub-menu">                           
                                    <li><a href="<?= site_url('adm/produtos')?>">- PRODUTOS</a></li>                                                   
                                    <li><a href="<?= site_url('adm/categorias')?>">- CATEGORIAS</a></li>                                                   
                                    <li><a href="<?= site_url('adm/marcas')?>">- MARCAS</a></li>                                                   
                                    <li><a href="<?= site_url('adm/cultivos')?>">- CULTIVOS</a></li>                                                   
                                </ul>
                            </li>
                            <li>
                                <a>
                                    <div class="icon-hover engrenagem" style="background-image: url('<?= site_url()?>adm/assets/img/config.png')"></div>
                                    CONFIGURAÇÃO
                                    <i class="fas fa-chevron-down menu-down"></i>
                                </a>
                                <ul class="sub-menu">
                                    <li><a href="<?= site_url('adm/config/novo.php')?>">- CONFIGURAÇÃO BÁSICA</a></li>
                                </ul>
                            </li>
                            <li style="width: 100%" class="show-for-small-only">
                                <a>
                                    <div class="icon-hover" style="background-image: url('<?= site_url()?>adm/assets/img/user.png')"></div>
                                    USUÁRIOS
                                    <i class="fas fa-chevron-down menu-down"></i>
                                </a>
                                <ul class="sub-menu" style="left: 0;">
                                    <li><a href="<?= site_url('usuarios/novo.php')?>">- NOVO</a></li>
                                    <li><a href="<?= site_url('usuarios/usuarios.php')?>">- LISTA</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="large-offset-14 large-8 text-center menu-main">
                    <ul class="menu">
                        <li style="width: 100%">
                            <a>
                                <div class="icon-hover" style="background-image: url('<?= site_url()?>adm/assets/img/user.png')"></div>
                                USUÁRIOS
                                <i class="fas fa-chevron-down menu-down"></i>
                            </a>
                            <ul class="sub-menu" style="left: 0;">
                                <li><a href="<?= site_url('adm/usuarios/novo.php')?>">- NOVO</a></li>
                                <li><a href="<?= site_url('adm/usuarios/usuarios.php')?>">- LISTA</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="cell back">
            <a href="javascript:void(0)" onclick="window.history.back(-1)"><i class="fas fa-caret-left" style="margin-right: 5px"></i> voltar</a>
        </div>
        <div class="cell div-full" style="padding: 5px 0;"></div>
    </div>
</div>
<?php
    $sql = "SELECT * FROM tb_pagina_rede_comercial WHERE id = 1";
    $query = mysqli_query($dataBase, $sql);
    $row = mysqli_fetch_object($query);
?>
<div class="grid-container pt-25">
    <div class="grid-x">
        <div class="cell">
            <form action="rede-comercial.php" method="post">
                <div class="cell">
                    <?php if($row->id): ?>
                        <input type="hidden" name="id" value="<?= $row->id; ?>">
                    <?php endif; ?>
                </div>
                <div class="grid-x">
                    <div class="cell d-flex align-items-center justify-content-between">
                        <h5>Rede Comercial - Informações</h5>
                        <input type="submit" class="button success" value="Salvar">
                    </div>
                    <div class="cell">
                        <label>Endereço principal
                            <textarea name="endereco1" id="endereco1" rows="3"><?= $row->endereco1; ?></textarea>
                        </label>
                        <label>Link do Google Maps
                            <input type="url" name="link1_google_maps" value="<?= $row->link1_google_maps; ?>" required />
                        </label>
                    </div>
                    <div class="cell text-center">
                        OUTROS ENDEREÇOS
                    </div>
                    <div class="cell">
                        <label>Endereço
                            <textarea name="endereco2" id="endereco2" rows="3"><?= $row->endereco2; ?></textarea>
                        </label>
                        <label>Link do Google Maps
                            <input type="url" name="link2_google_maps" value="<?= $row->link2_google_maps; ?>" />
                        </label>
                        <hr />
                    </div>
                    <div class="cell">
                        <label>Endereço
                            <textarea name="endereco3" id="endereco3" rows="3"><?= $row->endereco3; ?></textarea>
                        </label>
                        <label>Link do Google Maps
                            <input type="url" name="link3_google_maps" value="<?= $row->link3_google_maps; ?>" />
                        </label>
                        <hr />
                    </div>
                    <div class="cell">
                        <label>Endereço
                            <textarea name="endereco4" id="endereco4" rows="3"><?= $row->endereco4; ?></textarea>
                        </label>
                        <label>Link do Google Maps
                            <input type="url" name="link4_google_maps" value="<?= $row->link4_google_maps; ?>" />
                        </label>
                    </div>  
                </div>
            </form>
        </div>
    </div>
</div>

<?php
    include("../base/footer.php")
?>

<script src="<?= site_url() ?>adm/assets/js/ckeditor/ckeditor.js"></script>

<script>
    $(function () {
        CKEDITOR.replace('endereco1');
        CKEDITOR.replace('endereco2');
        CKEDITOR.replace('endereco3');
        CKEDITOR.replace('endereco4');
    });  
</script>