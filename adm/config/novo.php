<?php
/**
 * Created by PhpStorm.
 * User: Desenvolvimento 2
 * Date: 06/07/2018
 * Time: 13:22
 */

    include('../base/header.php');

    if(isset($_POST['title'])){
        $title = mysqli_real_escape_string($dataBase,$_POST['title']);
        $cidade = mysqli_real_escape_string($dataBase,$_POST['cidade']);
        $endereco = mysqli_real_escape_string($dataBase,$_POST['endereco']);
        $telefone = mysqli_real_escape_string($dataBase,$_POST['telefone']);
        $whatsapp = mysqli_real_escape_string($dataBase,$_POST['whatsapp']);
        $email = mysqli_real_escape_string($dataBase,$_POST['email']);
        $facebook = mysqli_real_escape_string($dataBase,$_POST['facebook']);
        $instagram = mysqli_real_escape_string($dataBase,$_POST['instagram']);   
        $horario_de_atendimento = mysqli_real_escape_string($dataBase,$_POST['horario_de_atendimento']);
        $link_whatsapp = mysqli_real_escape_string($dataBase,$_POST['link_whatsapp']);

        $sql = "SELECT * FROM tb_empresa WHERE id = 1";
        $query = mysqli_query($dataBase,$sql);
        if($query->num_rows){
            $sql = "UPDATE tb_empresa SET 
                        nome = '$title', 
                        endereco = '$endereco', 
                        cidade = '$cidade',
                        telefone = '$telefone', 
                        whatsapp = '$whatsapp', 
                        email = '$email', 
                        facebook = '$facebook',
                        instagram = '$instagram', 
                        horario_de_atendimento = '$horario_de_atendimento',
                        link_whatsapp = '$link_whatsapp'
                        /*instagram = '$instagram'*/
                    WHERE id = 1";
        }    
        
        try {
            $dataBase->query($sql);    
            toast("Sucesso","Cadastro atualizado",1);
        } catch(mysqli_sql_exception $e) {
            toast("Erro",$e->getMessage());
        }
    }
    $row = false;
    $sql = "SELECT * FROM tb_empresa WHERE id = 1";
    $query = mysqli_query($dataBase,$sql);
    if($query->num_rows) $row = mysqli_fetch_object($query);
?>

<div class="grid-container pt-25" style="padding: 25px 0 ">
    <div class="grid-x">
        <div class="cell">
            <form method="post" >
                <div class="grid-x">
                    <div class="cell">
                        <label>Titulo da página
                            <input type="text" name="title" placeholder="Titulo da página" value="<?php echo @$row->nome ?>" required>
                        </label>
                    </div>
                    <div class="large-1"></div>
                    <div class="cell">
                        <label>Endereço
                            <input type="text" name="endereco" placeholder="Endereço" value="<?php echo @$row->endereco ?>" >
                        </label>
                    </div>
                    <div class="cell">
                        <label>Cidade
                            <input type="text" name="cidade" placeholder="Cidade" value="<?php echo @$row->cidade ?>" >
                        </label>
                    </div>
                    <div class="large-10">
                        <label>Telefone
                            <input type="text" name="telefone" placeholder="Telefone" value="<?php echo @$row->telefone ?>" >
                        </label>
                    </div>                
                    <div class="large-1"></div>
                    <div class="large-10">
                        <label>Whatsapp
                            <input type="text" name="whatsapp" placeholder="Whatsapp" value="<?php echo @$row->whatsapp ?>" >
                        </label>
                    </div>
                    <div class="large-1"></div>
                    <div class="large-30">
                        <label>E-mail
                            <input type="email" name="email" placeholder="E-mail" value="<?php echo @$row->email ?>" >
                        </label>
                    </div>
                    <div class="large-1"></div>
                    <div class="cell">
                        <label>Facebook
                            <input type="text" name="facebook" placeholder="Facebook" value="<?php echo @$row->facebook ?>" >
                        </label>
                    </div>
                    <div class="cell">
                        <label>Instagram
                            <input type="text" name="instagram" placeholder="Instagram" value="<?php echo @$row->instagram ?>" >
                        </label>
                    </div>        
                    <div class="cell">
                        <label>Horário de atendimento
                            <input type="text" name="horario_de_atendimento" placeholder="Horário de atendimento" value="<?php echo @$row->horario_de_atendimento ?>" >
                        </label>
                    </div>
                    <div class="cell">
                        <label>Link do whatsapp
                            <input type="text" name="link_whatsapp" placeholder="Link do whatsapp" value="<?php echo @$row->link_whatsapp ?>" >
                        </label>
                    </div>

                    <div class="cell text-right" style="margin: 15px 0">
                        <input type="submit" value="Salvar">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
    include("../base/footer.php")
?>
