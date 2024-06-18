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

    $foto = null;
    if (isset($_FILES['foto'])) $foto = upload_foto($_FILES['foto'], 'ambiente');


    if ($id){
      
        if(($foto && $foto != '')){
            $sql = "UPDATE tb_ambiente SET foto = '$foto', nome = '$nome' WHERE id = $id";
            
        } else { 
            $sql = "UPDATE tb_ambiente SET  nome = '$nome' WHERE id = $id";
        
        }
        
        if($dataBase->query($sql) ){
            toast("Sucesso", "Ambiente editado com sucesso",1);
        } else {
            toast("Erro", "Erro ao editar o Ambiente", 0);
        }
        


    } else {
        $sql = "INSERT INTO tb_ambiente (nome,foto) VALUES('$nome','$foto')";

        if($dataBase->query($sql)){
            toast("Sucesso", "Ambiente inserido com sucesso",1);
        } else {
            toast("Erro","Erro ao criar a Ambiente",0);
        }
    }

 

    redirect("index.php");
?>