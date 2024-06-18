<?php
    include('../base/header.php');

    $query_categorias = mysqli_query($dataBase, "SELECT * FROM tb_categoria");
    $query_marcas = mysqli_query($dataBase, "SELECT * FROM tb_marca");
    $query_ambientes = mysqli_query($dataBase, "SELECT * FROM tb_ambiente");
    $query_tipos = mysqli_query($dataBase, "SELECT * FROM tb_tipo");

    function exibir_imagem($foto, $diretorio = 'produto') {
        return ($foto != '') ? PATH_IMG.$diretorio.'/'.$foto : PATH_IMG.'thumb-no-image.jpg';
    }
?>
<style type="text/css">
    .side-bar {
        padding-left: 25px;
        margin-top: 15px;
    }

    .list-ul { list-style: none; }
    .item-side { margin-bottom: 15px;}
    .text-core .text-wrap textarea, .text-core .text-wrap input, .text-core .text-wrap { width: 100% !important; }

    .save-prod {
        width: 100%;
        box-shadow: none;
        border: 0;
        background-color: #9bc242;
        padding: 15px 0;
        border-radius: 0;
        color: white;
        font-size: 17px;
        margin-bottom: 25px;
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
        max-width: 33%; 
        width: 100%;
        padding: 0.5rem 0rem;
    }

    .card-imagem .imagem {
        width: 200px; 
        position: relative;
    }

    .container-imagens input[type="file"],
    #foto-fundo1, #foto-fundo2, #foto-fundo3 { 
        display: none; 
    }

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

    .btn-remover-imagem{
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

    .btn-remover-arquivo {
        opacity: 1;
        border-radius: 4px;
        background-color: #FFF;
        border: 1px solid #CDD4DC;
        box-shadow: 0px 10px 15px -3px rgba(0, 0, 0, 0.1);
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

    .flex-column { flex-direction: column !important; }
    .flex-wrap { flex-wrap: wrap !important; }

    .mb-2 { margin-bottom: 0.5rem;}
    .p-2 { padding: 0.5rem;}
    
    .max-w-200 { max-width: 200px; }

</style>
<div class="grid-container pt-25" style="padding: 25px 0 ">
    <div class="grid-x">
        <form action="salvar.php" method="post" class="cell" enctype="multipart/form-data">
            
            <div class="text-right" style="width: 100%">
                <button type="submit" class="button success">Salvar alterações</button>
            </div>
            <div class="tabs-content" data-tabs-content="template-page-tabs">
                <div class="tabs-panel is-active" id="defaultpage">
                    <div class="grid-x">
                        <div class="large-45">
                            <div class="grid-x">
                                <div class="cell">
                                    <label>Nome do produto
                                        <input 
                                            id="nome"
                                            name="nome" 
                                            type="text" 
                                            placeholder="Nome do produto"  
                                            required 
                                        />
                                    </label>
                                </div>
                                <div class="cell">
                                    <label>Url amigável: (<span id="url-example"><?= site_url() . 'produto/' ?></span>)
                                        <input 
                                            type="text" 
                                            name="url" 
                                            id="url" 
                                            onblur="urlnizer()" 
                                            required 
                                        />
                                    </label>
                                    <div class="callout alert" data-closable style="display: none">
                                        Esse url já existe. Tente outro
                                        <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>

                                
                                <div class="cell">
                                    <label>Descrição
                                        <textarea name="descricao" id="descricao" rows="10" cols="80"></textarea>
                                    </label>
                                </div>
                                                    
                                <div class="cell">
                                    <div class="container-imagens">
                                        <div class="card-imagem">
                                            <div class="imagem">
                                                <img id="preview-foto1" class="image-contain-h-200" src="<?= exibir_imagem("") ?>" loading="lazy" />
                                                <button type="button" class="btn-remover-imagem" data-image="foto1">
                                                    x
                                                </button>
                                            </div>
                                            <label for="foto1" class="label-file">
                                                <input type="file" id="foto1" name="foto1" class="btn" accept="image/*" onchange="validar_dimensoes_imagem(event);" />
                                                Escolher arquivo
                                            </label>
                                            <span class="text-center" style="display: block; margin-top: 16px;">
                                                Dimensões recomendadas<br>
                                                (800x800)
                                            </span>
                                        </div>

                                        <div class="card-imagem">
                                            <div class="imagem">
                                                <img id="preview-foto2" class="image-contain-h-200" src="<?= exibir_imagem("") ?>" loading="lazy" />
                                                <button type="button" class="btn-remover-imagem" data-image="foto2">
                                                    x
                                                </button>
                                            </div>
                                            <label for="foto2" class="label-file">
                                                <input type="file" id="foto2" name="foto2" class="btn" accept="image/*" onchange="validar_dimensoes_imagem(event);" />
                                                Escolher arquivo
                                            </label>
                                            <span class="text-center" style="display: block; margin-top: 16px;">
                                                Dimensões recomendadas<br>
                                                (800x800)
                                            </span>
                                        </div>

                                        <div class="card-imagem">
                                            <div class="imagem">
                                                <img id="preview-foto3" class="image-contain-h-200" src="<?= exibir_imagem("") ?>" loading="lazy" />
                                                <button type="button" class="btn-remover-imagem" data-image="foto3">
                                                    x
                                                </button>
                                            </div>
                                            <label for="foto3" class="label-file">
                                                <input type="file" id="foto3" name="foto3" class="btn" accept="image/*" onchange="validar_dimensoes_imagem(event);" />
                                                Escolher arquivo
                                            </label>
                                            <span class="text-center" style="display: block; margin-top: 16px;">
                                                Dimensões recomendadas<br>
                                                (800x800)
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="large-15 side-bar">
                            <div class="grid-x">
                                <!-- <div class="cell text-right" style="margin-top: 9px">
                                    <input type="submit" class="save-prod" value="Salvar">
                                </div> -->
                                <div class="cell item-side">
                                    <div class="grid-x">
                                        <div class="cell">
                                            <label for="status">Status</label>
                                            <select id="status" name="status" required>
                                                <option value="0">Inativo</option>
                                                <option value="1">Ativo</option>
                                            </select>
                                        </div>
                                        
                                        <div class="cell">
                                            <label for="recomendado">Recomendado</label>
                                            <select id="recomendado" name="recomendado" required>
                                                <option value="1">Para Empresas</option>
                                                <option value="2">Para Casas</option>
                                                <option value="3">Para Uso Pessoal</option>
                                                <option value="4">Para Casa/Empresa </option>
                                            </select>
                                        </div>


                                        <div class="cell">
                                            <div class="radius bordered shadow card" style="max-height: 320px; overflow-y: auto;">
                                                <div class="card-divider">
                                                    <span style="display: block;">Ambientes Recomendados </span>
                                                </div>
                                                <div class="card-section">
                                                    <?php while ($row = mysqli_fetch_object($query_ambientes)) : ?>
                                                        <label class="cursor-pointer">
                                                            <input 
                                                                type="checkbox" 
                                                                name="ambiente[]" 
                                                                value="<?= $row->id; ?>" 
                                                            />
                                                            <?= $row->nome; ?>
                                                        </label>
                                                    <?php endwhile; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="cell">
                                            <label>Categoria
                                                <select name="categoria" required>
                                                    <option value="">Selecione uma categoria</option>
                                                        <?php while ($row = mysqli_fetch_object($query_categorias)) : ?>
                                                            <option value="<?= $row->id; ?>">
                                                                <?= $row->nome; ?>
                                                            </option>
                                                        <?php endwhile; ?>
                                                </select>
                                            </label>
                                        </div>

                                        <div class="cell">
                                            <label>Tipo
                                                <select name="tipo" required>
                                                    <option value="">Selecione um tipo</option>
                                                        <?php while ($row = mysqli_fetch_object($query_tipos)) : ?>
                                                            <option value="<?= $row->id; ?>">
                                                                <?= $row->nome; ?>
                                                            </option>
                                                        <?php endwhile; ?>
                                                </select>
                                            </label>
                                        </div>
                                        
                                        <div class="cell">
                                            <label>Marca
                                                <select name="marca" required>
                                                    <option value="">Selecione uma marca</option>
                                                    <?php while ($row = mysqli_fetch_object($query_marcas)) : ?>
                                                        <option value="<?= $row->id; ?>">
                                                            <?= $row->nome; ?>
                                                        </option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </label>
                                        </div>
                                        
                                        <div class="cell">
                                            <label>Preco (R$)
                                                <input type="number" name="preco" id="preco" min="0" step="0.01" required>
                                            </label>
                                        </div>
                                        
                                        <div class="cell">
                                            <label>Desconto (%)
                                                <input type="number" step="1" min="0" max="100" name="desconto" id="desconto">
                                            </label>
                                        </div>
                                    </div>
                                </div>                           
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tabs-panel" id="especialpage">
                    <div class="grid-x">
                        <div class="d-flex align-items-center cell text-right" style="padding: 1rem 0; gap: 0.5rem;">
                            <div class="switch tiny">
                                <input class="switch-input" type="checkbox" id="exibir_pagina_especial" name="exibir_pagina_especial" />
                                <label class="switch-paddle" for="exibir_pagina_especial">
                                    <span class="show-for-sr">Download Kittens</span>
                                </label>
                            </div>
                            <span>Exibir está pagina no produto</span>

                        </div>
                        <div class="cell">
                            <ul class="tabs" data-tabs id="secoes-tabs">
                                <li class="tabs-title is-active">
                                    <a href="#secao-principal" aria-selected="true">SEÇÃO PRINCIPAL</a>
                                </li>
                                <li class="tabs-title">
                                    <a href="#secao-secundaria" data-tabs-target="secao-secundaria">SEÇÃO SECUNDARIA</a>
                                </li>
                                <li class="tabs-title">
                                    <a href="#secao-video" data-tabs-target="secao-video">SEÇÃO VÍDEO</a>
                                </li>
                            </ul>
                            <div class="tabs-content" data-tabs-content="secoes-tabs">
                                <div class="tabs-panel is-active" id="secao-principal">
                                    <div class="cell">
                                        <label>Título
                                            <input 
                                                id="paginaespecial-titulo"
                                                name="paginaespecial-titulo" 
                                                type="text" 
                                                placeholder="Titulo" 
                                                 
                                            />
                                        </label>
                                    </div>
                                    <div class="cell">
                                        <label>Descrição
                                            <textarea name="paginaespecial-descricao" id="paginaespecial-descricao" rows="10" cols="80"></textarea>
                                        </label>
                                    </div>
                                    <div class="cell">
                                        <label>Link
                                            <input 
                                                id="paginaespecial-link"
                                                name="paginaespecial-link" 
                                                type="text" 
                                                placeholder="Ex: https://innovaagro.com.br"  
                                            />
                                        </label>
                                    </div>
                                    <div class="card-imagem">
                                        <div class="imagem">
                                            <img id="preview-foto-fundo1" class="image-contain-h-200" src="<?= exibir_imagem("", "produto/bg") ?>" loading="lazy" />
                                            <button type="button" class="btn-remover-imagem d-none" data-image="foto-fundo1">
                                                x
                                            </button>
                                        </div>
                                        <label for="foto-fundo1" class="label-file">
                                            <input type="file" id="foto-fundo1" name="foto-fundo1" class="btn" accept="image/*" onchange="handleImagePreview(event);" />
                                            Escolher arquivo
                                        </label>
                                        <span class="text-center" style="display: block; margin-top: 4px;">Imagem de fundo</span>
                                        <span class="text-center" style="display: block; margin-top: 16px;">
                                            Dimensões recomendadas<br>
                                            (1920x780)
                                        </span>
                                    </div>
                                </div>
                                <div class="tabs-panel" id="secao-secundaria">
                                    <div class="cell">
                                        <label>Título
                                            <input 
                                                id="paginaespecial-titulo2"
                                                name="paginaespecial-titulo2" 
                                                type="text" 
                                                placeholder="Titulo" 
                                                 
                                            />
                                        </label>
                                    </div>
                                    <div class="cell">
                                        <label>Descrição
                                            <textarea name="paginaespecial-descricao2" id="paginaespecial-descricao2" rows="10" cols="80"></textarea>
                                        </label>
                                    </div>
                                    <div class="cell">
                                        <hr style="max-width: 100%;"/>
                                        
                                        <span style="display: block;">Folder Digital</span>

                                        <label class="label-file">Arquivo
                                            <input type="file" id="paginaespecial-arquivo" name="paginaespecial-arquivo" class="d-none" onchange="processarAnexo(this)"/>
                                        </label>

                                        <button type="button" id="btn-remover-arquivo" class="button alert d-none" style="margin-top: 0.5rem;">
                                            <span></span>
                                            <i class="fas fa-trash text-danger" style="margin-left: 3rem;"></i>
                                        </button>

                                        <hr style="max-width: 100%;"/>
                                    </div>

                                    <div class="card-imagem">
                                        <div class="imagem">
                                            <img id="preview-foto-fundo2" class="image-contain-h-200" src="<?= exibir_imagem("", "produto/bg") ?>" loading="lazy" />
                                            <button type="button" class="btn-remover-imagem d-none" data-image="foto-fundo2">
                                                x
                                            </button>
                                        </div>
                                        <label for="foto-fundo2" class="label-file">
                                            <input type="file" id="foto-fundo2" name="foto-fundo2" class="btn" accept="image/*" onchange="handleImagePreview(event);" />
                                            Escolher arquivo
                                        </label>
                                        <span class="text-center" style="display: block; margin-top: 4px;">Imagem de fundo</span>

                                        <span class="text-center" style="display: block; margin-top: 16px;">
                                            Dimensões recomendadas<br>
                                            (1920x780)
                                        </span>
                                    </div>
                                </div>
                                <div class="tabs-panel" id="secao-video">
                                    <div class="card-imagem">
                                        <div class="imagem">
                                            <img id="preview-foto-fundo3" class="image-contain-h-200" src="<?= exibir_imagem("", "produto/bg") ?>" loading="lazy" />
                                            <button type="button" class="btn-remover-imagem d-none" data-image="foto-fundo3">
                                                x
                                            </button>
                                        </div>
                                        <label for="foto-fundo3" class="label-file">
                                            <input type="file" id="foto-fundo3" name="foto-fundo3" class="btn" accept="image/*" onchange="handleImagePreview(event);" />
                                            Escolher arquivo
                                        </label>
                                        <span class="text-center" style="display: block; margin-top: 4px;">Imagem de fundo</span>

                                        <span class="text-center" style="display: block; margin-top: 16px;">
                                            Dimensões recomendadas<br>
                                            (1920x780)
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>      
        </form>
    </div>
</div>

<?php include("../base/footer.php") ?>

<script src="<?= site_url() ?>adm/assets/js/ckeditor/ckeditor.js"></script>

<script>
    var url = true;

    function urlnizer() {
        var canonic = $("#url").val();
        if (canonic == '') return;
        $.post("../urlnizer.php", {url: canonic, type: "produto" })
            .done(function (data) {
                var example = "<?php echo site_url() . 'produto/'?>";
                var message = $('.callout');
                var target = $("#url");
                if (!data.result) {
                    message.show();
                    url = false;
                }
                else {
                    url = true;
                    message.hide();
                    target.val(data.result);
                    $("#url-example").html(example + data.result);
                }

            });
    }

    $(function () {
        CKEDITOR.replace('descricao');

        CKEDITOR.replace('paginaespecial-descricao');
        CKEDITOR.replace('paginaespecial-descricao2');
    });

    $("#nome").on("blur", function () {
        var url = $("#url");

        if (url.val() == '') {
            url.val($(this).val());
            urlnizer();
        }
    });
</script>

<script type="text/javascript">
    function validar_dimensoes_imagem(event) {
        if (event.target.files.length > 0) {
            const img = document.createElement("img");
            const imagem_selecionada = event.target.files[0];
            const url = URL.createObjectURL(imagem_selecionada);

            img.onload = function handleLoad() {
                if (img.width > 800 || img.height > 800) {
                    alert(`Infelizmente, a imagem selecionada ultrapassa as dimensões recomendadas(800x800). Tente novamente...`);
                    URL.revokeObjectURL(url);
                    event.target.value = null;
                    return false;
                } else {
                    handleImagePreview(event)
                }
            }

            img.src = url;
        }
    }

    function handleImagePreview(event) {
        if(event.target.files.length > 0){
            const id = event.target.id;
            const src = URL.createObjectURL(event.target.files[0]);
            const preview = document.getElementById(`preview-${id}`);
            preview.src = src;

            $(`#${id}`).parents(".card-imagem").find("button").removeClass("d-none");
        }
    }

    function processarAnexo(input) {
        if (input.files.length > 0) {
            let file = input.files[0];

            $("#btn-remover-arquivo span").text(file.name);
            $("#btn-remover-arquivo").removeClass('d-none');
        } else {
            alert('Não foi possível carregar o arquivo! Tente novamente...');
        }
    }

    $("#btn-remover-arquivo").click(() => {
        let confirmacao = confirm('Deseja remover o arquivo?');

        if (confirmacao) {
            $("#paginaespecial-arquivo").val('');
            $("#btn-remover-arquivo").addClass('d-none');
        }
    });

    $(".btn-remover-imagem").click(function (e) {
        const confirmacao = confirm('Remover imagem?');

        if (confirmacao) {
            const foto = $(this).data('image');
            $(`#preview-${foto}`).attr('src', '<?= PATH_IMG.'thumb-no-image.jpg'; ?>');
            $(`#${foto}`).val('');
            
            $(`#${foto}_antiga`).val('');

            $(this).addClass("d-none");
        } else {
            return false;
        }
    });
</script>