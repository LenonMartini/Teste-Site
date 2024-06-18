<?php
    include('../base/header.php');
?>
<div class="grid-container pt-25">
    <div class="grid-x">
        <div class="cell">
            <form action="salvar.php" method="post" enctype="multipart/form-data">
                <div class="grid-x">
                    <div class="cell">
                        <label>Nome da categoria
                            <input id="nome" name="nome" type="text" required />
                        </label>
                    </div>
                    <div class="cell">
                        <label>Status</label>
                        <select id="status" name="status" required>
                            <option value="0">Inativa</option>
                            <option value="1" selected>Ativa</option>
                        </select>
                    </div>
                    <div class="cell">
                        <label>Foto - Dimensões recomendadas (150 x 150)</label>
                        <input id="foto" name="foto" type="file" accept="image/jpeg, image/png" onchange="validar_dimensoes_imagem(event)" required /> 
                    </div>
                    <div class="cell">
                        <label>Foto Banner- Dimensões recomendadas (250 x 450)</label>
                        <input id="foto_banner" name="foto_banner" type="file" accept="image/jpeg, image/png" onchange="validar_dimensoes_imagem_banner(event)" required /> 
                    </div>
                    <div class="cell">
                        <input type="submit" class="button primary" value="Salvar" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include ("../base/footer.php") ?>

<script>
    function validar_dimensoes_imagem(event) {
        if (event.target.files.length > 0) {
            const img = document.createElement("img");
            const imagem_selecionada = event.target.files[0];
            const url = URL.createObjectURL(imagem_selecionada);

            img.onload = function handleLoad() {
                if (img.width > 150 || img.height > 150) {
                    alert("Infelizmente, a imagem selecionada ultrapassa as dimensões recomendadas(100x100). Tente novamente...");
                    event.target.value = null;

                    return false;
                }
                URL.revokeObjectURL(url);
            }

            img.src = url;
        }
    }
    function validar_dimensoes_imagem_banner(event) {
        if (event.target.files.length > 0) {
            const img = document.createElement("img");
            const imagem_selecionada = event.target.files[0];
            const url = URL.createObjectURL(imagem_selecionada);

            img.onload = function handleLoad() {
                // if (img.width > 250 || img.height > 450) {
                //     alert("Infelizmente, a imagem selecionada ultrapassa as dimensões recomendadas(250x450). Tente novamente...");
                //     event.target.value = null;

                //     return false;
                // }
                URL.revokeObjectURL(url);
            }

            img.src = url;
        }
    }
</script>