<?php 
$pag = "turmas";
require_once("../conexao.php"); 

@session_start();
    //verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'Admin'){
  echo "<script language='javascript'> window.location='../index.php' </script>";

} 


?>

<div class="row mt-4 mb-4">
  <a type="button" title="Cadastrar Nova Turma" class="btn-primary btn-sm ml-3 d-none d-md-block" href="index.php?pag=<?php echo $pag ?>&funcao=novo">Nova Turma</a>
  <a type="button" title="Cadastrar Nova Turma" class="btn-primary btn-sm ml-3 d-block d-sm-none" href="index.php?pag=<?php echo $pag ?>&funcao=novo"><i class="fas fa-user-plus"></i></a>

</div>


<!-- DataTales Example -->
<div class="card shadow mb-4">

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th >Disciplina</th>
            <th class="classe-nova">Sala</th>
            <th class="classe-nova ">Professor</th>
            <th class="classe-nova classe-nova-tel">Horário</th>
            <th class="classe-nova classe-nova-tel">Dias</th>

            <th>Ações</th>
          </tr>
        </thead>

        <tbody>

         <?php 

         $query = $pdo->query("SELECT * FROM turmas order by id desc ");
         $res = $query->fetchAll(PDO::FETCH_ASSOC);

         for ($i=0; $i < count($res); $i++) { 
          foreach ($res[$i] as $key => $value) {
          }

          $disciplina = $res[$i]['disciplina'];
          $sala = $res[$i]['sala'];
          $professor = $res[$i]['professor'];
          $horario = $res[$i]['horario'];
          $dia = $res[$i]['dia'];
          $id = $res[$i]['id'];

          //RECUPERAR NOME DISCIPLINA

          $query_r = $pdo->query("SELECT * FROM disciplinas where id = '$disciplina' ");
          $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);

          $nome_disciplina = $res_r[0]['nome'];

          //RECUPERAR NOME SALA
          
          $query_s = $pdo->query("SELECT * FROM salas where id = '$sala' ");
          $res_s = $query_s->fetchAll(PDO::FETCH_ASSOC);

          $nome_sala = $res_s[0]['sala'];

          //RECUPERAR NOME PROFESSOR
          
          $query_p = $pdo->query("SELECT * FROM professores where id = '$professor' ");
          $res_p = $query_p->fetchAll(PDO::FETCH_ASSOC);

          $nome_prof = @$res_p[0]['nome'];


          ?>


          <tr>
            <td><?php echo @$nome_disciplina ?></td>
            <td class="classe-nova"><?php echo @$nome_sala ?></td>
            <td class="classe-nova "><?php echo @$nome_prof ?></td>
            <td class="classe-nova classe-nova-tel"><?php echo @$horario ?></td>
            <td class="classe-nova classe-nova-tel"><?php echo @$dia ?></td>



            <td>
              <a href="index.php?pag=<?php echo $pag ?>&funcao=endereco&id=<?php echo @$id ?>" class='text-info mr-1' title='Dados da Turma'><i class="fas fa-info-circle"></i></a>

              <a href="index.php?pag=<?php echo $pag ?>&funcao=editar&id=<?php echo @$id ?>" class='text-primary mr-1' title='Editar Dados'><i class='far fa-edit'></i></a>

              <a href="index.php?pag=<?php echo $pag ?>&funcao=excluir&id=<?php echo @$id ?>" class='text-danger mr-1' title='Excluir Registro'><i class='far fa-trash-alt'></i></a>

              <a href="index.php?pag=<?php echo $pag ?>&funcao=matricula&id=<?php echo @$id ?>" class='text-success' title='Matricular Aluno'><i class="fas fa-user-plus"></i></a>

              <a href="index.php?pag=<?php echo $pag ?>&funcao=matriculados&id_turma=<?php echo @$id ?>" class='text-primary ml-1 ' title='Ver Alunos Matriculados'><i class="fas fa-clipboard-list"></i></a>

              



            </td>
          </tr>
        <?php } ?>





      </tbody>
    </table>
  </div>
</div>
</div>





<!-- Modal Mostrar Cadastrar dados-->
<div class="modal fade" id="modalDados" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <?php 
        if (@$_GET['funcao'] == 'editar') {
          $titulo = "Editar Registro";
          $id2 = $_GET['id'];

          $query = $pdo->query("SELECT * FROM turmas where id = '" . $id2 . "' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);

          $disciplina2 = $res[0]['disciplina'];
          $sala2 = $res[0]['sala'];
          $professor2 = $res[0]['professor'];
          $horario2 = $res[0]['horario'];
          $dia2 = $res[0]['dia'];
          $data_inicio2 = $res[0]['data_inicio'];
          $data_final2 = $res[0]['data_final'];
          $valor_mensalidade2 = $res[0]['valor_mensalidade'];
          $ano2 = $res[0]['ano'];




        } else {
          $titulo = "Inserir Registro";

        }


        ?>

        <h5 class="modal-title" id="exampleModalLabel"><?php echo @$titulo ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form" method="POST">
        <div class="modal-body">

         <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="disciplina">Disciplina</label>
              <select required name="disciplina" class="form-control" id="categoria">
                <?php if ($disciplina2 =="") {?>
                  <option value="" selected>Selecione a Disciplina</option>

                  
                <?php } ?>

                <?php 

                $query = $pdo->query("SELECT * FROM disciplinas order by nome asc ");
                $res = $query->fetchAll(PDO::FETCH_ASSOC);

                for ($i=0; $i < @count($res); $i++) { 
                  foreach ($res[$i] as $key => $value) {
                  }
                  $nome_reg = $res[$i]['nome'];
                  $id_reg = $res[$i]['id'];
                  ?> 

                  <option <?php if(@$disciplina2 == $id_reg){ ?> selected <?php } ?> value="<?php echo $id_reg ?>"><?php echo $nome_reg ?></option>
                <?php } ?>

              </select>
            </div>
            
            
            
          </div>




          <div class="col-md-4">
            <div class="form-group">
              <label for="sala">Sala</label>
              <select name="sala" class="form-control" id="sala">
                <?php if ($sala2 =="") {?>
                  <option value="" selected>Selecione a Sala</option>

                  
                <?php } ?>

                <?php 

                $query = $pdo->query("SELECT * FROM salas order by sala asc ");
                $res = $query->fetchAll(PDO::FETCH_ASSOC);

                for ($i=0; $i < @count($res); $i++) { 
                  foreach ($res[$i] as $key => $value) {
                  }
                  $nome_reg_sala = $res[$i]['sala'];
                  $id_reg_sala = $res[$i]['id'];
                  ?>                  
                  <option <?php if(@$sala2 == $id_reg_sala){ ?> selected <?php } ?> value="<?php echo $id_reg_sala ?>"><?php echo $nome_reg_sala ?></option>
                <?php } ?>
                
              </select>
            </div>

          </div>


          <div class="col-md-4">
            <div class="form-group">
              <label for="disciplina">Professor</label>
              <select name="professor" class="form-control" id="professor">
                <?php if ($professor2 =="") {?>
                  <option value="" selected>Selecione o Professor</option>

                  
                <?php } ?>

                <?php 

                $query = $pdo->query("SELECT * FROM professores order by nome asc ");
                $res = $query->fetchAll(PDO::FETCH_ASSOC);

                for ($i=0; $i < @count($res); $i++) { 
                  foreach ($res[$i] as $key => $value) {
                  }
                  $nome_reg = $res[$i]['nome'];
                  $id_reg = $res[$i]['id'];
                  ?>                  
                  <option <?php if(@$professor2 == $id_reg){ ?> selected <?php } ?> value="<?php echo $id_reg ?>"><?php echo $nome_reg ?></option>
                <?php } ?>
                
              </select>
            </div>

          </div>
        </div>


        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="">Data Ínicio</label>
              <input value="<?php echo @$data_inicio2 ?>" type="date" class="form-control" name="data_inicio" id="data_inicio">

            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="">Data Final</label>
              <input value="<?php echo @$data_final2 ?>" type="date" class="form-control" name="data_final" id="data_final">


            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="">Horário Aulas</label>
              <input value="<?php echo @$horario2 ?>" type="text" class="form-control" name="horario" id="horario" placeholder="De xx:xx às xx:xx">

            </div>
          </div>
          


        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="">Dias das Aulas</label>
              <input value="<?php echo @$dia2 ?>" type="text" class="form-control" name="dia" id="dia" placeholder="Segunda à Sexta">

            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="">Valor Mensalidade</label>
              <input value="<?php echo @$valor_mensalidade2 ?>" type="text" class="form-control" name="valor_mensalidade" id="valor_mensalidade" placeholder="Valor da Mensalidade">

            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="">Ano de ínicio</label>
              <input value="<?php echo @$ano2 ?>" type="text" class="form-control" name="ano" id="ano" placeholder="Ano da Turma">

            </div>
          </div>
          


        </div>





        <small>
          <div id="mensagem">

          </div>
        </small> 

      </div>



      <div class="modal-footer">



        <input value="<?php echo @$_GET['id'] ?>" type="hidden" name="txtid2" id="txtid2">
        

        <button type="button" id="btn-fechar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="btn-salvar" id="btn-salvar" class="btn btn-primary">Salvar</button>
      </div>
    </form>
  </div>
</div>
</div>





<!--MODAL PARA EXCLUIR REGISTRO -->
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

        <small><div align="center" id="mensagem_excluir" class=""></small>

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

<!--MODAL PARA MATRICULAR ALUNO -->
<div class="modal" id="modal-matricula" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Matricular Aluno</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">

          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th >Nome do Aluno</th>
                    <th class="classe-nova">Data de Nascimento</th>
                    
                    <th class="classe-nova classe-nova-tel">Telefone do Responsável</th>
                    <th class="">Foto</th>
                    <th>Ações</th>
                  </tr>
                </thead>

                <tbody>

                 <?php 

                 $query = $pdo->query("SELECT * FROM tbaluno order by IdAluno desc ");
                 $res = $query->fetchAll(PDO::FETCH_ASSOC);

                 for ($i=0; $i < count($res); $i++) { 
                  foreach ($res[$i] as $key => $value) {
                  }

                  $nome = $res[$i]['NomeAluno'];
                  $foto = $res[$i]['foto'];


                  $dataNascimento = date('d/m/Y',  strtotime($res[$i]['DataNascimento'])); 



                  $id_aluno = $res[$i]['IdAluno'];
                  $id_responsavel = $res[$i]['IdResponsavel'];

                  $query = $pdo->query("SELECT * FROM tbresponsavel where IdResponsavel = '$id_responsavel' ");
                  $res_r = $query->fetchAll(PDO::FETCH_ASSOC);

                  $nome_responsavel = $res_r[0]['NomeResponsavel'];
                  $celular = $res_r[0]['Celular'];


                  ?>


                  <tr>
                    <td><?php echo @$nome ?></td>
                    <td class="classe-nova"><?php echo @$dataNascimento ?></td> 
                    <td class="classe-nova classe-nova-tel"><?php echo $celular ?></td>
                    <td class="text-center"><a href="index.php?pag=<?php echo @$pag ?>&funcao=foto&id=<?php echo @$id ?>"><img width="30" src="../img/alunos/<?php echo $foto ?>"><a></td>



                      <td>
                        <a href="index.php?pag=<?php echo @$pag ?>&funcao=confirmar&id_turma=<?php echo @$_GET['id'] ?>&id_aluno=<?php echo @$id_aluno ?>" class='text-info mr-1' title='Confirmar Matrícula'><i class="fas fa-check"></i></a>



                      </td>
                    </tr>
                  <?php } ?>





                </tbody>
              </table>
            </div>
          </div>
        </div>
        

      </div>
      
    </div>
  </div>
</div>



<!--MODAL PARA MOSTRAR DADOS COMPLETOS -->
<div class="modal" id="modal-endereco" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Dados da Turma</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <?php 
        if (@$_GET['funcao'] == 'endereco') {

          $id2 = $_GET['id'];

          $query = $pdo->query("SELECT * FROM turmas where id = '" . $id2 . "' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);

          $disciplina3 = $res[0]['disciplina'];
          $sala3 = $res[0]['sala'];
          $professor3 = $res[0]['professor'];
          $horario3 = $res[0]['horario'];
          $dia3 = $res[0]['dia'];
          $data_inicio3 = $res[0]['data_inicio'];
          $data_final3 = $res[0]['data_final'];
          $valor_mensalidade3 = $res[0]['valor_mensalidade'];
          $ano3 = $res[0]['ano'];

          $valor_mensalidade3F = number_format($valor_mensalidade3, 2, ',', '.');

          //RECUPERAR NOME DISCIPLINA

          $query_r3 = $pdo->query("SELECT * FROM disciplinas where id = '$disciplina3' ");
          $res_r3 = $query_r3->fetchAll(PDO::FETCH_ASSOC);

          $nome_disciplina3 = @$res_r3[0]['nome'];

          //RECUPERAR NOME SALA
          
          $query_s3 = $pdo->query("SELECT * FROM salas where id = '$sala3' ");
          $res_s3 = $query_s3->fetchAll(PDO::FETCH_ASSOC);

          $nome_sala3 = @$res_s3[0]['sala'];

          //RECUPERAR NOME PROFESSOR
          
          $query_p3 = $pdo->query("SELECT * FROM professores where id = '$professor3' ");
          $res_p3 = $query_p3->fetchAll(PDO::FETCH_ASSOC);

          $nome_prof3 = @$res_p3[0]['nome'];


        } 


        ?>

        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="disciplina">Disciplina</label>
              <select disabled class="form-control" >

               <option  selected value="<?php echo $nome_disciplina3 ?>"><?php echo @$nome_disciplina3 ?></option>


             </select>
           </div>


         </div>

         <div class="col-md-4">
          <div class="form-group">
            <label for="sala">Sala</label>
            <select disabled  class="form-control" >


              <option  selected value="<?php echo $nome_sala3 ?>"><?php echo @$nome_sala3 ?></option>


            </select>
          </div>

        </div>


        <div class="col-md-4">
          <div class="form-group">
            <label for="disciplina">Professor</label>
            <select disabled  class="form-control" >


              <option selected value="<?php echo $nome_prof3?>"><?php echo @$nome_prof3 ?></option>


            </select>
          </div>

        </div>
      </div>


      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="">Data Ínicio</label>
            <input disabled value="<?php echo @$data_inicio3 ?>" type="date" class="form-control" >

          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="">Data Final</label>
            <input disabled value="<?php echo @$data_final3 ?>" type="date" class="form-control" >


          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="">Horário Aulas</label>
            <input disabled value="<?php echo @$horario3 ?>" type="text" class="form-control">

          </div>
        </div>



      </div>

      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="">Dias das Aulas</label>
            <input disabled value="<?php echo @$dia3 ?>" type="text" class="form-control" >

          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="">Valor Mensalidade</label>
            <input disabled value="<?php echo 'R$ '. @$valor_mensalidade3F ?>" type="text" class="form-control" >

          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="">Ano de ínicio</label>
            <input disabled value="<?php echo @$ano3 ?>" type="text" class="form-control" >

          </div>
        </div>



      </div>



    </div>
  </div>
</div>
</div>



<!--MODAL PARA MOSTRAR ALUNOS MATRICULADOS -->
<div class="modal" id="modal-matriculados" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Alunos Matriculados</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php 
        $query = $pdo->query("SELECT * FROM matriculas where turma = '$_GET[id_turma]' order by id desc ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);

        for ($i=0; $i < count($res); $i++) { 
          foreach ($res[$i] as $key => $value) {
          }

          $aluno = $res[$i]['aluno'];
          $id_m = $res[$i]['id'];
          
          $query_r1 = $pdo->query("SELECT * FROM tbaluno where IdAluno = '".$aluno."' ");
          $res_r1 = $query_r1->fetchAll(PDO::FETCH_ASSOC);

          $nome_aluno = $res_r1[0]['NomeAluno'];


          ?>
        

         <span><small><?php echo @$nome_aluno ?><a title="Excluir Matrícula" href="index.php?pag=<?php echo $pag ?>&funcao=excluir_matricula&id_m=<?php echo $id_m ?>&id_turma=<?php echo $_GET['id_turma'] ?>"><i class="fas fa-user-times text-danger ml-3"></i></small></span></a>

         <hr style="margin: 4px">

       <?php } ?>

       <div align="center" id="mensagem" class="">

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

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "matricula") {
  echo "<script>$('#modal-matricula').modal('show');</script>";
}
if (@$_GET["funcao"] != null && @$_GET["funcao"] == "confirmar") {
  $id_turma = $_GET['id_turma'];
  $id_aluno = $_GET['id_aluno'];

  $query_r = $pdo->query("SELECT * FROM matriculas where turma = '$id_turma ' and aluno = '$id_aluno' ");
  $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);

  if (@count($res_r) == 0) {
    $res = $pdo->query("INSERT INTO matriculas SET turma = '$id_turma', aluno = '$id_aluno', data = curDate()");
    
  }
  
  echo "<script>window.location='index.php?pag=$pag&id_turma=$id_turma&id_aluno=$id_aluno&funcao=matriculados';</script>";
  
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "matriculados") {
  echo "<script>$('#modal-matriculados').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "excluir_matricula") {
  $id_matricula = $_GET['id_m'];
  $id_turma2 = $_GET['id_turma'];

  $res = $pdo->query("DELETE FROM matriculas WHERE id = '$id_matricula'");


  echo "<script>window.location='index.php?pag=$pag&id_turma=$id_turma2&id_aluno=$id_aluno&funcao=matriculados';</script>";

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

          $('#mensagem_excluir').addClass('text-danger')
          $('#mensagem_excluir').text(mensagem)



        },

      })
    })
  })
</script>



<!--SCRIPT PARA CARREGAR IMAGEM -->
<script type="text/javascript">

  function carregarImg() {

    var target = document.getElementById('target');
    var file = document.querySelector("input[type=file]").files[0];
    var reader = new FileReader();

    reader.onloadend = function () {
      target.src = reader.result;
    };

    if (file) {
      reader.readAsDataURL(file);


    } else {
      target.src = "";
    }
  }

</script>





<script type="text/javascript">
  $(document).ready(function () {
    $('#dataTable').dataTable({
      "ordering": false
    })
    $('#dataTable2').dataTable({
      "ordering": false
    })

  });
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>

<script src="../js/mascaras.js"></script>

<script>
  function maiuscula(string){
    res = string.value.toUpperCase();

    string.value=res;
  }
</script>



