<?php
include('../base/header.php');

$erro = flash_data('erro');
if ($erro) echo "<script>alert('$erro')</script>";

?>
<div class="grid-container">
    <div class="grid-x">
        <div class="cell desc-line">
            <form method="post" action="salvar.php">
                <div class="grid-x">
                    <div class="cell">
                        <label>
                            Nome
                            <input type="text" name="nome" required>
                        </label>
                    </div>
                    <div class="cell">
                        <label>
                            Login
                            <input type="text" name="login" required>
                        </label>
                    </div>
                    <div class="cell">
                        <label>
                            Senha
                            <input type="password" name="senha" required>
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
