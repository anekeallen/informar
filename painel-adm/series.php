<?php 
$pag = "series";
require_once("../conexao.php"); 

@session_start();
    //verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'Admin'){
  echo "<script language='javascript'> window.location='../index.php' </script>";

}


?>

<div class="row mt-4 mb-4">
  <a type="button" title="Cadastrar Nova Série" class="btn-primary btn-sm ml-3 d-none d-md-block" href="index.php?pag=<?php echo $pag ?>&funcao=novo">Nova Série</a>
  <a type="button" title="Cadastrar Nova Série" class="btn-primary btn-sm ml-3 d-block d-sm-none" href="index.php?pag=<?php echo $pag ?>&funcao=novo"><i class="fas fa-user-plus"></i></a>
  
</div>


<!-- DataTales Example -->
<div class="card shadow mb-4">

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th scope="col">Série</th>
            <th scope="col">Curso</th>
            <th scope="col">Próxima Série</th>
            
            
            
            
            <th >Ações</th>
          </tr>
        </thead>

        <tbody>

         <?php 


                  //VERIFICAR SERIES
         $query_3 = $pdo->query("SELECT * FROM tbserie order by NomeSerie ");
         $res_3 = $query_3->fetchAll(PDO::FETCH_ASSOC);

         for ($i2=0; $i2 < count($res_3); $i2++) { 
          foreach ($res_3[$i2] as $key => $value) {
          }

          $serie = $res_3[$i2]['NomeSerie'];
          $id_prox_serie = $res_3[$i2]['IdProximaSerie'];
          $id_curso = $res_3[$i2]['IdCurso'];
          $id_mensalidade = $res_3[$i2]['IdServicoMensalidade'];
          $codigo_serie = $res_3[$i2]['CodigoSerie'];
          $id = $res_3[$i2]['IdSerie'];
          $usa_nota = $res_3[$i2]['StSerieUtilizaAvaliacaoNota'];

          $query_4 = $pdo->query("SELECT * FROM tbserie where IdSerie = '$id_prox_serie' ");
          $res_4 = $query_4->fetchAll(PDO::FETCH_ASSOC);

          $prox_serie = $res_4[0]['NomeSerie'];

          $query_5 = $pdo->query("SELECT * FROM tbcurso where IdCurso = '$id_curso' ");
          $res_5 = $query_5->fetchAll(PDO::FETCH_ASSOC);

          $curso = $res_5[0]['NomeCurso'];

          ?>



          <tr>
            <td><a title="Ver Grade Curricular" class="text-dark" href="index.php?pag=<?php echo $pag ?>&funcao=anosLetivos&id=<?php echo $id ?>"><?php echo $serie ?></a></td>

            <td><?php echo $curso ?></td>

            <td> <?php if(@$prox_serie != ""){ ?>
              <?php echo $prox_serie ?>

            <?php }else{ echo "-"; } ?>


          </td>

          





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

          $query = $pdo->query("SELECT * FROM tbserie where IdSerie = '" . $id2 . "' ");
          $res_3 = $query->fetchAll(PDO::FETCH_ASSOC);

          $serie2 = $res_3[0]['NomeSerie'];
          $id_prox_serie2 = $res_3[0]['IdProximaSerie'];
          $id_curso2 = $res_3[0]['IdCurso'];
          $id_mensalidade2 = $res_3[0]['IdServicoMensalidade'];
          $codigo_serie2 = $res_3[0]['CodigoSerie'];
          $usa_nota2 = $res_3[0]['StSerieUtilizaAvaliacaoNota'];

          $query_4 = $pdo->query("SELECT * FROM tbserie where IdSerie = '$id_prox_serie2' ");
          $res_4 = $query_4->fetchAll(PDO::FETCH_ASSOC);

          $prox_serie2 = $res_4[0]['NomeSerie'];

          $query_5 = $pdo->query("SELECT * FROM tbcurso where IdCurso = '$id_curso2' ");
          $res_5 = $query_5->fetchAll(PDO::FETCH_ASSOC);

          $curso2 = $res_5[0]['NomeCurso'];

          $query_6 = $pdo->query("SELECT * FROM tbservico where IdServico = '$id_mensalidade2' ");
          $res_6 = $query_6->fetchAll(PDO::FETCH_ASSOC);

          $servico2 = $res_6[0]['NomeServico'];


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
            <label >Série</label>
            <input required value="<?php echo @$serie2 ?>" type="text" class="form-control" id="serie-cat" name="serie-cat" placeholder="Nome da Série">
          </div>
          <div class="form-group">
            <label >Curso</label>
            <select required name="curso-cat" class="form-control" id="curso-cat">

              <?php if(!isset($id_curso2)){

               ?> <option selected value="">Selecione o curso</option> 
             <?php } ?> 

             <?php 

             $query = $pdo->query("SELECT * FROM tbcurso order by NomeCurso asc ");
             $res = $query->fetchAll(PDO::FETCH_ASSOC);

             for ($i=0; $i < @count($res); $i++) { 
              foreach ($res[$i] as $key => $value) {
              }
              $nome_reg = $res[$i]['NomeCurso'];
              $id_reg = $res[$i]['IdCurso'];
              ?>                                  
              <option <?php if(@$id_curso2 == $id_reg){ ?> selected <?php } ?> value="<?php echo $id_reg ?>"><?php echo $nome_reg ?></option>
            <?php } ?>

          </select>
        </div>
        <div class="form-group">
          <label >Próxima Série</label>
          <select name="proxima_serie-cat" class="form-control" id="proxima_serie-cat">

            <?php if(!isset($id_prox_serie2)){

             ?> <option selected value="">Selecione a próxima série (se houver)</option> 
           <?php } ?> 

           <?php 

           $query2 = $pdo->query("SELECT * FROM tbserie order by NomeSerie asc ");
           $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

           for ($i=0; $i < @count($res2); $i++) { 
            foreach ($res2[$i] as $key => $value) {
            }
            $nome_reg2 = $res2[$i]['NomeSerie'];
            $id_reg2 = $res2[$i]['IdSerie'];
            ?>

            <option <?php if(@$id_prox_serie2 == $id_reg2){ ?> selected <?php } ?> value="<?php echo $id_reg2 ?>"><?php echo $nome_reg2 ?></option>

          <?php } ?>


        </select>
      </div>
      <div class="form-group">
        <label >Código da Série</label>
        <input value="<?php echo @$codigo_serie2 ?>" type="text" class="form-control" id="codigo-cat" name="codigo-cat" placeholder="Código da Série">
      </div>

      <div class="form-group">
        <label >Utilizada no sistema de avaliação?</label>
        <select class="form-control" name="nota-cat"  id="nota-cat">
          <?php $sim = 1; $nao = 0; ?>
          
          
          <option <?php if (@$usa_nota2 == 1): ?> selected
            
            <?php endif ?> value = "<?php echo $sim ?>">Sim</option>
            
            
            
            <option <?php if (@$usa_nota2 == 0): ?> selected <?php endif ?>  value = "<?php $nao ?>">Não</option>
            
          </select>
        </div>

        <div class="form-group">
          <label >Tipo de Serviço</label>
          <select required name="servico-cat" class="form-control" id="servico-cat">

            <?php if(!isset($id_mensalidade2)){

             ?> <option selected value="">Selecione o tipo de Serviço</option> 
           <?php } ?> 

           <?php 

           $query = $pdo->query("SELECT * FROM tbservico order by NomeServico asc ");
           $res = $query->fetchAll(PDO::FETCH_ASSOC);

           for ($i=0; $i < @count($res); $i++) { 
            foreach ($res[$i] as $key => $value) {
            }
            $nome_reg = $res[$i]['NomeServico'];
            $id_reg = $res[$i]['IdServico'];
            ?>                                  
            <option <?php if(@$id_mensalidade2 == $id_reg){ ?> selected <?php } ?> value="<?php echo $id_reg ?>"><?php echo $nome_reg ?></option>
          <?php } ?>

        </select>
      </div>





      <small>
        <div id="mensagem">

        </div>
      </small> 

    </div>



    <div class="modal-footer">



      <input value="<?php echo @$_GET['id'] ?>" type="hidden" name="txtid2" id="txtid2">
      <input value="<?php echo @$serie2 ?>" type="hidden" name="antigo" id="antigo">


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
        <h5 class="modal-title">Dados da Série</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <?php 
        if (@$_GET['funcao'] == 'endereco') {



          $id2 = $_GET['id'];

          $query = $pdo->query("SELECT * FROM tbserie where IdSerie = '" . $id2 . "' ");
          $res_3 = $query->fetchAll(PDO::FETCH_ASSOC);

          $serie3 = $res_3[0]['NomeSerie'];
          $id_prox_serie3 = $res_3[0]['IdProximaSerie'];
          $id_curso3 = $res_3[0]['IdCurso'];
          $id_mensalidade3 = $res_3[0]['IdServicoMensalidade'];
          $codigo_serie3 = $res_3[0]['CodigoSerie'];

          $query_4 = $pdo->query("SELECT * FROM tbserie where IdSerie = '$id_prox_serie3' ");
          $res_4 = $query_4->fetchAll(PDO::FETCH_ASSOC);

          $prox_serie3 = $res_4[0]['NomeSerie'];

          $query_5 = $pdo->query("SELECT * FROM tbcurso where IdCurso = '$id_curso3' ");
          $res_5 = $query_5->fetchAll(PDO::FETCH_ASSOC);

          $curso3 = $res_5[0]['NomeCurso'];



        }


        ?>
        
        

        <div class="form-group">
          <label >Série</label>
          <input disabled value="<?php echo @$serie3 ?>" type="text" class="form-control" >
        </div>
        <div class="form-group">
          <label >Curso</label>
          <input disabled value="<?php echo @$curso3 ?>" type="text" class="form-control" >

        </div>
        <div class="form-group">
          <label >Próxima Série</label>
          <input disabled value="<?php echo @$prox_serie3 ?>" type="text" class="form-control" >

        </div>
        <div class="form-group">
          <label >Código da Série</label>
          <input disabled  value="<?php echo @$codigo_serie3 ?>" type="text" class="form-control" >
        </div>


      </div>
    </div>
  </div>
</div>

<div class="modal" id="modal-anosLetivos" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ano Letivo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <?php
        $id_serie = $_GET['id']; 
        
        $query = $pdo->query("SELECT * FROM tbperiodo order by IdPeriodo desc ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        $total_notas_curso = 0;
        for ($i=0; $i < count($res); $i++) { 
          foreach ($res[$i] as $key => $value) {
          }

          $sigla = $res[$i]['SiglaPeriodo'];
          $id_ano = $res[$i]['IdPeriodo'];
          




          ?>


          <a title="Ver Grade por Ano Letivo" href="index.php?pag=series&funcao=grade&id=<?php echo $id_serie ?>&id_ano=<?php echo $id_ano ?>" name="btn-salvar-aula" class="btn btn-primary text-light m-1"><?php echo $sigla ?></a>




        <?php } ?>


      </div>




    </div>
  </div>
</div>






<div class="modal" id="modal-grade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Grade Curricular</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <small>
         <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">Disciplinas</th>

            </thead>
            <tbody>

              <?php 

              $id_serie = $_GET['id'];
              $id_ano = $_GET['id_ano'];

                        //VERIFICAR Disciplinas
              $query_3 = $pdo->query("SELECT * FROM tbgradecurricular where IdSerie = '$id_serie' and IdPeriodo = '$id_ano'");
              $res_3 = $query_3->fetchAll(PDO::FETCH_ASSOC);

              for ($i2=0; $i2 < count($res_3); $i2++) { 
                foreach ($res_3[$i2] as $key => $value) {
                }

                $id_disciplinas = $res_3[$i2]['IdDisciplina'];


                $query_4 = $pdo->query("SELECT * FROM tbdisciplina where IdDisciplina = '$id_disciplinas' ");
                $res_4 = $query_4->fetchAll(PDO::FETCH_ASSOC);

                $nome_disciplina = $res_4[0]['NomeDisciplina'];

                ?>


                <tr>

                  <td><?php echo $nome_disciplina ?></td>

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
if (@$_GET["funcao"] != null && @$_GET["funcao"] == "anosLetivos") {
  echo "<script>$('#modal-anosLetivos').modal('show');</script>";
}
if (@$_GET["funcao"] != null && @$_GET["funcao"] == "grade") {
  echo "<script>$('#modal-grade').modal('show');</script>";
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



