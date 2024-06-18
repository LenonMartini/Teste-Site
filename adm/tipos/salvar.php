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



    if ($id){
      
        $sql = "UPDATE tb_tipo SET  nome = '$nome' WHERE id = $id";
        
        if($dataBase->query($sql) ){
            toast("Sucesso", "Tipo editado com sucesso",1);
        } else {
            toast("Erro", "Erro ao editar o Tipo", 0);
        }
        


    } else {
        $sql = "INSERT INTO tb_tipo (nome) VALUES('$nome')";

        if($dataBase->query($sql)){
            toast("Sucesso", "Tipo inserido com sucesso",1);
        } else {
            toast("Erro","Erro ao criar a Tipo",0);
        }
    }

 

    redirect("index.php");
?>