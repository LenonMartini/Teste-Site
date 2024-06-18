<?php
    include('../base/header.php');
    $erro = flash_data('erro');
    if ($erro) echo "<script>alert('$erro')</script>";
    write_log('BANNER',0,'ACCESS');
?>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="<?php echo site_url('adm/assets/js/plupload/jquery.ui.plupload/css/'); ?>jquery.ui.plupload.css" />
<div class="grid-container">
    <div class="grid-x">
        <div class="cell desc-line">
            <form method="post" action="salvar.php" enctype="multipart/form-data">
                <div class="grid-x">
                    <div class="cell">
                        <label>
                            Nome
                            <input type="text" name="nome" id="nome" />
                        </label>
                    </div>
                    <div class="cell">
                        <label>Foto/Banner - Dimensões recomendadas(1924x550)</label>
                        <input id="foto" name="foto" type="file" accept="image/jpeg" required onchange="validar_dimensoes_imagem(event)" />
                    </div>
                    <div class="cell">
                        <input type="submit" class="button primary" value="Salvar" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
    include "../base/footer.php"
?>

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