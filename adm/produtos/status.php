<?php
    /**
     * Created by PhpStorm.
     * User: Desenvolvimento 2
     * Date: 05/07/2018
     * Time: 17:15
     */
    include('../core/config.inc.php');
    $id = (int)$_GET['id'];
    $status = (int)$_GET['status'];
    $data = array();

    if(!$id) $data['result'] = 0;
    else{
        write_log('PRODUTO',$id,'UPDATE');

        $sql = "UPDATE tb_produto SET status = $status WHERE id = $id";

        
        if($dataBase->query($sql)) {
            $data['result'] = 1;
            $data['status'] = $status;
        }
    }
    header('Content-Type: application/json');
    echo json_encode($data);
?>