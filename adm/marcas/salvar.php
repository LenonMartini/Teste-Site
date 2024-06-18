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
    if (isset($_FILES['foto'])) $foto = upload_foto($_FILES['foto'], 'marca');

  
    if ($id){

        if($foto && $foto != ''){
            $sql = "UPDATE tb_marca SET foto = '$foto', nome = '$nome', url_amigavel = '$url_amigavel', status = '$status' WHERE id = $id";
        } else { 
            $sql = "UPDATE tb_marca SET nome = '$nome', url_amigavel = '$url_amigavel', status = '$status' WHERE id = $id";
        }
        
        if($dataBase->query($sql)){
            toast("Sucesso", "Marca editada com sucesso",1);
        } else {
            toast("Erro", "Erro ao editar o marca", 0);
        }

    } else {
        $sql = "INSERT INTO tb_marca (nome, foto, status, url_amigavel) VALUES('$nome','$foto','$status', '$url_amigavel')";

        if($dataBase->query($sql)){
            toast("Sucesso", "Marca inserida com sucesso",1);
        } else {
            toast("Erro","Erro ao criar a marca",0);
        }
    }

    redirect("index.php");
?>