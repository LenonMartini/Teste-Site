<?php
    include('../base/header.php');
?>
<div class="grid-container pt-25">
    <div class="grid-x">
        <div class="cell">
            <form action="salvar.php" method="post" enctype="multipart/form-data">
                <div class="grid-x">
                    <div class="cell">
                        <label>Nome do tipo
                            <input 
                                id="nome" 
                                name="nome" 
                                type="text" 
                                required 
                            />
                        </label>
                    </div>
                    <div class="cell">
                        <input type="submit" class="button success" value="Salvar">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
    include("../base/footer.php")
?>

<!-- <script>
    function validar_dimensoes_imagem(event) {
        if (event.target.files.length > 0) {
            const img = document.createElement("img");
            const imagem_selecionada = event.target.files[0];
            const url = URL.createObjectURL(imagem_selecionada);

            img.onload = function handleLoad() {
                if (img.width > 150 || img.height > 150) {
                    alert("Infelizmente, a imagem selecionada ultrapassa as dimensões recomendadas(150x150). Tente novamente...");
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
</script> -->