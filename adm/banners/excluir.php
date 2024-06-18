<?php
include("../core/config.inc.php");
$id = (int)$_GET['id'];


if (isset($_GET['id'])) {
   $query = $dataBase->query("SELECT ban_arquivo FROM tb_banner WHERE ban_id = $id;");
   $imagem_arquivo = mysqli_fetch_object($query)->ban_arquivo;
    write_log('BANNER',$id,'DELETE');
  
   if ($dataBase->query("DELETE FROM tb_banner WHERE ban_id = $id;")) {
	   
	   if($imagem_arquivo != ""){
	   	$imagem_caminho = BASE_PATH . "uploads/banner/" . $imagem_arquivo;
   		unlink($imagem_caminho);
	   }

		toast("Sucesso", "Banner deletado com sucesso", 1);
		redirect('index.php');
    } else {
        toast("Erro", "Algo aconteceu, tem certeza de que não fez algo errado?");
        redirect('index.php');
    }

}
else{
    toast("Erro", "Algo aconteceu, tem certeza de que não fez algo errado?");
}
redirect('index.php');

?>