<?php
include('../base/header.php');

$erro = flash_data('erro');
if ($erro) echo "<script>alert('$erro')</script>";

?>
<div class="grid-container">
    <div class="grid-x">
        <div class="cell desc-line">
            <div class="grid-x">
                <div class="large-15 page-desc" style="font-size: 14px; color: #444;font-weight: 700">
                    <a href="novo.php">NOVO USUÁRIO</a>
                </div>
                <div class="large-45 text-right ord-select">
                    Quantidade
                    <select name='length_change' id='all'>
                        <option value='10'>10</option>
                        <option value='50'>50</option>
                        <option value='100'>100</option>
                        <option value='150'>150</option>
                        <option value='200'>200</option>
                    </select>
                    registros por pagina
                </div>
                <div class="cell div-full" style="padding: 5px 0;"></div>
                <div class="cell prod-main">
                    <table id="table" class="responsive-card-table unstriped">
                        <thead>
                        <tr>
                            <th class="id-first">COD</th>
                            <th class="show-for-all">Nome</th>
                            <th class="show-for-all">Ativo</th>
                            <th>Excluir</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "SELECT * FROM tb_usuario";
                        $query = mysqli_query($dataBase, $sql);
                        while ($row = mysqli_fetch_object($query)) {
                            ?>
                            <tr>
                                <td class="id-first"><?php echo $row->usu_id ?>
                                    <div class="arrow-right"></div>
                                </td>
                                <td><a href="editar.php?id=<?php echo $row->usu_id ?>"><?php echo $row->usu_nome ?></a></td>
                                <td>
                                    <?php if ($row->usu_id != 1) switch_generator($row->usu_status, $row->usu_id); ?>
                                </td>
                                <td>
                                    <?php if($row->usu_id!=1){?>
                                    <a href="excluir.php?id=<?php echo $row->usu_id ?>"><img
                                            src="<?php echo site_url() ?>adm/assets/img/delete.jpg">
                                    </a>
                                    <?php }?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var mobile = $("#for-mobile");
        if (!mobile.is(":visible")) {
            var table = $('#table').DataTable({
                "searching": false,
                "bLengthChange": false
            });
            $('#all').on('change', function () {
                table.page.len(15).draw();
            });
        }
    });

    function status(el) {
        var new_status = $(el).attr('checked') ? 0 : 1;
        if (!new_status) $(el).removeAttr('checked');
        else $(el).attr('checked', 'checked');
        var id = $(el).attr("id");

        $.get('status.php?id=' + id + "&status=" + new_status, function (data) {
            console.log(data);
        });
    }
</script>


<?php
include "../base/footer.php"
?>
