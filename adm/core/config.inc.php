<?php
    include_once('config.php');
    include_once('helper.php');

    $dataBase = new mysqli($db_host, $db_user, $db_password, $db_base) OR DIE(mysqli_error($dataBase));
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_query($dataBase,"SET NAMES 'utf8'");
    mysqli_query($dataBase,'SET character_set_connection=utf8');
    mysqli_query($dataBase,'SET character_set_client=utf8');
    mysqli_query($dataBase,'SET character_set_results=utf8');
?>