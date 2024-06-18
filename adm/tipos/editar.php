<?php
    include('../base/header.php');

    $id = (int)$_GET['id'];
    $sql = "SELECT * FROM tb_tipo WHERE id = $id";
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
                        <label>Nome do Tipo
                            <input 
                                id="nome" 
                                name="nome" 
                                type="text" 
                                value="<?= $row->nome ?>" 
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
