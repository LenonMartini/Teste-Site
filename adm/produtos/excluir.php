<?php
    include("../core/config.inc.php");
    $id = (int)$_GET['id'];

    if (isset($_GET['id'])) {
        $query = $dataBase->query("SELECT foto1, foto2, foto3 FROM tb_produto WHERE id = $id;");
        $imagem_arquivo1 = mysqli_fetch_object($query)->foto1;
        $imagem_arquivo2 = mysqli_fetch_object($query)->foto2;
        $imagem_arquivo3 = mysqli_fetch_object($query)->foto3;

        if ($dataBase->query("DELETE FROM tb_produto WHERE id = $id;")) {
            if($imagem_arquivo1 != ""){
                $imagem_caminho = BASE_PATH . "produto/" . $imagem_arquivo1;
                unlink($imagem_caminho);
            }
            if($imagem_arquivo2 != ""){
                $imagem_caminho = BASE_PATH . "produto/" . $imagem_arquivo2;
                unlink($imagem_caminho);
            }
            if($imagem_arquivo3 != ""){
                $imagem_caminho = BASE_PATH . "produto/" . $imagem_arquivo3;
                unlink($imagem_caminho);
            }

            toast("Sucesso", "Produto deletado com sucesso", 1);
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