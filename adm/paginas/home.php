<?php
    include('../core/config.inc.php');
    if(!$_SESSION['usu_id'] || !isset($_SESSION['usu_id'])) redirect(site_url('adm'));

    if (isset($_POST['id'])) {
        $id = (int) $_POST['id'];

        $descricao_quem_somos = mysqli_real_escape_string($dataBase, addslashes($_POST['descricao_quem_somos']));
        $descricao_biofabrica = mysqli_real_escape_string($dataBase, addslashes($_POST['descricao_biofabrica']));
        $descricao_missao = mysqli_real_escape_string($dataBase, addslashes($_POST['descricao_missao']));
        $descricao_visao = mysqli_real_escape_string($dataBase, addslashes($_POST['descricao_visao']));
        $descricao_valores = mysqli_real_escape_string($dataBase, addslashes($_POST['descricao_valores']));

        $foto_antiga = isset($_POST['foto_antiga']) ? $_POST['foto_antiga'] : ''; 
        $biofabrica_foto_fundo_antiga = isset($_POST['biofabrica_foto_fundo_antiga']) ? $_POST['biofabrica_foto_fundo_antiga'] : ''; 
        
        $foto = isset($_FILES['foto']) && $_FILES['foto']['error'] != 4 ? salvar_imagem_no_disco($_FILES['foto'], 'pagina') : $foto_antiga;
        $biofabrica_foto_fundo = isset($_FILES['biofabrica_foto_fundo']) && $_FILES['biofabrica_foto_fundo']['error'] != 4 ? salvar_imagem_no_disco($_FILES['biofabrica_foto_fundo'], 'pagina') : $biofabrica_foto_fundo_antiga;


        $sql_update = "UPDATE tb_pagina_home SET 
                        foto_quem_somos = '$foto',
                        biofabrica_foto_fundo = '$biofabrica_foto_fundo',
                        descricao_quem_somos = '$descricao_quem_somos', 
                        descricao_biofabrica = '$descricao_biofabrica', 
                        descricao_missao = '$descricao_missao',
                        descricao_visao = '$descricao_visao',
                        descricao_valores = '$descricao_valores'
                        WHERE id = $id";

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
        .card-imagem {
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            position: relative; 
            max-width: 25%; 
            width: 100%;
            padding: 0.5rem 0rem;
        }

        .card-imagem .imagem {
            width: 200px; 
            position: relative;
        }

        .card-imagem input[type="file"] { display: none; }

        .label-file {
            display: block;
            width: 100%;
            max-width: 200px;
            padding: 8px 0px;
            margin-top: 10px;
            border-radius: 6px;
            background-color: #00abc7;
            text-align: center;
            color: #FFF;
            cursor: pointer;
        }

        .btn-remover-imagem, .btn-remover-imagem-fundo {
            position: absolute; 
            top: 0px;
            right: 0px;
            width: 30px; 
            height: 30px;
            border-radius: 4px;
            background-color: #dc3545;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFF;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-remover-imagem:hover, .btn-remover-imagem-fundo:hover { background-color: #c82333; }

        .image-contain-h-200 {
            width: 100%;
            height: 200px;
            object-fit: contain;
            object-position: center;
        }

        .d-none { display: none !important; }
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
                                    <li><a href="<?= site_url('adm/empresa-enderecos')?>">- ENDEREÇOS</a></li>                                                   
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
    // $sql = "SELECT * FROM tb_paginas WHERE pagina = 'home'";
    $sql = "SELECT * FROM tb_pagina_home WHERE id = 1";
    $query = mysqli_query($dataBase, $sql);
    $row = mysqli_fetch_object($query);

    function exibir_imagem($foto) {
        if ($foto != '') {
            return BASE_URL.'uploads/pagina/'.$foto;
        } else {
            return BASE_URL.'uploads/thumb-no-image.jpg';
        }
    }
?>
<div class="grid-container pt-25">
    <div class="grid-x">
        <div class="cell">
            <form action="home.php" method="post" enctype="multipart/form-data">
                <div class="cell">
                    <?php if($row->id): ?>
                        <input type="hidden" name="id" value="<?= $row->id; ?>">
                        <input type="hidden" id="foto_antiga" name="foto_antiga" value="<?= $row->foto_quem_somos ?>" />
                        <input type="hidden" id="biofabrica_foto_fundo_antiga" name="biofabrica_foto_fundo_antiga" value="<?= $row->biofabrica_foto_fundo ?>" />
                    <?php endif; ?>
                </div>
                <div class="grid-x">
                    <div class="cell d-flex align-items-center justify-content-between">
                        <h5>Informações da página HOME</h5>
                        <input type="submit" class="button success" value="Salvar">
                    </div>
                    <div class="cell">
                        <ul class="tabs" data-tabs id="example-tabs">
                            <li class="tabs-title is-active">
                                <a href="#panel1" aria-selected="true">
                                    QUEM SOMOS
                                </a>
                            </li>
                            <li class="tabs-title">
                                <a data-tabs-target="panel2" href="#panel2">
                                    BIOFÁBRICA
                                </a>
                            </li>
                            <li class="tabs-title">
                                <a data-tabs-target="panel3" href="#panel3">
                                    MISSÃO / VISÃO / VALORES
                                </a>
                            </li>
                        </ul>
                        <div class="tabs-content" data-tabs-content="example-tabs">
                            <div class="tabs-panel is-active" id="panel1">
                                <label>Descrição
                                    <textarea name="descricao_quem_somos" id="descricao_quem_somos" rows="3"><?= $row->descricao_quem_somos; ?></textarea>
                                </label>
                                <div class="cell">
                                    <div class="card-imagem">
                                        <div class="imagem">
                                            <img id="preview-foto" class="image-contain-h-200" src="<?= exibir_imagem($row->foto_quem_somos) ?>" loading="lazy" />
                                            <button type="button" class="btn-remover-imagem <?= $row->foto_quem_somos == "" ? 'd-none' : '' ?>" data-image="foto">
                                                x
                                            </button>
                                        </div>
                                        <label for="foto" class="label-file">
                                            <input type="file" id="foto" name="foto" class="btn" accept="image/*" onchange="validar_dimensoes_imagem(event, 850, 900, 'foto');" />
                                            Escolher foto
                                        </label>
                                        <span class="text-center" style="display: block; margin-top: 16px;">
                                            Dimensões recomendadas<br>
                                            (850x900)
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="tabs-panel" id="panel2">
                                <label>Descrição
                                    <textarea name="descricao_biofabrica" id="descricao_biofabrica" rows="4"><?= $row->descricao_biofabrica; ?></textarea>
                                </label>
                                <div class="cell">
                                    <label>Imagem de fundo da seção</label>
                                    <div class="card-imagem">
                                        <div class="imagem">
                                            <img id="preview-foto-fundo" class="image-contain-h-200" src="<?= exibir_imagem($row->biofabrica_foto_fundo) ?>" loading="lazy" />
                                            <button type="button" class="btn-remover-imagem-fundo <?= $row->biofabrica_foto_fundo == "" ? 'd-none' : '' ?>" data-image="foto">
                                                x
                                            </button>
                                        </div>
                                        <label for="foto-fundo" class="label-file">
                                            <input type="file" id="foto-fundo" name="biofabrica_foto_fundo" class="btn" accept="image/*" onchange="validar_dimensoes_imagem(event, 1920, 700, 'background');" />
                                            Escolher foto
                                        </label>
                                        <span class="text-center" style="display: block; margin-top: 16px;">
                                            Dimensões recomendadas<br>
                                            (1920x700)
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="tabs-panel" id="panel3">
                                <label>MISSÃO
                                    <textarea name="descricao_missao" id="descricao_missao" rows="4"><?= $row->descricao_missao; ?></textarea>
                                </label>
                                <hr />
                                <label>VISÃO
                                    <textarea name="descricao_visao" id="descricao_visao" rows="4"><?= $row->descricao_visao; ?></textarea>
                                </label>
                                <hr />
                                <label>VALORES
                                    <textarea name="descricao_valores" id="descricao_valores" rows="4"><?= $row->descricao_valores; ?></textarea>
                                </label>
                                <hr />
                            </div>
                        </div>
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
        CKEDITOR.replace('descricao_quem_somos');
        CKEDITOR.replace('descricao_biofabrica');
        CKEDITOR.replace('descricao_missao');
        CKEDITOR.replace('descricao_visao');
        CKEDITOR.replace('descricao_valores');
    });  
</script>

<script type="text/javascript">
    function validar_dimensoes_imagem(event, maxWidth, maxHeight, tipo) {
        if (event.target.files.length > 0) {
            const img = document.createElement("img");
            const imagem_selecionada = event.target.files[0];
            const url = URL.createObjectURL(imagem_selecionada);

            img.onload = function handleLoad() {
                if (img.width > maxWidth || img.height > maxHeight) {
                    alert(`Infelizmente, a imagem selecionada ultrapassa as dimensões recomendadas(${maxWidth}x${maxHeight}). Tente novamente...`);
                    URL.revokeObjectURL(url);
                    event.target.value = null;
                    return false;
                } else {
                    if (tipo == 'foto') {
                        handleImagePreview(event)
                    } else {
                        handleBackgroundImagePreview(event)
                    }
                }
            }

            img.src = url;
        }
    }
    function handleImagePreview(event) {
        if(event.target.files.length > 0){
            const id = event.target.id;
            const src = URL.createObjectURL(event.target.files[0]);
            const preview = document.getElementById('preview-foto');
            preview.src = src;

            $('#foto').parents(".card-imagem").find("button").removeClass("d-none");
        }
    }

    function handleBackgroundImagePreview(event) {
        if(event.target.files.length > 0){
            const id = event.target.id;
            const src = URL.createObjectURL(event.target.files[0]);
            const preview = document.getElementById('preview-foto-fundo');
            preview.src = src;

            $('#foto-fundo').parents(".card-imagem").find("button").removeClass("d-none");
        }
    }

    $(".btn-remover-imagem").click(function (e) {
        const confirmacao = confirm('Remover imagem?');

        if (confirmacao) {
            const foto = $(this).data('image');
            $('#preview-foto').attr('src', '<?= BASE_URL.'uploads/thumb-no-image.jpg'; ?>');
            $('#foto').val('');
            
            $('#foto_antiga').val('');

            $(this).addClass("d-none");
        } else {
            return false;
        }
    });

    $(".btn-remover-imagem-fundo").click(function (e) {
        const confirmacao = confirm('Remover imagem?');

        if (confirmacao) {
            const foto = $(this).data('image');
            $('#preview-foto-fundo').attr('src', '<?= BASE_URL.'uploads/thumb-no-image.jpg'; ?>');
            $('#foto-fundo').val('');
            
            $('#biofabrica_foto_fundo_antiga').val('');

            $(this).addClass("d-none");
        } else {
            return false;
        }
    });
</script>