<?php
include('../core/config.inc.php');

$nome = addslashes($_POST['nome']);
$login = addslashes($_POST['login']);
$senha = cript($_POST['senha']);
if(isset($_POST['id'])){
    $id = (int)($_POST['id']);
    if($_POST['senha']=='' || !$_POST['senha']){
        $sql = "UPDATE tb_usuario SET usu_nome = '$nome', usu_login = '$login' WHERE usu_id = $id";
    }
    else $sql = "UPDATE tb_usuario SET usu_nome = '$nome', usu_login = '$login', usu_senha = '$senha' WHERE usu_id = $id";
    $dataBase->query($sql);
    toast("Sucesso","Usuário editado com sucesso",1);
}

else{
    $sql = "INSERT INTO tb_usuario(usu_nome, usu_login, usu_senha) VALUES ('$nome','$login','$senha')";
    $dataBase->query($sql);
    toast("Sucesso","Usuário $nome criado com sucesso",1);
}
redirect("usuarios.php");
?>