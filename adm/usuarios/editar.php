<?php
include('../base/header.php');

$erro = flash_data('erro');
if ($erro) echo "<script>alert('$erro')</script>";

$id = (int)$_GET['id'];
if(!$id) redirect();

$sql = "SELECT * FROM tb_usuario WHERE usu_id = $id";
$query = mysqli_query($dataBase,$sql);
$row = mysqli_fetch_object($query);
if(!$row){
    redirect();
    exit();
}
//var_dump($row);
?>
<div class="grid-container">
    <div class="grid-x">
        <div class="cell desc-line">
            <form method="post" action="salvar.php">
                <div class="grid-x">
                    <input type="hidden" name="id" value="<?php echo $row->usu_id ?>">
                    <div class="cell">
                        <label>
                            Nome
                            <input type="text" name="nome" required value='<?php echo $row->usu_nome?>'>
                        </label>
                    </div>
                    <div class="cell">
                        <label>
                            Login
                            <input type="text" name="login" required value='<?php echo $row->usu_login?>'>
                        </label>
                    </div>
                    <div class="cell">
                        <label>
                            Senha
                            <input type="password" name="senha" autocomplete="new-password">
                        </label>
                    </div>
                    <div class="cell text-right">
                        <input type="submit" value="Enviar">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include "../base/footer.php"
?>
