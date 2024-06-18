<?php
    include('../base/header.php');

    $id = (int)$_GET['id'];
    $sql = "SELECT * FROM tb_marca WHERE id = $id";
    $query = mysqli_query($dataBase, $sql);
    $row = mysqli_fetch_object($query);
    if (!$row) redirect();

?>
<div class="grid-container pt-25">
    <div class="grid-x">
        <div class="cell">
            <form action="salvar.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $row->id ?>">
                <div class="grid-x">
                    <div class="cell">
                        <label>Nome do marca
                            <input 
                                type="text" 
                                name="nome" 
                                id="nome" 
                                value="<?= $row->nome ?>" 
                                required 
                            />
                        </label>
                    </div>
                    <div class="cell">
                        <label for="status">Status</label>
                        <select id="status" name="status" required>
                            <option value="0" <?= $row->status == '0' ? 'selected' : ''; ?>>Inativa</option>
                            <option value="1" <?= $row->status == '1' ? 'selected' : ''; ?>>Ativa</option>
                        </select>
                    </div>
                    <div class="cell">
                        <label>Foto atual</label>
                        <div class="preview" style="display: flex; align-items: center; justify-content: center; width: 200px; height: 200px;">
                            <img src="<?= PATH_IMG."marca/$row->foto" ?>" style="width: 100%; object-fit:contain; object-position: center;" />
                        </div>
                    </div>
                    <div class="cell">
                        <label>Foto - Dimensões recomendadas(380x200)</label>
                        <input id="foto" name="foto" type="file" accept="image/jpeg, image/png" onchange="validar_dimensoes_imagem(event)" />
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