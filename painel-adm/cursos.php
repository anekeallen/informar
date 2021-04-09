<?php 
$pag = "cursos";
require_once("../conexao.php"); 

@session_start();
    //verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'Admin'){
    echo "<script language='javascript'> window.location='../index.php' </script>";

}


?>

<div class="row mt-4 mb-4">
    <a type="button" title="Cadastrar Novo Curso" class="btn-primary btn-sm ml-3 d-none d-md-block" href="index.php?pag=<?php echo $pag ?>&funcao=novo">Novo Curso</a>
    <a type="button" title="Cadastrar Novo Curso" class="btn-primary btn-sm ml-3 d-block d-sm-none" href="index.php?pag=<?php echo $pag ?>&funcao=novo"><i class="fas fa-user-plus"></i></a>
    
</div>


<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th >Curso</th>
                        <th >Descrição</th>
                        <th >Portaria de Autorização</th>
                        <th >Horário Matutino</th>
                        <th >Carga Horária Anual</th>
                        <th >Horário Vespertino</th>
                        
                        
                        <th >Ações</th>
                    </tr>
                </thead>

                <tbody>

                   <?php 

                   $query = $pdo->query("SELECT * FROM tbcurso order by IdCurso desc ");
                   $res = $query->fetchAll(PDO::FETCH_ASSOC);

                   for ($i=0; $i < count($res); $i++) { 
                      foreach ($res[$i] as $key => $value) {
                      }

                      $curso = $res[$i]['NomeCurso'];
                      $portaria = $res[$i]['PortariaAutorizacao'];
                      $descricao = $res[$i]['descricao'];
                      $horario_M = $res[$i]['horarioManha'];
                      $horario_T = $res[$i]['horarioTarde'];
                      $cargahoraria = $res[$i]['CargaHorariaAnual'];



                      $id = $res[$i]['IdCurso'];


                      ?>


                      <tr>
                        <td><a title="Ver Séries" class="text-dark" href="index.php?pag=<?php echo $pag ?>&funcao=series&id=<?php echo $id ?>"><?php echo $curso ?></a></td>
                        <td><?php echo $descricao ?></td>

                        <td><?php echo $portaria ?></td>
                        <td><?php echo $horario_M ?></td>
                        <td><?php echo $cargahoraria ?></td>
                        <td><?php echo $horario_T ?></td>





                        <td>
                            <a href="index.php?pag=<?php echo $pag ?>&funcao=endereco&id=<?php echo $id ?>" class='text-info mr-1' title='Dados da Sala'><i class="fas fa-info-circle"></i></a>
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

                    $query = $pdo->query("SELECT * FROM tbcurso where IdCurso = '" . $id2 . "' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    $curso2 = $res[0]['NomeCurso'];
                    $portaria2 = $res[0]['PortariaAutorizacao'];
                    $descricao2 = $res[0]['descricao'];
                    $horario_M2 = $res[0]['horarioManha'];
                    $horario_T2 = $res[0]['horarioTarde'];
                    $cargahoraria2 = $res[0]['CargaHorariaAnual'];


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

                    <div class="form-group">
                        <label >Curso</label>
                        <input required value="<?php echo @$curso2 ?>" type="text" class="form-control" id="curso-cat" name="curso-cat" placeholder="Nome do Curso">
                    </div>
                    <div class="form-group">
                        <label >Descrição</label>
                        <input value="<?php echo @$descricao2 ?>" type="text" class="form-control" id="descricao-cat" name="descricao-cat" placeholder="Descrição">
                    </div>
                    <div class="form-group">
                        <label >Portaria</label>
                        <input value="<?php echo @$portaria2 ?>" type="text" class="form-control" id="portaria-cat" name="portaria-cat" placeholder="Portaria de Autorização">
                    </div>
                    <div class="form-group">
                        <label >Horário Matutino</label>
                        <input value="<?php echo @$horario_M2 ?>" type="text" class="form-control" id="matutino-cat" name="matutino-cat" placeholder="Ex: 07h às 11h">
                    </div>

                     <div class="form-group">
                        <label >Horário Vespertino</label>
                        <input value="<?php echo @$horario_T2 ?>" type="text" class="form-control" id="vespertino-cat" name="vespertino-cat" placeholder="Ex: 13h às 17h">
                    </div>

                    <div class="form-group">
                        <label >Carga Horária Anual</label>
                        <input value="<?php echo @$cargahoraria2 ?>" type="number" class="form-control" id="cargahoraria-cat" name="cargahoraria-cat" placeholder="Ex: 1000 horas">
                    </div>





                    <small>
                        <div id="mensagem">

                        </div>
                    </small> 

                </div>



                <div class="modal-footer">



                    <input value="<?php echo @$_GET['id'] ?>" type="hidden" name="txtid2" id="txtid2">
                    <input value="<?php echo @$curso2 ?>" type="hidden" name="antigo" id="antigo">


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
                <h5 class="modal-title">Dados do Curso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?php 
                if (@$_GET['funcao'] == 'endereco') {

                    $id2 = $_GET['id'];

                    $query = $pdo->query("SELECT * FROM tbcurso where IdCurso = '$id2' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    
                    $curso3 = $res[0]['NomeCurso'];
                    $portaria3 = $res[0]['PortariaAutorizacao'];
                    $descricao3 = $res[0]['descricao'];

                    
                    
                } 


                ?>

                <div class="form-group">
                    <label >Curso</label>
                    <input disabled value="<?php echo @$curso3 ?>" type="text" class="form-control" >
                </div>
                <div class="form-group">
                    <label >Descrição</label>
                    <input disabled value="<?php echo @$descricao3 ?>" type="text" class="form-control" >
                </div>
                <div class="form-group">
                    <label >Portaria</label>
                    <input disabled value="<?php echo @$portaria3 ?>" type="text" class="form-control">
                </div>


            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-series" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Séries do Curso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
             <small>
               <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th scope="col">Série</th>
                      <th scope="col">Próxima Série</th>
                      <th scope="col">Código da Série</th>
                  </thead>
                  <tbody>



                    <?php 

                    $id_serie = $_GET['id'];

                  //VERIFICAR SERIES
                    $query_3 = $pdo->query("SELECT * FROM tbserie where IdCurso = '$id_serie' order by NomeSerie ");
                    $res_3 = $query_3->fetchAll(PDO::FETCH_ASSOC);

                    for ($i2=0; $i2 < count($res_3); $i2++) { 
                      foreach ($res_3[$i2] as $key => $value) {
                      }

                      $serie = $res_3[$i2]['NomeSerie'];
                      $id_prox_serie = $res_3[$i2]['IdProximaSerie'];
                      $id_mensalidade = $res_3[$i2]['IdServicoMensalidade'];
                      $codigo_serie = $res_3[$i2]['CodigoSerie'];

                      $query_4 = $pdo->query("SELECT * FROM tbserie where IdSerie = '$id_prox_serie' ");
                      $res_4 = $query_4->fetchAll(PDO::FETCH_ASSOC);

                      $prox_serie = $res_4[0]['NomeSerie'];

                      ?>


                      <tr>
                        <td><?php echo $serie ?></td>

                        <td> <?php if(@$prox_serie != ""){ ?>
                            <?php echo $prox_serie ?>
                            
                        <?php }else{ echo "-"; } ?>

                        
                    </td>

                    <td><?php echo $codigo_serie ?> </td>





                </tr>

            <?php  }  ?>

        </tbody>
    </table>
</small>


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
if (@$_GET["funcao"] != null && @$_GET["funcao"] == "series") {
    echo "<script>$('#modal-series').modal('show');</script>";
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



