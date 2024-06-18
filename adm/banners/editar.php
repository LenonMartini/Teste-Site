<?php
    include('../base/header.php');

    $erro = flash_data('erro');
    if ($erro) echo "<script>alert('$erro')</script>";

    $id = (int)$_GET['id'];
    if(!$id) redirect();

    $sql = "SELECT * FROM tb_banner WHERE ban_id = $id";
    $query = mysqli_query($dataBase,$sql);
    $row = mysqli_fetch_object($query);
    if(!$row){
        redirect();
        exit();
    }
    write_log('BANNER',0,'ACCESS');
?>
<style>
    input[type="file"] { display: none; }

    .custom-input-file {
        display: block;
        width: 100%;
        max-width: 200px;
        padding: 8px 0px;
        border-radius: 4px;
        background-color: #dc3545;
        text-align: center;
        color: #FFF;
        cursor: pointer;
        opacity: 1;
        transition: opacity 0.3s;
    }
    .custom-input-file:hover {
        opacity: 0.8;
    }

</style>
<div class="grid-container">
    <div class="grid-x">
        <div class="cell desc-line">
            <form method="post" action="salvar.php" enctype="multipart/form-data">
                <div class="grid-x">
                    <input type="hidden" name="id" value="<?= $row->ban_id ?>" />
                    <input type="hidden" name="banner_antigo" value="<?= $row->ban_arquivo ?>" />
                    
                    <div class="cell">
                        <label>
                            Nome
                            <input type="text" name="nome" id="nome" value="<?= $row->ban_nome; ?>" />
                        </label>
                    </div>
                    
                    <div class="cell">
                        <img src="<?= site_url('uploads/banner/'. $row->ban_arquivo); ?>">
                    </div>

                    <div class="cell" style="margin-top: 1.5rem;">
                        <label>Novo Banner - Dimensões recomendadas(1924x550)</label>
                        <label class="custom-input-file">
                            Escolher imagem
                            <input id="foto" name="foto" type="file" accept="image/jpeg" onchange="validar_dimensoes_imagem(event)" /> 
                        </label>
                    </div>

                    <div class="cell text-right" style="margin-top: 1.5rem;">
                        <input type="submit" class="button" value="Salvar">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "../base/footer.php"; ?>

<script>

    function validar_dimensoes_imagem(event) {
        if (event.target.files.length > 0) {
            const img = document.createElement("img");
            const imagem_selecionada = event.target.files[0];
            const url = URL.createObjectURL(imagem_selecionada);

            img.onload = function handleLoad() {
                if (img.width > 1924 || img.height > 550) {
                    alert("Infelizmente, a imagem selecionada ultrapassa as dimensões recomendadas(1924x550). Tente novamente...");
                    event.target.value = null;

                    return false;
                }
                URL.revokeObjectURL(url);
            }

            img.src = url;
        }
    }
</script>