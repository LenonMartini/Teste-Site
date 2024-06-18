<?php
include("../core/config.inc.php");
$id = (int)$_GET['id'];


if (isset($_GET['id']) && $id > 1) {
    if ($_SESSION["usu_id"] == $_GET['id']) {
        flash_data('erro', 'Você não pode apagar o próprio usuário :/');
        header("Location: usuarios.php");
    } else {
        if ($dataBase->query("DELETE FROM tb_usuario WHERE usu_id = $id;")) {
            toast("Sucesso", "Usuário deletado com sucesso", 1);
            redirect('usuarios.php');
        } else {
            toast("Erro", "Algo aconteceu, tem certeza que não fez algo errado?");
            redirect('usuarios.php');
        }
    }

}
else{
    toast("Erro", "Algo aconteceu, tem certeza que não fez algo errado?");
}
redirect('usuarios.php');

?>