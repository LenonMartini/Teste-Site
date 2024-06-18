<?php
	function restrict($necessaryPerm){
		if($necessaryPerm == 0){
			if($_SESSION["usu_id"]){
				$verify = "OK";
			}
		}else{
			if(($_SESSION["usu_perm"] & $necessaryPerm) != 0){
				$verify = "OK";
			}
		}
		if($verify <> "OK"){
			alert("Voce não tem permissão para acessar esta página!");
			header("Location: ".URLSITE."/adm");
			if($_SESSION["usu_perm"]){
				echo "<script>window.location = URLSITE.'adm/';</script>";
			}else{
				echo "<script>window.location = URLSITE.'adm/';</script>";
			}
            echo "<script>window.location = URLSITE.'adm/';</script>";
			exit;
		}
	}
?>