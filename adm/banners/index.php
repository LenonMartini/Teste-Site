<?php
include('../base/header.php');

$erro = flash_data('erro');
if ($erro) echo "<script>alert('$erro')</script>";
write_log('BANNER',0,'ACCESS');

?>
<style>
    button {
        cursor: pointer;
    }
</style>
    <div class="grid-container">
        <div class="grid-x">
            <div class="cell desc-line">
                <div class="grid-x">
                    <div class="large-15 page-desc" style="font-size: 14px; color: #444;font-weight: 700">
                        <a href="novo.php">NOVO BANNER</a>
                    </div>                   
                    <div class="cell div-full" style="padding: 5px 0;"></div>
                    <div class="cell prod-main">
                        <table id="table" class="responsive-card-table unstriped">
                            <thead>
                            <tr>
                                <th class="id-first">COD</th>
                                <th class="show-for-all">Nome</th>
                                <th class="show-for-all">Imagem</th>
                                <th style="width: 10%">Excluir</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM tb_banner ORDER BY ban_ordem ASC";
                                    $query = mysqli_query($dataBase, $sql);
                                    while ($row = mysqli_fetch_object($query)) {
                                        ?>
                                        <tr>
                                            <td class="id-first"><?= $row->ban_id ?>
                                                <div class="arrow-right"></div>
                                            </td>
                                            <td>
                                                <a href="editar.php?id=<?= $row->ban_id ?>"><?= $row->ban_nome != '' ? $row->ban_nome : '<i>(Sem nome)</i>' ?></a>
                                            </td>
                                            <td> 
                                                <img src="<?= BASE_URL ?>uploads/banner/<?=$row->ban_arquivo; ?>" style="max-width: 200px;">
                                            </td>
                                            <td>
                                                <button type="button" onclick="excluir_registro('<?= $row->ban_id ?>');">
                                                    <img src="<?= site_url() ?>adm/assets/img/delete.jpg">
                                                </button>
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
        function excluir_registro(id) {
            if (id != "0") {
                let confirmacao = confirm("Deseja remover este banner?");

                if (confirmacao) {
                    window.location.href=`excluir.php?id=${id}`;
                }
            }
            return false;
        }
        /*$(document).ready(function () {
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
        });*/
    </script>
<?php
    include "../base/footer.php"
?>