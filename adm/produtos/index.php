<?php
    include('../base/header.php');
    $erro = flash_data('erro');
    if ($erro) echo "<script>alert('$erro')</script>";
    write_log('PRODUTO',0,'ACCESS');
    
    $query = mysqli_query($dataBase, "SELECT p.*, date_format(p.alteracao, '%d/%m/%Y - %H:%i') AS data_alteracao, c.nome AS categoria, m.nome AS marca FROM tb_produto p LEFT JOIN tb_categoria c ON c.id = p.id_categoria LEFT JOIN tb_marca m ON m.id = p.id_marca");

?>

<style>
    .d-flex { display: flex !important; }


    .text-uppercase { text-transform: uppercase; }
    
    .w-10 { width: 10%;}
    .w-15 { width: 15%;}

    .m-0 { margin: 0px !important;}

    .list-unstyled { list-style: none; }
    .responsive-card-table li + li { margin-left: 1.5rem;}
</style>

<div class="grid-container pt-25">
    <div class="grid-x">
        <div class="large-15 page-desc" style="font-size: 14px; color: #444;font-weight: 700">
            <a href="novo.php">NOVO PRODUTO</a>
        </div>
        <div class="large-45 text-right ord-select"></div>
        <div class="cell div-full" style="padding: 25px 0;"></div>
        <div class="cell">
            <table id="table" class="responsive-card-table unstriped">
                <thead>
                <tr>
                    <th class="id-first">COD</th>
                    <th class="show-for-all">Nome</th>
                    <th class="show-for-all">Categoria</th>
                    <th class="show-for-all">Marca</th>
                    <th class="show-for-all w-15">Última edição</th>
                    <th class="w-10">Ativo</th>
                    <th class="w-10">Excluir</th>
                </tr>
                </thead>
                <tbody>
                    <?php while ($produto = mysqli_fetch_object($query)) { ?>
                        <tr>                        
                            <td class="id-first"><?= $produto->id ?>
                                <div class="arrow-right"></div>
                            </td>
                            <td>
                                <div class="d-flex text-uppercase">
                                    <?= $produto->nome ?>
                                </div>
                                <ul class="d-flex list-unstyled m-0">
                                    <li>
                                        <a href="editar.php?id=<?= $produto->id ?>">Editar</a>
                                    </li>
                                    <li>
                                        <a href="<?= BASE_URL.'produto/'.$produto->url_amigavel; ?>" target="_blank">Ver</a>
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <?= $produto->categoria ?>
                            </td>
                            <td>
                                <?= $produto->marca ?>
                            </td>
                            <td>
                                <?= $produto->data_alteracao ?>
                            </td>
                            <td>
                                <?php switch_generator($produto->status, $produto->id); ?>
                            </td>
                            <td>
                                <button type="button" class="clear button" onclick="confirmar_remocao(<?= $produto->id; ?>)">
                                    <img src="<?= site_url() ?>adm/assets/img/delete.jpg" width="20" height="20" />
                                </button>
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

    function status(el) {
        let status = $(el).attr('checked') ? 0 : 1;

        if (!status) $(el).removeAttr('checked');
        else $(el).attr('checked', 'checked');

        let id = $(el).attr("id");

        let rota = `status.php?id=${id}&status=${status}`;

        $.get(rota);
    }

    function confirmar_remocao(id) {
        if (id != 0) {
            let confirmacao = confirm("Remover produto?");

            if (confirmacao) {
                location.href = `<?= BASE_URL ?>adm/produtos/excluir.php?id=${id}`;
            } else {
                return false;
            }
        }
    }
</script>

<?php 
    include ("../base/footer.php") 
?>
