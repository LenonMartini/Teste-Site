<?php
    include('../base/header.php');
?>
<div class="grid-container pt-25">
    <div class="grid-x">
        <div class="cell">
            <form action="salvar.php" method="post" enctype="multipart/form-data">
                <div class="grid-x">
                    <div class="cell">
                        <label>Nome do marca
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
                        <label>Foto - Dimensões recomendadas(380x200)</label>
                        <input id="foto" name="foto" type="file" accept="image/jpeg, image/png" onchange="validar_dimensoes_imagem(event)" required /> 
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
                if (img.width > 380 || img.height > 200) {
                    alert("Infelizmente, a imagem selecionada ultrapassa as dimensões recomendadas(200x300). Tente novamente...");
                    event.target.value = null;

                    return false;
                }
                URL.revokeObjectURL(url);
            }

            img.src = url;
        }
    }
</script>