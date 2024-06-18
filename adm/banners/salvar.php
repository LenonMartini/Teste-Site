<?php
    include('../core/config.inc.php');

    debug();

    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    $nome = mysqli_real_escape_string($dataBase, $_POST['nome']);
    $posicao = (int)$_POST['posicao'];
    $ordem = (int)$_POST['ordem'];
    $titulo = mysqli_real_escape_string($dataBase, $_POST['titulo']);
    $subtitulo = mysqli_real_escape_string($dataBase, $_POST['subtitulo']);
    $link = addslashes($_POST['link']);

    $link = $link != '' ? $link : '#';
    
    //$botao= mysqli_real_escape_string($dataBase,$_POST['botao']);
    //$mobile = @(int)$_POST['mobile'];
    //$status = (int)$_POST['status'];

    $foto = isset($_POST['banner_antigo']) ? $_POST['banner_antigo'] : null;

    // if (isset($_FILES['foto'])) $foto = salvar_imagem_no_disco($_FILES['foto'], 'banner');
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] != 4) $foto = upload_foto($_FILES['foto'], 'banner');

    if($id){
        $sql = "UPDATE tb_banner SET 
                        ban_nome = '$nome',
                        ban_titulo = '$titulo',
                        ban_subtitulo = '$subtitulo',
                        ban_link = '$link',   
                        ban_posicao = '$posicao', 
                        ban_ordem = '$ordem',
                        ban_arquivo = '$foto'
                    WHERE ban_id = $id";
        
        $dataBase->query($sql);

        toast("Sucesso","Banner editado com sucesso!",1);
        redirect("index.php");
    }else{
        $sql = "INSERT INTO tb_banner(ban_nome, ban_titulo, ban_subtitulo, ban_link, ban_posicao, ban_arquivo, ban_ordem) 
                VALUES ('$nome', '$titulo', '$subtitulo', '$link', '$posicao', '$foto', '$ordem')";

        if($dataBase->query($sql)) {
            toast("Sucesso","Banner criado com sucesso!",1);
        }else{
            toast("Erro","Banner não cadastrado!");
        }
        redirect("index.php");
    }
?>