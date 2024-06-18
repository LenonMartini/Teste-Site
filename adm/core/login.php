<?php
	include('config.inc.php');
	//instacia do banco
	
	$login = addslashes($_POST["login"]);
	$senha = addslashes($_POST["senha"]);

	$cript = cript($senha);

	$query = mysqli_query($dataBase,"SELECT * FROM tb_usuario WHERE usu_login = '".$login."' AND usu_senha = '".$cript."' AND usu_status = 1 LIMIT 1;");
    $object = mysqli_fetch_object($query);

	if($object){
        $_SESSION["usu_id"] = $object->usu_id;
        $_SESSION["usu_nome"] = $object->usu_nome;
        $_SESSION["usu_login"] = $object->usu_login;
        redirect(site_url()."adm/home/index.php");
		exit;
	}else{
		flash_data('erro_login',1);
		redirect(site_url('adm/login.php'));
		exit;
	}
?>