<?php
    include('../base/header.php');
    $erro = flash_data('erro');
    if ($erro) echo "<script>alert('$erro')</script>";
    write_log('CATEGORIA',0,'ACCESS');
    
    $query = mysqli_query($dataBase, "SELECT * FROM tb_categoria");
?>
<div class="grid-container pt-25">
    <div class="grid-x">
        <div class="large-15 page-desc" style="font-size: 14px; color: #444;font-weight: 700">
            <a href="novo.php">NOVA CATEGORIA</a>
        </div>
        <div class="large-45 text-right ord-select"></div>
        <div class="cell div-full" style="padding: 25px 0;"></div>
        <div class="cell">
            <table id="table" class="responsive-card-table unstriped">
                <thead>
                <tr>
                    <th class="id-first">COD</th>
                    <th class="show-for-all">Nome</th>
                    <th>Excluir</th>
                </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_object($query)) { ?>
                        <tr>                        
                            <td class="id-first"><?= $row->id ?>
                                <div class="arrow-right"></div>
                            </td>
                            <td>
                                <a href="editar.php?id=<?= $row->id ?>"><?= $row->nome ?></a>
                            </td>
                            <td>
                                <a href="excluir.php?id=<?= $row->id ?>">
                                    <img src="<?= site_url() ?>adm/assets/img/delete.jpg">
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var mobile = $("#for-mobile");
        if (!mobile.is(":visible")) {
            var table = $('#table').DataTable({
                "language":{
                    "sEmptyTable": "Nenhum registro encontrado",
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "_MENU_ resultados por página",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing": "Processando...",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sSearch": "Pesquisar",
                    "oPaginate": {
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLast": "Último"
                    },
                },
                "searching": true,
                "bLengthChange": true,
            });
            $('#all').on('change', function () {
                table.page.len(15).draw();
            });
        }
    });
</script>
<?php 
    include ("../base/footer.php") 
?>
