<?php
    /**
     * Created by PhpStorm.
     * User: Desenvolvimento 2
     * Date: 09/07/2018
     * Time: 11:34
     */
    include('../core/config.inc.php');
    
    $id = (int) $_POST['id'];
    $nome = addslashes($_POST['nome']);

    $url = remove_accents($nome);
    $url_amigavel = generateSeoURL($url, 32);

    $status = (int) $_POST['status'];

    $foto = null;
    $fotoBanner = null;
    if (isset($_FILES['foto'])) $foto = upload_foto($_FILES['foto'], 'categoria');
    if (isset($_FILES['foto_banner'])) $fotoBanner = upload_foto($_FILES['foto_banner'], 'categoria');

    if ($id){
      
        if(($foto && $foto != '')){
            $sqlFoto = "UPDATE tb_categoria SET foto = '$foto', nome = '$nome', url_amigavel = '$url_amigavel', status = '$status' WHERE id = $id";
  
        } else { 
            $sqlFoto = "UPDATE tb_categoria SET  nome = '$nome', url_amigavel = '$url_amigavel', status = '$status' WHERE id = $id";
        
        }

        if(($fotoBanner && $fotoBanner != '')){
            $sqlBanner = "UPDATE tb_categoria SET  foto_banner = '$fotoBanner', nome = '$nome', url_amigavel = '$url_amigavel', status = '$status' WHERE id = $id";
        
        } else { 
            $sqlBanner = "UPDATE tb_categoria SET nome = '$nome', url_amigavel = '$url_amigavel', status = '$status' WHERE id = $id";
        
        }


        
        if($dataBase->query($sqlFoto) ){
            toast("Sucesso", "Categoria editada com sucesso",1);
        } else {
            toast("Erro", "Erro ao editar o Categoria", 0);
        }
        
        if($dataBase->query($sqlBanner) ){
            toast("Sucesso", "Categoria editada com sucesso",1);
        } else {
            toast("Erro", "Erro ao editar o Categoria", 0);
        }

    } else {
        $sql = "INSERT INTO tb_categoria (nome, status, url_amigavel) VALUES('$nome','$status', '$url_amigavel')";

        if($dataBase->query($sql)){
            toast("Sucesso", "Categoria inserida com sucesso",1);
        } else {
            toast("Erro","Erro ao criar a Categoria",0);
        }
    }

 

    redirect("index.php");
?>