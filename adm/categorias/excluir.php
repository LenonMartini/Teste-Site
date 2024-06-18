<?php
    include("../core/config.inc.php");
    $id = (int)$_GET['id'];

    if (isset($_GET['id'])) {
        write_log('CATEGORIA', $id, 'DELETE');

        if ($dataBase->query("DELETE FROM tb_categoria WHERE id = $id;")) {
            toast("Sucesso", "Categoria deletada com sucesso", 1);
            redirect('index.php');
        } else {
            toast("Erro", "Algo aconteceu, tem certeza de que não fez algo errado?");
            redirect('index.php');
        }
    }else{
        toast("Erro", "Algo aconteceu, tem certeza de que não fez algo errado?");
    }
    redirect('index.php');
?>