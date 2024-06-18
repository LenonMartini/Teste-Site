<?php
    include('../core/config.inc.php');

    if(!$_SESSION['usu_id'] || !isset($_SESSION['usu_id'])) redirect(site_url('adm'));



    if (isset($_POST['id'])) {
        debug();

        $id = (int) $_POST['id'];

        $descricao_quem_somos = mysqli_real_escape_string($dataBase, addslashes($_POST['descricao_quem_somos']));

        $foto_antiga1 = isset($_POST['foto1_antiga']) ? $_POST['foto1_antiga'] : ''; 
        $foto1 = isset($_FILES['foto1']) && $_FILES['foto1']['error'] != 4 ? salvar_imagem_no_disco($_FILES['foto1'], 'pagina') : $foto_antiga1;

        $foto_antiga2 = isset($_POST['foto2_antiga']) ? $_POST['foto2_antiga'] : ''; 
        $foto2 = isset($_FILES['foto2']) && $_FILES['foto2']['error'] != 4 ? salvar_imagem_no_disco($_FILES['foto2'], 'pagina') : $foto_antiga2;

        $foto_antiga3 = isset($_POST['foto3_antiga']) ? $_POST['foto3_antiga'] : ''; 
        $foto3 = isset($_FILES['foto3']) && $_FILES['foto3']['error'] != 4 ? salvar_imagem_no_disco($_FILES['foto3'], 'pagina') : $foto_antiga3;

        $sql_update = "UPDATE tb_pagina_institucional SET foto1 = '$foto1', foto2 = '$foto2', foto3 = '$foto3', descricao_quem_somos = '$descricao_quem_somos' WHERE id = $id";

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

        .container-imagens {
            display: flex; 
            flex-wrap: wrap; 
            margin-top: 1rem;
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

        .btn-remover-imagem {
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

        .btn-remover-imagem:hover { background-color: #c82333; }

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
    $sql = "SELECT * FROM tb_pagina_institucional LIMIT 1";
    $query = mysqli_query($dataBase, $sql);
    $row = mysqli_fetch_object($query);

    // $dados = json_decode($row->informacoes);

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
            <form action="institucional.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $row->id; ?>">
                <div class="grid-x">
                    <div class="cell d-flex align-items-center justify-content-between">
                        <h5>Informações da página Institucional</h5>
                        <input type="submit" class="button success" value="Salvar">
                    </div>
                    <div class="cell">
                        <label>Descrição
                            <textarea name="descricao_quem_somos" id="descricao_quem_somos" rows="4"><?= $row->descricao_quem_somos; ?></textarea>
                        </label>
                    </div>
                    <div class="cell">
                        <?php if($row->id): ?>
                            <input type="hidden" id="foto1_antiga" name="foto1_antiga" value="<?= $row->foto1 ?>" />
                            <input type="hidden" id="foto2_antiga" name="foto2_antiga" value="<?= $row->foto2 ?>" />
                            <input type="hidden" id="foto3_antiga" name="foto3_antiga" value="<?= $row->foto3 ?>" />
                        <?php endif; ?>
                    </div>
                    <div class="cell">
                        <div class="container-imagens">
                            <div class="card-imagem">
                                <div class="imagem">
                                    <img id="preview-foto1" class="image-contain-h-200" src="<?= exibir_imagem($row->foto1) ?>" loading="lazy" />
                                    <button type="button" class="btn-remover-imagem <?= $row->foto1 == "" ? 'd-none' : '' ?>" data-image="foto1">
                                        x
                                    </button>
                                </div>
                                <label for="foto1" class="label-file">
                                    <input type="file" id="foto1" name="foto1" class="btn" accept="image/png, image/jpeg, image/jpg" onchange="handleImagePreview(event);" />
                                    Escolher foto
                                </label>
                            </div>

                            <div class="card-imagem">
                                <div class="imagem">
                                    <img id="preview-foto2" class="image-contain-h-200" src="<?= exibir_imagem($row->foto2) ?>" loading="lazy" />
                                    <button type="button" class="btn-remover-imagem <?= $row->foto2 == "" ? 'd-none' : '' ?>" data-image="foto2">
                                        x
                                    </button>
                                </div>
                                <label for="foto2" class="label-file">
                                    <input type="file" id="foto2" name="foto2" class="btn" accept="image/png, image/jpeg, image/jpg" onchange="handleImagePreview(event);" />
                                    Escolher foto
                                </label>
                            </div>

                            <div class="card-imagem">
                                <div class="imagem">
                                    <img id="preview-foto3" class="image-contain-h-200" src="<?= exibir_imagem($row->foto3) ?>" loading="lazy" />
                                    <button type="button" class="btn-remover-imagem <?= $row->foto3 == "" ? 'd-none' : '' ?>" data-image="foto3">
                                        x
                                    </button>
                                </div>
                                <label for="foto3" class="label-file">
                                    <input type="file" id="foto3" name="foto3" class="btn" accept="image/png, image/jpeg, image/jpg" onchange="handleImagePreview(event);" />
                                    Escolher foto
                                </label>
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
    });  
</script>

<script type="text/javascript">
    function handleImagePreview(event) {
        if(event.target.files.length > 0){
            const id = event.target.id;
            const src = URL.createObjectURL(event.target.files[0]);
            const preview = document.getElementById(`preview-${id}`);
            preview.src = src;

            $(`#${id}`).parents(".card-imagem").find("button").removeClass("d-none");
        }
    }

    $(".btn-remover-imagem").click(function (e) {
        const confirmacao = confirm('Remover imagem?');

        if (confirmacao) {
            const foto = $(this).data('image');
            $(`#preview-${foto}`).attr('src', '<?= BASE_URL.'uploads/thumb-no-image.jpg'; ?>');
            $(`#${foto}`).val('');
            
            $(`#${foto}_antiga`).val('');

            $(this).addClass("d-none");
        } else {
            return false;
        }
    });
</script>