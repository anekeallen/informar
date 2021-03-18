<?php 
$pag = "periodoLetivo";
require_once("../conexao.php"); 

@session_start();
    //verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'Admin'){
    echo "<script language='javascript'> window.location='../index.php' </script>";

}


?>

<div class="row mt-4 mb-4">
    <a type="button" title="Cadastrar Novo Período Letivo" class="btn-primary btn-sm ml-3 d-none d-md-block" href="index.php?pag=<?php echo $pag ?>&funcao=novo">Novo Período Letivo</a>
    <a type="button" title="Cadastrar Novo Período Letivo" class="btn-primary btn-sm ml-3 d-block d-sm-none" href="index.php?pag=<?php echo $pag ?>&funcao=novo"><i class="fas fa-user-plus"></i></a>
    
</div>


<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th >Período</th>
                        <th >Data Ínicio</th>
                        <th >Data Final</th>
                        <th >Dias Letivos</th>
                        <th >Semanas Letivas</th>
                        <th >Ano Conclusão</th>
                        
                        
                        <th >Ações</th>
                    </tr>
                </thead>

                <tbody>

                 <?php 

                 $query = $pdo->query("SELECT * FROM tbperiodo order by IdPeriodo desc ");
                 $res = $query->fetchAll(PDO::FETCH_ASSOC);

                 for ($i=0; $i < count($res); $i++) { 
                  foreach ($res[$i] as $key => $value) {
                  }

                  $periodo = $res[$i]['NomePeriodo'];
                  $dataInicial = $res[$i]['DataInicial'];
                  $dataFinal = $res[$i]['DataFinal'];
                  $dias_letivos = $res[$i]['DiasLetivos'];
                  $semanas_letivas = $res[$i]['SemanasLetivas'];
                  $ano_conclusao = $res[$i]['AnoConclusao'];

                  $dataInicialF = implode('/', array_reverse(explode('-', $dataInicial)));
                  $dataFinalF = implode('/', array_reverse(explode('-', $dataFinal)));

                  $id = $res[$i]['IdPeriodo'];


                  ?>


                  <tr>
                    <td><?php echo $periodo ?></td>
                    <td><?php echo $dataInicialF ?></td>

                    <td><?php echo $dataFinalF ?></td>
                    <td><?php echo $dias_letivos ?></td>
                    <td><?php echo $semanas_letivas ?></td>
                    <td><?php echo $ano_conclusao ?></td>




                    <td>
                        <a href="index.php?pag=<?php echo $pag ?>&funcao=endereco&id=<?php echo $id ?>" class='text-info mr-1' title='Dados do Ano Letivo'><i class="fas fa-info-circle"></i></a>
                        <a href="index.php?pag=<?php echo $pag ?>&funcao=editar&id=<?php echo $id ?>" class='text-primary mr-1' title='Editar Dados'><i class='far fa-edit'></i></a>

                        <a href="index.php?pag=<?php echo $pag ?>&funcao=excluir&id=<?php echo $id ?>" class='text-danger mr-1' title='Excluir Registro'><i class='far fa-trash-alt'></i></a>
                    </td>
                </tr>
            <?php } ?>





        </tbody>
    </table>
</div>
</div>
</div>




<!-- Modal -->
<div class="modal fade" id="modalDados" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <?php 
                if (@$_GET['funcao'] == 'editar') {
                    $titulo = "Editar Registro";
                    $id2 = $_GET['id'];

                    $query = $pdo->query("SELECT * FROM tbperiodo where IdPeriodo = '" .$id2."' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);



                    $periodo2 = $res[0]['NomePeriodo'];
                    $sigla2 = $res[0]['SiglaPeriodo'];
                    $dataInicial2 = $res[0]['DataInicial'];
                    $dataFinal2 = $res[0]['DataFinal'];
                    $dias_letivos2 = $res[0]['DiasLetivos'];
                    $semanas_letivas2 = $res[0]['SemanasLetivas'];
                    $ano_conclusao2 = $res[0]['AnoConclusao'];

                    $dataInicialF2 = implode('/', array_reverse(explode('-', $dataInicial2)));
                    $dataFinalF2 = implode('/', array_reverse(explode('-', $dataFinal2)));

                    


                } else {
                    $titulo = "Inserir Registro";

                }


                ?>
                
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $titulo ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-6">
                            <label >Período</label>
                            <input required value="<?php echo @$periodo2 ?>" type="text" class="form-control" id="periodoLetivo-cat" name="periodoLetivo-cat" placeholder="Nome do Período Letivo">
                        </div>
                        <div class="form-group col-6">
                            <label >Sigla</label>
                            <input required value="<?php echo @$sigla2 ?>" type="text" class="form-control" id="sigla-cat" name="sigla-cat" placeholder="Sigla do Período (ex: 2021)">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label >Data Inicial</label>
                            <input required value="<?php echo @$dataInicial2 ?>" type="date" class="form-control" id="dataInicial-cat" name="dataInicial-cat">
                        </div>
                        <div class="form-group col-6">
                            <label >Data Final</label>
                            <input required value="<?php echo @$dataFinal2 ?>" type="date" class="form-control" id="dataFinal-cat" name="dataFinal-cat">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-4">
                            <label >Dias Letivos</label>
                            <input required value="<?php echo @$dias_letivos2 ?>" type="number" class="form-control" id="dias_letivos-cat" name="dias_letivos-cat">
                        </div>
                        <div class="form-group col-4">
                            <label >Semanas Letivas</label>
                            <input required value="<?php echo @$semanas_letivas2 ?>" type="number" class="form-control" id="semanas_letivas-cat" name="semanas_letivas-cat">
                        </div>
                        <div class="form-group col-4">
                            <label >Ano de Conclusão</label>
                            <input  value="<?php echo @$ano_conclusao2 ?>" type="number" class="form-control" id="ano_conclusao-cat" name="ano_conclusao-cat">
                        </div>
                    </div>
                    


                    <small>
                        <div id="mensagem">

                        </div>
                    </small> 

                </div>



                <div class="modal-footer">



                    <input value="<?php echo @$_GET['id'] ?>" type="hidden" name="txtid2" id="txtid2">
                    <input value="<?php echo @$sigla2 ?>" type="hidden" name="antigo" id="antigo">


                    <button type="button" id="btn-fechar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="btn-salvar" id="btn-salvar" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal" id="modal-deletar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Excluir Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <p>Deseja realmente Excluir este Registro?</p>

                <div align="center" id="mensagem_excluir" class="">

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-excluir">Cancelar</button>
                <form method="post">

                    <input type="hidden" id="id"  name="id" value="<?php echo @$_GET['id'] ?>" required>

                    <button type="button" id="btn-deletar" name="btn-deletar" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="modal-endereco" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dados do Período Letivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?php 
                if (@$_GET['funcao'] == 'endereco') {

                    $id2 = $_GET['id'];

                    $query = $pdo->query("SELECT * FROM tbperiodo where IdPeriodo = '" .$id2."' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);



                    $periodo3 = $res[0]['NomePeriodo'];
                    $sigla3 = $res[0]['SiglaPeriodo'];
                    $dataInicial3 = $res[0]['DataInicial'];
                    $dataFinal3 = $res[0]['DataFinal'];
                    $dias_letivos3 = $res[0]['DiasLetivos'];
                    $semanas_letivas3 = $res[0]['SemanasLetivas'];
                    $ano_conclusao3 = $res[0]['AnoConclusao'];

                    $dataInicialF3 = implode('/', array_reverse(explode('-', $dataInicial3)));
                    $dataFinalF3 = implode('/', array_reverse(explode('-', $dataFinal3)));

                    
                    
                } 


                ?>

                <div class="row">
                    <div class="form-group col-6">
                        <label >Período</label>
                        <input required value="<?php echo @$periodo3 ?>" type="text" class="form-control" disabled>
                    </div>
                    <div class="form-group col-6">
                        <label >Sigla</label>
                        <input value="<?php echo @$sigla3 ?>" type="text" class="form-control" disabled >
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label >Data Inicial</label>
                        <input value="<?php echo @$dataInicial3 ?>" type="date" class="form-control" disabled>
                    </div>
                    <div class="form-group col-6">
                        <label >Data Final</label>
                        <input value="<?php echo @$dataFinal3 ?>" type="date" class="form-control" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-4">
                        <label >Dias Letivos</label>
                        <input value="<?php echo @$dias_letivos3 ?>" type="number" class="form-control" disabled>
                    </div>
                    <div class="form-group col-4">
                        <label >Semanas Letivas</label>
                        <input value="<?php echo @$semanas_letivas3 ?>" type="number" class="form-control" disabled>
                    </div>
                    <div class="form-group col-4">
                        <label >Ano de Conclusão</label>
                        <input value="<?php echo @$ano_conclusao3 ?>" type="number" class="form-control" disabled>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>





<?php 

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "novo") {
    echo "<script>$('#modalDados').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "editar") {
    echo "<script>$('#modalDados').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "excluir") {
    echo "<script>$('#modal-deletar').modal('show');</script>";
}
if (@$_GET["funcao"] != null && @$_GET["funcao"] == "endereco") {
    echo "<script>$('#modal-endereco').modal('show');</script>";
}


?>



<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
    $("#form").submit(function () {
        var pag = "<?=$pag?>";
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: pag + "/inserir.php",
            type: 'POST',
            data: formData,

            success: function (mensagem) {

                $('#mensagem').removeClass()

                if (mensagem.trim() == "Salvo com Sucesso!!") {

                    //$('#nome').val('');
                    //$('#cpf').val('');
                    $('#btn-fechar').click();
                    window.location = "index.php?pag="+pag;

                } else {

                    $('#mensagem').addClass('text-danger')
                }

                $('#mensagem').text(mensagem)

            },

            cache: false,
            contentType: false,
            processData: false,
            xhr: function () {  // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                    myXhr.upload.addEventListener('progress', function () {
                        /* faz alguma coisa durante o progresso do upload */
                    }, false);
                }
                return myXhr;
            }
        });
    });
</script>





<!--AJAX PARA EXCLUSÃO DOS DADOS -->
<script type="text/javascript">
    $(document).ready(function () {
        var pag = "<?=$pag?>";
        $('#btn-deletar').click(function (event) {
            event.preventDefault();

            $.ajax({
                url: pag + "/excluir.php",
                method: "post",
                data: $('form').serialize(),
                dataType: "text",
                success: function (mensagem) {

                    if (mensagem.trim() === 'Excluído com Sucesso!!') {


                        $('#btn-cancelar-excluir').click();
                        window.location = "index.php?pag=" + pag;
                    }

                    $('#mensagem_excluir').text(mensagem)



                },

            })
        })
    })
</script>









<script type="text/javascript">
    $(document).ready(function () {
        $('#dataTable').dataTable({
            "ordering": false,
            "stateSave": true,
            "stateDuration": 60 * 60 * 24,
            "autoWidth": false
        })

    });
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>

<script src="../js/mascaras.js"></script>



