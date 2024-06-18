<?php
    include('../core/config.inc.php');
    if(!$_SESSION['usu_id'] || !isset($_SESSION['usu_id'])) redirect(site_url('adm'));
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
        <div class="large-50 cell banner-top">
<!--            <img src="--><?php //echo site_url()?><!--adm/assets/img/banner.jpg">-->
        </div>
        <div class="cell menu-bar show-for-large">
            <div class="grid-x">
                <div class="large-36 menu-main">
                    <nav id="menu">
                        <ul class="menu expanded" style="z-index:999">
                            
                            <li class="sub">
                                <a>
                                    <div class="icon-hover" style="background-image: url('<?= site_url()?>adm/assets/img/cont.png')"></div>
                                    CONTEÚDOS
                                    <i class="fas fa-chevron-down menu-down"></i>
                                </a>
                                <ul class="sub-menu">
                                    <li><a href="<?= site_url('adm/banners')?>">- BANNERS</a></li>                                           
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
                                    <li><a href="<?= site_url('adm/tipos')?>">- TIPOS</a></li>                                                   
                                    <li><a href="<?= site_url('adm/ambientes')?>">-AMBIENTES</a></li>                                                                                                    
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