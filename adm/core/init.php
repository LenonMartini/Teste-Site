<?php
/**
 * Created by PhpStorm.
 * User: Desenvolvimento 2
 * Date: 06/07/2018
 * Time: 10:15
 */
include('../core/config.inc.php');
header('Content-Type: application/json');

extract($_POST);
$res = array();

$link = @mysqli_connect($banco_host,$banco_usuario,$banco_senha,$banco_nome);

if($link){
    $res['result'] = 1;
    $res['text'] = "Sucesso!";
    write_config($titulo,$banco_host,$banco_nome,$banco_usuario,$banco_senha,$path,$url);
    create_table_user($site_user,$site_senha);
    mysqli_close($link);
}

else{
    $res['result'] = 0;
    $res['text'] = "Não obtive sucesso na conexão";
}

echo json_encode($res);