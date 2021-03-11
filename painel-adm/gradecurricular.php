<?php 
$pag = "gradecurricular";
require_once("../conexao.php"); 

@session_start();
    //verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'Admin'){
    echo "<script language='javascript'> window.location='../index.php' </script>";

}


?>

<div class="row mt-4 mb-4">
    <a type="button" title="Cadastrar Nova Grade Curricular" class="btn-primary btn-sm ml-3 d-none d-md-block" href="index.php?pag=novagradecurricular">Nova Grade Curricular</a>
    <a type="button" title="Cadastrar Nova Grade Curricular" class="btn-primary btn-sm ml-3 d-block d-sm-none" href="index.php?pag=<?php echo $pag ?>&funcao=novo"><i class="fas fa-user-plus"></i></a>
    
    
</div>


<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th >Ano</th>
                        
                        
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

                      $sigla_ano = $res[$i]['SiglaPeriodo'];




                      $id = $res[$i]['IdPeriodo'];


                      ?>


                      <tr>
                        <td><a title="Ver Séries" class="text-dark" href="index.php?pag=<?php echo $pag ?>&funcao=series&id=<?php echo $id ?>"><?php echo $sigla_ano ?></a></td>


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

                    $query = $pdo->query("SELECT * FROM tbperiodo where IdPeriodo = '" . $id2 . "' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    $idperiodo = $res[0]['IdPeriodo'];
                    $SiglaPeriodo = $res[0]['SiglaPeriodo'];
                    


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
                        <label >Ano Letivo</label>
                        <select name="ano_letivo" class="form-control" id="ano_letivo">
                            

                            <?php 

                            $query = $pdo->query("SELECT * FROM tbperiodo order by IdPeriodo desc ");
                            $res = $query->fetchAll(PDO::FETCH_ASSOC);

                            for ($i=0; $i < @count($res); $i++) { 
                                foreach ($res[$i] as $key => $value) {
                                }
                                $nome_reg = $res[$i]['SiglaPeriodo'];
                                $id_reg = $res[$i]['IdPeriodo'];
                                ?>                                  
                                <option  value="<?php echo $id_reg ?>"><?php echo $nome_reg ?></option>
                            <?php } ?>

                        </select>
                    </div>
                    <div class="form-group">
                        <label >Série</label>
                        <select name="serie" class="form-control" id="serie">

                            <?php 

                            $query = $pdo->query("SELECT * FROM tbserie order by NomeSerie asc ");
                            $res1 = $query->fetchAll(PDO::FETCH_ASSOC);

                            for ($i=0; $i < @count($res1); $i++) { 
                                foreach ($res1[$i] as $key => $value) {
                                }
                                $nome_reg2 = $res1[$i]['NomeSerie'];
                                $id_reg2 = $res1[$i]['IdSerie'];
                                ?>                                  
                                <option  value="<?php echo $id_reg2 ?>"><?php echo $nome_reg2 ?></option>
                            <?php } ?>

                        </select>
                    </div>
                    <label >Selecione as Disciplinas</label><br>
                    
                    <div class="form-group">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Disciplina</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php  
                                $query = $pdo->query("SELECT * FROM tbdisciplina order by NomeDisciplina asc ");
                                $res2 = $query->fetchAll(PDO::FETCH_ASSOC);


                                for ($i=0; $i < @count($res2); $i++) { 
                                    foreach ($res2[$i] as $key => $value) {
                                    }
                                    $nome_reg3 = $res2[$i]['NomeDisciplina'];
                                    $id_reg3 = $res2[$i]['IdDisciplina'];


                                    ?>


                                    <tr>
                                        <td class="text-center"><input value="<?php echo @$id_reg3 ?>" name="id_disci[]" type="checkbox" ></td>
                                        <td name=""><?php echo $nome_reg3 ?></td>

                                    </tr>



                                <?php } ?>
                            </tbody>
                        </table>

                        <hr>
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
                <h5 class="modal-title">Séries por ano</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">



                <?php 

                $id_ano = $_GET['id'];

                  //VERIFICAR SERIES

                        //VERIFICAR Disciplinas
                $query_4 = $pdo->query("SELECT DISTINCT IdSerie FROM tbgradecurricular where IdPeriodo = '$id_ano'");
                $res_4 = $query_4->fetchAll(PDO::FETCH_ASSOC);
                for ($i=0; $i < count($res_4); $i++) { 
                  foreach ($res_4[$i] as $key => $value) {
                  }

                  $id_serie = $res_4[$i]['IdSerie'];



                  $query_3 = $pdo->query("SELECT * FROM tbserie where IdSerie = '$id_serie' order by NomeSerie");
                  $res_3 = $query_3->fetchAll(PDO::FETCH_ASSOC);



                  $serie = $res_3[0]['NomeSerie'];


                  ?>



                  <a title="Ver disciplinas por série" href="index.php?pag=gradecurricular&funcao=disciplinas&id=<?php echo $id_ano ?>&id_serie=<?php echo $id_serie ?>" name="btn-salvar-aula" class="btn btn-primary text-light m-1"><?php echo $serie ?></a>






              <?php  }  ?>



          </div>
      </div>
  </div>
</div>

<div class="modal" id="modal-disciplinas" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Disciplinas por Série</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <?php 

                $id_ano = $_GET['id'];
                $id_serie = $_GET['id_serie'];

                
                $query_4 = $pdo->query("SELECT * FROM tbgradecurricular where IdPeriodo = '$id_ano' and IdSerie = '$id_serie'");
                $res_4 = $query_4->fetchAll(PDO::FETCH_ASSOC);
                for ($i=0; $i < count($res_4); $i++) { 
                  foreach ($res_4[$i] as $key => $value) {
                  }

                  $id_disciplina = $res_4[$i]['IdDisciplina'];



                  $query_3 = $pdo->query("SELECT * FROM tbdisciplina where IdDisciplina = '$id_disciplina'");
                  $res_3 = $query_3->fetchAll(PDO::FETCH_ASSOC);



                  $disciplina = $res_3[0]['NomeDisciplina'];


                  ?>



                  <a title="Ver disciplinas por série"  name="btn-salvar-aula" class="btn btn-primary text-light m-1"><?php echo $disciplina ?></a>



              <?php  }  ?>



          </div>
          <div class="modal-footer">
            <a type="button" href="index.php?pag=gradecurricular&funcao=series&id=<?php echo $id_ano ?>" class="btn btn-secondary">Voltar</a>



            <button type="button" data-dismiss="modal" class="btn btn-danger">Fechar</button>
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
if (@$_GET["funcao"] != null && @$_GET["funcao"] == "disciplinas") {
    echo "<script>$('#modal-disciplinas').modal('show');</script>";
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
                    //$('#btn-fechar').click();
                    //window.location = "index.php?pag="+pag;

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
            "ordering": false
        })

    });
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>

<script src="../js/mascaras.js"></script>



