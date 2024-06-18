<?php
    include('../core/config.inc.php');

    debug();
    
    $id = @(int)$_POST['id'];

    $nome = addslashes($_POST['nome']);
    $url = addslashes($_POST['url']);
    $descricao = mysqli_real_escape_string($dataBase,$_POST['descricao']);
    $status = (int) $_POST['status'];
    $categoria = (int)($_POST['categoria']);
    $tipo = (int)($_POST['tipo']);
    $marca = (int)($_POST['marca']);
    $preco = floatval(($_POST['preco']));
    $desconto =floatval($_POST['desconto']/100);
    $uso = (int)($_POST['recomendado']);
    
    if(isset($_FILES['foto1']) && $_FILES['foto1']['error'] != 4){
        $foto1 = salvar_foto($_FILES['foto1'], 'produto', $nome);
    } else {
        $foto1 = isset($_POST['foto1_antiga']) ? $_POST['foto1_antiga'] : '';
    }
    
    
    if(isset($_FILES['foto2']) && $_FILES['foto2']['error'] != 4){
        $foto2  = salvar_foto($_FILES['foto2'], 'produto', $nome);
    } else {
        $foto2 = isset($_POST['foto2_antiga']) ? $_POST['foto2_antiga'] : '';
    }
    
    if(isset($_FILES['foto3']) && $_FILES['foto3']['error'] != 4){
        $foto3  = salvar_foto($_FILES['foto3'], 'produto', $nome);
    } else {
        $foto3 = isset($_POST['foto3_antiga']) ? $_POST['foto3_antiga'] : '';
    }
    
    if(isset($_POST['ambiente']) && $_POST['ambiente'] != ""){
        $ambientes = (array)($_POST['ambiente']);
    } 


    if($id){

        $sqlCheckURL = "SELECT id FROM tb_produto WHERE url_amigavel = '$url' AND id <> $id";
        $queryCheckURL = mysqli_query($dataBase, $sqlCheckURL);
        
        $url_amigavel = $queryCheckURL->num_rows ? "$url-$id" : $url;

        $sql = "UPDATE tb_produto SET 
                        nome = '$nome',
                        url_amigavel = '$url_amigavel',
                        descricao = '$descricao',
                        foto1 = '$foto1',
                        foto2 = '$foto2',
                        foto3 = '$foto3',
                        status = '$status',
                        preco ='$preco',
                        desconto ='$desconto',
                        id_categoria = '$categoria',
                        id_marca = '$marca',
                        id_tipo = '$tipo'
                WHERE id = $id";
        
        $ambienteDelete="DELETE FROM tb_ambiente_produto  WHERE id_produto = $id";
        $dataBase->query($ambienteDelete);

        foreach ($ambientes as $idAmbiente) {
            $ambienteUpdate =  "INSERT tb_ambiente_produto (id_produto,id_ambiente,uso_recomendado) VALUES ('$id','$idAmbiente','$uso')";
            $dataBase->query($ambienteUpdate);
            var_dump("$id,$idAmbiente");
            
            
        }
        
    
        $dataBase->query($sql);
       
    

        write_log('PRODUTO',$id,'UPDATE');
        toast("Sucesso","Produto editado com sucesso", 1);  
        redirect('index.php');

    } else {

        $sql = "INSERT INTO tb_produto
                (nome, url_amigavel, descricao, foto1, foto2, foto3, status, id_categoria, id_marca,id_tipo,desconto,preco) 
                VALUES ('$nome', '$url','$descricao', '$foto1', '$foto2', '$foto3', '$status', '$categoria', '$marca','$tipo','$desconto','$preco')";

        $dataBase->query($sql);
        $id_novo = $dataBase->insert_id;
        write_log('PRODUTO',$id_novo,'INSERT');
        

        foreach($ambientes as $idAmbiente){
            $ambient="INSERT tb_ambiente_produto (id_produto,id_ambiente,uso_recomendado) VALUES ('$id_novo','$idAmbiente','$uso')";
            $dataBase->query($ambient);
            //echo $ambient;
        }
        $id_ambiente_novo =$dataBase->insert_id;
        write_log('AMBIENTE',$id_ambiente_novo,'INSERT');
        toast("Sucesso","Produto salvo com sucesso",1);
        redirect('index.php');
    }
?>