<?php
/**
 * Created by PhpStorm.
 * User: Desenvolvimento 2
 * Date: 07/07/2018
 * Time: 10:26
 */
include('core/config.inc.php');
$id = isset($_POST['id']) ? $_POST['id'] : 0;

$url = addslashes($_POST['url']);
$type = addslashes($_POST['type']);

header('Content-Type: application/json');
$url = remove_accents($url);
$url = generateSeoURL($url,32);

if($type=='produto' && $id) {
    $sql = "SELECT url_amigavel FROM tb_produto WHERE url_amigavel = '$url' AND id <> $id";
} else {
    $sql = "SELECT url_amigavel FROM tb_produto WHERE url_amigavel = '$url'";
}

if($type=='marca'){
    $sql = "SELECT url_amigavel FROM tb_marca WHERE url_amigavel = '$url'";
}

if($type=='categoria'){
    $sql = "SELECT url_amigavel FROM tb_categoria WHERE url_amigavel = '$url'";
}

$query = mysqli_query($dataBase,$sql);
$data['result'] = $query->num_rows ? false : $url;

echo json_encode($data);

