<?php
    include("../core/config.inc.php");
    $id = (int)$_GET['id'];

    if (isset($_GET['id'])) {
        $query = $dataBase->query("SELECT foto FROM tb_marca WHERE id = $id;");
        $imagem_arquivo = mysqli_fetch_object($query)->mar_foto;
        
        write_log('MARCA', $id, 'DELETE');

        if ($dataBase->query("DELETE FROM tb_marca WHERE id = $id;")) {
            if($imagem_arquivo != ""){
                $imagem_caminho = BASE_PATH . "marca/" . $imagem_arquivo;
                unlink($imagem_caminho);
            }

            toast("Sucesso", "Marca deletada com sucesso", 1);
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