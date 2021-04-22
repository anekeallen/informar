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
      <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr class="bg-primary text-white">
            <th >Turma</th>
            <th class="classe-nova">Série</th>
            <th class="classe-nova classe-nova-tel">Sigla</th>
            <th class="classe-nova ">Ano</th>
            <th class="classe-nova classe-nova-tel">Turno</th>
            <th class="classe-nova classe-nova-tel">Sala</th>
            

            <th>Ações</th>
          </tr>
        </thead>

        <tbody>

         <?php 

         $query = $pdo->query("SELECT * FROM tbturma order by IdTurma desc ");
         $res = $query->fetchAll(PDO::FETCH_ASSOC);

         for ($i=0; $i < count($res); $i++) { 
          foreach ($res[$i] as $key => $value) {
          }

          $id_periodo = $res[$i]['IdPeriodo'];
          $id_serie = $res[$i]['IdSerie'];
          $nome_turma = $res[$i]['NomeTurma'];
          $sigla_turma = $res[$i]['SiglaTurma'];
          $turno = $res[$i]['TurnoPrincipal'];
          $vagas = $res[$i]['TotalVagas'];
          //$codigo = $res[$i]['CodigoAgrupamento'];
          $id_sala = $res[$i]['IdSala'];
          $id = $res[$i]['IdTurma'];

          //RECUPERAR NOME Série

          $query_3 = $pdo->query("SELECT * FROM tbserie where IdSerie = '$id_serie'");
          $res_3 = $query_3->fetchAll(PDO::FETCH_ASSOC);

          $serie = $res_3[0]['NomeSerie'];
          $id_prox_serie = $res_3[0]['IdProximaSerie'];
          $id_curso = $res_3[0]['IdCurso'];


          //RECUPERAR Ano Letivo

          $query4 = $pdo->query("SELECT * FROM tbperiodo where IdPeriodo = $id_periodo ");
          $res4 = $query4->fetchAll(PDO::FETCH_ASSOC);

          $periodo = $res4[0]['NomePeriodo'];
          $dataInicial = $res4[0]['DataInicial'];
          $dataFinal = $res4[0]['DataFinal'];




          $query_s = $pdo->query("SELECT * FROM salas where id = '$id_sala' ");
          $res_s = $query_s->fetchAll(PDO::FETCH_ASSOC);

          $sala = @$res_s[0]['sala'];


          ?>


          <tr class="table-light">
            <td><?php echo @$nome_turma ?></td> 
            <td class="classe-nova"><?php echo @$serie ?></td>
            <td class="classe-nova "><?php echo @$sigla_turma ?></td>
            <td class="classe-nova classe-nova-tel"><?php echo @$periodo ?></td>
            <td class="classe-nova classe-nova-tel"><?php echo @$turno ?></td>
            <td class="classe-nova classe-nova-tel"><?php echo @$sala ?></td>



            <td>
              <a href="index.php?pag=<?php echo $pag ?>&funcao=endereco&id=<?php echo @$id ?>" class='text-info mr-1' title='Dados da Turma'><i class="fas fa-info-circle"></i></a>

              <a href="index.php?pag=<?php echo $pag ?>&funcao=editar&id=<?php echo @$id ?>" class='text-primary mr-1' title='Editar Dados'><i class='far fa-edit'></i></a>

              <a href="index.php?pag=<?php echo $pag ?>&funcao=excluir&id=<?php echo @$id ?>" class='text-danger mr-1' title='Excluir Registro'><i class='far fa-trash-alt'></i></a>

              <a href="index.php?pag=<?php echo $pag ?>&funcao=matricula&id=<?php echo @$id ?>" class='text-success' title='Matricular Aluno'><i class="fas fa-user-plus"></i></a>

              <a href="index.php?pag=<?php echo $pag ?>&funcao=matriculados&id_turma=<?php echo @$id ?>" class='text-primary ml-1 ' title='Ver Alunos Matriculados'><i class="fas fa-clipboard-list"></i></a>

              <a href="index.php?pag=<?php echo $pag ?>&funcao=professores&id_turma=<?php echo @$id ?>" class='text-success ml-2 ' title='Cadastrar Professores na Turma'><i class="fas fa-id-badge"></i></a>






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


          $query = $pdo->query("SELECT * FROM tbturma where IdTurma = '" . $id2 . "' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);

          
          $id_periodo2 = $res[0]['IdPeriodo'];
          $id_serie2 = $res[0]['IdSerie'];
          $nome_turma2 = $res[0]['NomeTurma'];
          $sigla_turma2 = $res[0]['SiglaTurma'];
          $turno2 = $res[0]['TurnoPrincipal'];
          $vagas2 = $res[0]['TotalVagas'];
          $codigo2 = $res[0]['CodigoAgrupamento'];
          $id_sala2 = $res[0]['IdSala'];
          $id = $res[0]['IdTurma'];
          $dataInicial2 = $res[0]['DataInicial'];
          $dataFinal2 = $res[0]['DataFinal'];



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
              <label for="serie">Série</label>
              <select required name="serie" class="form-control" id="serie">
                <?php if ($id_serie2 =="") {?>
                  <option value="" selected>Selecione a Série</option>

                  
                <?php } ?>

                <?php 

                $query = $pdo->query("SELECT * FROM tbserie order by NomeSerie asc ");
                $res = $query->fetchAll(PDO::FETCH_ASSOC);

                for ($i=0; $i < @count($res); $i++) { 
                  foreach ($res[$i] as $key => $value) {
                  }
                  $nome_reg = $res[$i]['NomeSerie'];
                  $id_reg = $res[$i]['IdSerie'];
                  ?> 

                  <option <?php if(@$id_serie2 == $id_reg){ ?> selected <?php } ?> value="<?php echo $id_reg ?>"><?php echo $nome_reg ?></option>
                <?php } ?>

              </select>
            </div>
            
            
            
          </div>


          <div class="col-md-4">
            <div class="form-group">
              <label for="ano">Ano Letivo</label>
              <select required name="ano" class="form-control" id="ano">
                <?php if ($id_periodo2 == "") {?>
                  <option value="" selected>Selecione o ano letivo</option>

                  
                <?php } ?>

                <?php 

                $query = $pdo->query("SELECT * FROM tbperiodo order by IdPeriodo desc ");
                $res = $query->fetchAll(PDO::FETCH_ASSOC);

                for ($i=0; $i < @count($res); $i++) { 
                  foreach ($res[$i] as $key => $value) {
                  }
                  $nome_reg_sala = $res[$i]['SiglaPeriodo'];
                  $id_reg_sala = $res[$i]['IdPeriodo'];
                  ?>                  
                  <option <?php if(@$id_periodo2 == $id_reg_sala){ ?> selected <?php } ?> value="<?php echo $id_reg_sala ?>"><?php echo $nome_reg_sala ?></option>
                <?php } ?>
                
              </select>
            </div>

          </div>




          <div class="col-md-4">
            <div class="form-group">
              <label for="sala">Sala</label>
              <select name="sala" class="form-control" id="sala">
                <?php if ($id_sala2 == 0) {?>
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
                  <option <?php if(@$id_sala2 == $id_reg_sala){ ?> selected <?php } ?> value="<?php echo $id_reg_sala ?>"><?php echo $nome_reg_sala ?></option>
                <?php } ?>
                
              </select>
            </div>

          </div>



          
        </div>


        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="data_inicio">Data Ínicio</label>
              <input value="<?php echo @$dataInicial2 ?>" type="date" class="form-control" name="data_inicio" id="data_inicio">

            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="data_final">Data Final</label>
              <input value="<?php echo @$dataFinal2 ?>" type="date" class="form-control" name="data_final" id="data_final">


            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="">Turno</label>
              <input required value="<?php echo @$turno2 ?>" maxlength="1" onkeyup="maiuscula(this)" type="text" class="form-control" name="turno" id="turno" placeholder="ex: M, T, N">

            </div>
          </div>
          


        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="sigla">Sigla da Turma</label>
              <input required onkeyup="maiuscula(this)" value="<?php echo @$sigla_turma2 ?>" type="text" class="form-control" name="sigla" id="sigla" placeholder="ex: EF1A, EF2B ...">

            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="nome-turma">Tipo Turma</label>
              <input required value="<?php echo @$nome_turma2 ?>" type="text" class="form-control" name="nome-turma" id="nome-turma" placeholder="ex: A, B..." onkeyup="maiuscula(this)">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="vagas">Total de Vagas</label>
              <input value="<?php echo @$vagas2 ?>" type="number" class="form-control" name="vagas" id="vagas" placeholder="Total de Vagas">

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
        <input value="<?php echo @$sigla_turma2 ?>" type="hidden" name="antigo" id="antigo">
        

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

<!--MODAL PARA EXCLUIR Matricula -->
<div class="modal" id="modal-excluir-matricula" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Excluir Matrícula</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <span class="text-danger">
          <p>Deseja realmente excluir a matrícula desse aluno? Todos os dados do aluno serão excluídos dessa turma, como notas, faltas etc.</p></span>

          <small><div align="center" id="mensagem_excluir-matricula" class=""></small>

          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-excluir-matricula">Cancelar</button>


          <button type="button" id="btn-excluir-matricula" name="btn-excluir-matricula" class="btn btn-danger">Excluir</button>

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
              <div class="table-responsive ">
                <table class="table table-hover table-bordered" id="dataTable2" width="100%" cellspacing="0">
                  <thead>
                    <tr class="bg-primary text-nowrap text-white">
                      <th >Nome do Aluno</th>
                      <th class="classe-nova">Data de Nascimento</th>

                      <th class="classe-nova classe-nova-tel">Tel do Responsável</th>

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


                    <tr class="table-light">
                      <td><?php echo @$nome ?></td>
                      <td class="classe-nova"><?php echo @$dataNascimento ?></td> 
                      <td class="classe-nova classe-nova-tel"><?php echo $celular ?></td>




                      <td>
                        <a href="index.php?pag=<?php echo @$pag ?>&funcao=confirmar&id_turma=<?php echo @$_GET['id'] ?>&id_aluno=<?php echo @$id_aluno ?>&id_responsavel=<?php echo $id_responsavel?>" class='text-info mr-1' title='Confirmar Matrícula'><i class="fas fa-check"></i></a>



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

          $query = $pdo->query("SELECT * FROM tbturma where IdTurma = '" . $id2 . "' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);

          
          $id_periodo3 = $res[0]['IdPeriodo'];
          $id_serie3 = $res[0]['IdSerie'];
          $nome_turma3 = $res[0]['NomeTurma'];
          $sigla_turma3 = $res[0]['SiglaTurma'];
          $turno3 = $res[0]['TurnoPrincipal'];
          $vagas3 = $res[0]['TotalVagas'];
          
          $id_sala3 = $res[0]['IdSala'];
          $id = $res[0]['IdTurma'];
          $dataInicial3 = $res[0]['DataInicial'];
          $dataFinal3 = $res[0]['DataFinal'];


        } 


        ?>

        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="">Série</label>
              <select disabled  class="form-control" >
                <?php if ($id_serie3 =="") {?>
                  <option value="" selected>Selecione a Série</option>

                  
                <?php } ?>

                <?php 

                $query = $pdo->query("SELECT * FROM tbserie order by NomeSerie asc ");
                $res = $query->fetchAll(PDO::FETCH_ASSOC);

                for ($i=0; $i < @count($res); $i++) { 
                  foreach ($res[$i] as $key => $value) {
                  }
                  $nome_reg = $res[$i]['NomeSerie'];
                  $id_reg = $res[$i]['IdSerie'];
                  ?> 

                  <option <?php if(@$id_serie3 == $id_reg){ ?> selected <?php } ?> value="<?php echo $id_reg ?>"><?php echo $nome_reg ?></option>
                <?php } ?>

              </select>
            </div>
            
            
            
          </div>


          <div class="col-md-4">
            <div class="form-group">
              <label for="ano">Ano Letivo</label>
              <select disabled  class="form-control" >
                <?php if ($id_periodo3 =="") {?>
                  <option value="" selected>Selecione o ano letivo</option>

                  
                <?php } ?>

                <?php 

                $query = $pdo->query("SELECT * FROM tbperiodo order by IdPeriodo desc ");
                $res = $query->fetchAll(PDO::FETCH_ASSOC);

                for ($i=0; $i < @count($res); $i++) { 
                  foreach ($res[$i] as $key => $value) {
                  }
                  $nome_reg_periodo = $res[$i]['SiglaPeriodo'];
                  $id_reg_periodo = $res[$i]['IdPeriodo'];
                  ?>                  
                  <option <?php if(@$id_periodo3 == $id_reg_periodo){ ?> selected <?php } ?> value="<?php echo $id_reg_periodo ?>"><?php echo $nome_reg_periodo ?></option>
                <?php } ?>
                
              </select>
            </div>

          </div>




          <div class="col-md-4">
            <div class="form-group">
              <label for="sala">Sala</label>
              <select disabled  class="form-control">
                <?php if ($id_sala3 == 0) {?>
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
                  <option <?php if(@$id_sala3 == $id_reg_sala){ ?> selected <?php } ?> value="<?php echo $id_reg_sala ?>"><?php echo $nome_reg_sala ?></option>
                <?php } ?>
                
              </select>
            </div>

          </div>



          
        </div>


        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="data_inicio">Data Ínicio</label>
              <input disabled value="<?php echo @$dataInicial3 ?>" type="date" class="form-control" >

            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="data_final">Data Final</label>
              <input disabled value="<?php echo @$dataFinal3 ?>" type="date" class="form-control">


            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="">Turno</label>
              <input disabled value="<?php echo @$turno3 ?>" maxlength="1"  type="text" class="form-control" >

            </div>
          </div>
          


        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="">Sigla da Turma</label>
              <input disabled value="<?php echo @$sigla_turma3 ?>" type="text" class="form-control">

            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="nome-turma">Tipo Turma</label>
              <input disabled value="<?php echo @$nome_turma3 ?>" type="text" class="form-control">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="vagas">Total de Vagas</label>
              <input disabled value="<?php echo @$vagas3 ?>" type="number" class="form-control">

            </div>
          </div>
          


        </div>


      </div>
    </div>
  </div>
</div>



<!--MODAL PARA MOSTRAR ALUNOS MATRICULADOS -->
<div class="modal" id="modal-matriculados" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <?php                 
        $id3 = $_GET['id_turma'];

        $query = $pdo->query("SELECT * FROM tbturma where IdTurma = '" . $id3 . "' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);


        $id_periodo4 = $res[0]['IdPeriodo'];
        $id_serie4 = $res[0]['IdSerie'];
        $nome_turma4 = $res[0]['NomeTurma'];
        $sigla_turma4 = $res[0]['SiglaTurma'];
        $turno4 = $res[0]['TurnoPrincipal'];

        $query = $pdo->query("SELECT * FROM tbperiodo where IdPeriodo = '$id_periodo4' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);

        $nome_periodo = $res[0]['SiglaPeriodo'];



        $query = $pdo->query("SELECT * FROM tbserie where IdSerie = '$id_serie4' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);

        $nome_serie = $res[0]['NomeSerie'];
        $id_curso = $res[0]['IdCurso'];

        $query = $pdo->query("SELECT * FROM tbcurso where IdCurso = '$id_curso' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);

        $nome_curso = $res[0]['NomeCurso'];



        ?>
        <h5 class="modal-title">Alunos Matriculados - <?php echo $nome_curso ?> / <?php echo $nome_serie ?> / <?php echo $nome_turma4 ?> / <?php echo $turno4 ?> / <?php echo $nome_periodo ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php $query = $pdo->query("SELECT * FROM tbalunoturma where IdTurma = '$_GET[id_turma]' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC); 



        if (count($res) != 0) {

          ?>



          <small>
           <table class="table table-hover">
            <thead>
              <tr class="bg-primary text-white">
                <th scope="col">Aluno</th>
                <th scope="col">Situação do Aluno</th>
                <th scope="col">Ação</th>
                <th scope="col">Relatórios</th>

              </thead>
              <tbody>
                <?php 


                for ($i=0; $i < count($res); $i++) { 
                  foreach ($res[$i] as $key => $value) {
                  }

                  $id_aluno = $res[$i]['IdAluno'];
                  $id_situacao = $res[$i]['IdSituacaoAlunoTurma'];

                  $query_r1 = $pdo->query("SELECT * FROM tbaluno where IdAluno = '".$id_aluno."' ");
                  $res_r1 = $query_r1->fetchAll(PDO::FETCH_ASSOC);

                  $nome_aluno = $res_r1[0]['NomeAluno'];
                  $id_responsavelFinaceiro = $res_r1[0]['IdResponsavel'];

                  $query_r2 = $pdo->query("SELECT * FROM tbsituacaoalunoturma where IdSituacaoAlunoTurma = '".$id_situacao."' ");
                  $res_r2 = $query_r2->fetchAll(PDO::FETCH_ASSOC);

                  $situacao = $res_r2[0]['SituacaoAlunoTurma'];

                  if($situacao == 'Aprovado'){
                    $classe_table = 'table-success';
                    $classe_sit = 'text-success';
                  }elseif ($situacao == 'Progressão parcial' or $situacao == 'Cancelado' or $situacao == 'Transferido' or $situacao == 'Desistente') {
                    $classe_table = 'table-warning';
                    $classe_sit = 'text-warning';
                  }elseif ($situacao == 'Reprovado') {
                    $classe_table = 'table-danger';
                    $classe_sit = 'text-danger';
                  }else{
                    $classe_table = 'table-light';
                    $classe_sit = 'text-dark';
                  }

                 // $query = $pdo->query("SELECT * FROM tbalunoturma where IdAluno = '$id_aluno' order by IdAlunoTurma desc ");
                 // $res24 = $query->fetchAll(PDO::FETCH_ASSOC);

                 // $id_m = $res24[0]['IdAlunoTurma'];



                  ?>

                  <tr class="<?php echo $classe_table ?> text-dark">
                    <td class=""><?php echo @$nome_aluno ?></td>

                    <td class="<?php echo $classe_sit ?>"><?php echo @$situacao ?></td>


                    <td><span>

                      <a title="Aluno Transferido" href="index.php?pag=<?php echo $pag ?>&funcao=transferir&id_aluno=<?php echo $id_aluno?>&id_turma=<?php echo $_GET['id_turma'] ?>"><i class="fas fa-walking text-info"></i>
                      </a>



                      <a title="Cancelar Matrícula" href="index.php?pag=<?php echo $pag ?>&funcao=cancelar_matricula&id_aluno=<?php echo $id_aluno?>&id_turma=<?php echo $_GET['id_turma'] ?>"><i class="fas fa-user-times text-warning ml-2"></i>
                      </a>

                      <a title="Excluir Matricula" href="index.php?pag=<?php echo $pag ?>&funcao=excluir_matricula&id_aluno=<?php echo $id_aluno?>&id_turma=<?php echo $_GET['id_turma'] ?>"><i class="fas fa-trash-alt text-danger ml-2"></i>
                      </a>


                    </span>
                  </td>

                  <td>
                    

                      <a target="_blank" title="Gerar Declaração Matrícula" href="../rel/declaracao_matricula_html.php?&id_aluno=<?php echo $id_aluno?>&id_turma=<?php echo $_GET['id_turma']?>"><i class="far fa-clipboard text-info ml-2"></i></span></a>

                      <a target="_blank" title="Gerar Ficha Individual" href="../rel/ficha_individual_html.php?&id_aluno=<?php echo $id_aluno?>&id_turma=<?php echo $_GET['id_turma'] ?>"><i class="far fa-clipboard text-primary ml-2"></i></span></a>


                      
                      <?php if ($situacao == 'Aprovado') { ?>

                        <a target="_blank" title="Gerar Declaração de Aprovação" href="../rel/declaracao_aprovacao_html.php?&id_aluno=<?php echo $id_aluno?>&id_turma=<?php echo $_GET['id_turma'] ?>"><i class="far fa-clipboard text-success ml-2"></i></span></a> 

                         <a target="_blank" title="Gerar Declaração de Transferência" href="../rel/declaracao_transferencia_html.php?&id_aluno=<?php echo $id_aluno?>&id_turma=<?php echo $_GET['id_turma'] ?>"><i class="far fa-clipboard text-danger ml-2"></i></span></a>

                </tr>

              <?php } } ?>

            </tbody>
          </table>
        </small>


        <div align="center" id="mensagem" class="">

        </div>
      <?php }else { ?>

        <span class="text-danger">Não existem alunos matriculados nessa turma!</span>
      <?php } ?>


    </div>

  </div>
</div>
</div>

<div class="modal" id="modal-professores" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cadastrar Professores nas Disciplinas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <?php  

        $id_turma = $_GET['id_turma'];

        $query_5 = $pdo->query("SELECT * FROM tbturma where Idturma = '$id_turma'");
        $res_5 = $query_5->fetchAll(PDO::FETCH_ASSOC);

        $id_serie = $res_5[0]['IdSerie'];
        $id_ano = $res_5[0]['IdPeriodo'];

                        //VERIFICAR Disciplinas
        $query_3 = $pdo->query("SELECT * FROM tbgradecurricular where IdSerie = '$id_serie' and IdPeriodo = '$id_ano'");
        $res_3 = $query_3->fetchAll(PDO::FETCH_ASSOC);

        if (count($res_3) == 0) {
          echo "<span class='text-danger'>Cadastre ou renove a Grade Curricular!</span>";


        }



        ?>
        <?php if (count($res_3) != 0): ?>


          <small>
           <table class="table table-hover table-sm">
            <form method="post" id="form-prof">
              <thead class="bg-primary text-white">
                <tr class="text-center">
                  <th scope="col">Disciplinas</th>
                  <th scope="col">Escolher Professor</th>

                </thead>
                <tbody>

                  <?php 



                  for ($i2=0; $i2 < count($res_3); $i2++) { 
                    foreach ($res_3[$i2] as $key => $value) {
                    }

                    $id_disciplinas = $res_3[$i2]['IdDisciplina'];


                    $query_4 = $pdo->query("SELECT * FROM tbdisciplina where IdDisciplina = '$id_disciplinas' ");
                    $res_4 = $query_4->fetchAll(PDO::FETCH_ASSOC);

                    $nome_disciplina = $res_4[0]['NomeDisciplina'];

                    ?>

                    <input type="hidden"  name="id_disc[]" value="<?php echo @$id_disciplinas ?>">
                    <tr class="table-primary text-dark">

                      <td class="text-nowrap "><?php echo @$nome_disciplina ?></td>

                      <td>
                        <select name="id_profe[]" class="form-control form-control-sm">
                          <option selected value="">Selecione o Professor</option>
                          <?php 
                          $query = $pdo->query("SELECT * FROM tbprofessordisciplina where IdDisciplina = '$id_disciplinas' ");
                          $res = $query->fetchAll(PDO::FETCH_ASSOC);

                          for ($i=0; $i < count($res); $i++) { 
                            foreach ($res[$i] as $key => $value) {
                            }

                            $id_professor = $res[$i]['IdProfessor'];

                            $query11 = $pdo->query("SELECT * FROM tbprofessor where IdProfessor = '$id_professor'");
                            $res11 = $query11->fetchAll(PDO::FETCH_ASSOC);

                            $nome_professor = $res11[0]['NomeProfessor'];

                            $query12 = $pdo->query("SELECT * FROM tbturmaprofessor where IdProfessor = '$id_professor' and IdDisciplina = '$id_disciplinas' and IdTurma = '$id_turma'");
                            $res12 = $query12->fetchAll(PDO::FETCH_ASSOC);


                            ?>

                            <?php if (@count($res12) != 0){ ?>
                              <option selected value="<?php echo $id_professor ?>"><?php echo @$nome_professor ?></option>

                              <?php 
                              continue;
                            }else{ ?>

                              <option value="<?php echo $id_professor ?>"><?php echo @$nome_professor ?></option>


                            <?php }}?>

                          </select>

                        </td>



                      </tr>

                    <?php  }  ?>

                  </tbody>
                </table>
              </small>
            <?php endif ?>


          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-prof">Cancelar</button>


            <input type="hidden" id="id-turma"  name="id-turma" value="<?php echo @$_GET['id_turma'] ?>" required>
            <?php if (count($res_3) != 0): ?>
              <button type="submit" id="btn-salvar-prof" name="btn-salvar-prof" class="btn btn-primary">Salvar</button>
            <?php endif ?>
          </form>
        </div>
        <div align="center" id="mensagem-prof" class="">
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
      $id_resp = $_GET['id_responsavel'];

      $query_r = $pdo->query("SELECT * FROM tbalunoturma where IdTurma = '$id_turma ' and IdAluno = '$id_aluno'");
      $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);

      $t = count($res_r);

      if (@count($res_r) == 0) {
        $res = $pdo->query("INSERT INTO tbalunoturma SET IdTurma = '$id_turma', IdAluno = '$id_aluno', DataSituacaoAtivo = curDate(), IdSituacaoAlunoTurma = 1, IdResponsavelFinanceiro = '$id_resp' ");

        //Select para pegar id da serie e do periodo
        $query = $pdo->query("SELECT * FROM tbturma where IdTurma = '$id_turma'");
        $res2 = $query->fetchAll(PDO::FETCH_ASSOC);
        $id_serieRES = $res2[0]['IdSerie'];
        $id_periodoRES = $res2[0]['IdPeriodo'];

        $query = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$id_periodoRES' and IdSerie = '$id_serieRES' and NumeroFase = 1");
        $res2 = $query->fetchAll(PDO::FETCH_ASSOC);
        $id_fase_nota = $res2[0]['IdFaseNota'];


      //Selecionar as disciplinas
        $query3 = $pdo->query("SELECT * FROM tbgradecurricular where IdSerie = '$id_serieRES' and IdPeriodo = '$id_periodoRES'");
        $res3 = $query3->fetchAll(PDO::FETCH_ASSOC);

        for ($i=0; $i < count($res3); $i++) { 
          foreach ($res3[$i] as $key => $value) {
          }

          $id_disciplina2 = $res3[$i]['IdDisciplina'];

          $pdo->query("INSERT INTO tbsituacaoalunodisciplina SET IdTurma = '$id_turma', IdAluno ='$id_aluno', SituacaoAtual ='Cursando', IdFaseNotaAtual = '$id_fase_nota', IdDisciplina = '$id_disciplina2'");

        }    

      } else{
        echo "<script>alert('Aluno já matriculado na turma!')</script>";
      

      }

       echo "<script>window.location='index.php?pag=$pag&id_turma=$id_turma&id_aluno=$id_aluno&funcao=matriculados';</script>";

    }

      if (@$_GET["funcao"] != null && @$_GET["funcao"] == "matriculados") {
        echo "<script>$('#modal-matriculados').modal('show');</script>";
      }

      if (@$_GET["funcao"] != null && @$_GET["funcao"] == "excluir_matricula") {
        $id_aluno2 = $_GET['id_aluno'];
        $id_turma2 = $_GET['id_turma'];

        echo "<script>$('#modal-excluir-matricula').modal('show');</script>";




      // echo "<script>window.location='index.php?pag=$pag&id_turma=$id_turma2&id_aluno=$id_aluno2&funcao=matriculados';</script>";

      } if (@$_GET["funcao"] != null && @$_GET["funcao"] == "transferir") {
        $id_aluno3 = $_GET['id_aluno'];
        $id_turma3 = $_GET['id_turma'];

        $query = $pdo->query("SELECT * FROM tbsituacaoalunoturma where SituacaoAlunoTurma = 'Transferido'");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);

        $id_situacao_turma = $res[0]['IdSituacaoAlunoTurma'];

        $pdo->query("UPDATE tbalunoturma SET IdSituacaoAlunoTurma = '$id_situacao_turma' where IdTurma = '$id_turma3' and IdAluno = '$id_aluno3'");

        $pdo->query("UPDATE tbsituacaoalunodisciplina SET SituacaoAtual = 'Transferido' WHERE IdAluno = '$id_aluno3' and IdTurma = '$id_turma3'");


        echo "<script>window.location='index.php?pag=$pag&id_turma=$id_turma3&id_aluno=$id_aluno3&funcao=matriculados';</script>";

      } if (@$_GET["funcao"] != null && @$_GET["funcao"] == "cancelar_matricula") {
        $id_aluno4 = $_GET['id_aluno'];
        $id_turma4 = $_GET['id_turma'];

        $query = $pdo->query("SELECT * FROM tbsituacaoalunoturma where SituacaoAlunoTurma = 'Cancelado'");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);

        $id_situacao_turma = $res[0]['IdSituacaoAlunoTurma'];

        $pdo->query("UPDATE tbalunoturma SET IdSituacaoAlunoTurma = '$id_situacao_turma' where IdTurma = '$id_turma4' and IdAluno = '$id_aluno4'");

        $pdo->query("UPDATE tbsituacaoalunodisciplina SET SituacaoAtual = 'Cancelado' WHERE IdAluno = '$id_aluno4' and IdTurma = '$id_turma4'");


        echo "<script>window.location='index.php?pag=$pag&id_turma=$id_turma4&id_aluno=$id_aluno4&funcao=matriculados';</script>";

      } 



      if (@$_GET["funcao"] != null && @$_GET["funcao"] == "professores") {
        echo "<script>$('#modal-professores').modal('show');</script>";
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

      <!--AJAX PARA INSERÇÃO de professores nas turmas -->
      <script type="text/javascript">
        $("#form-prof").submit(function () {
          var pag = "<?=$pag?>";
          event.preventDefault();
          var formData = new FormData(this);

          $.ajax({
            url: pag + "/inserir-professores.php",
            type: 'POST',
            data: formData,

            success: function (mensagem) {

              $('#mensagem-prof').removeClass()

              if (mensagem.trim() == "Salvo com Sucesso!!") {

                    //$('#nome').val('');
                    //$('#cpf').val('');
                    $('#btn-cancelar-prof').click();
                    window.location = "index.php?pag="+pag;

                  } else {

                    $('#mensagem-prof').addClass('text-danger')
                  }

                  $('#mensagem-prof').text(mensagem)

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

      <!--AJAX PARA EXCLUSÃO DOS DADOS -->
      <script type="text/javascript">
        $(document).ready(function () {
          var pag = "<?=$pag?>";
          var turma = "<?=$_GET['id_turma']?>";
          var aluno = "<?=$_GET['id_aluno']?>";



          $('#btn-excluir-matricula').click(function (event) {
            event.preventDefault();

            console.log(aluno)

            $.ajax({
              url: pag + "/excluir-matricula.php",
              method: "post",
              data: {turma, aluno},
              dataType: "text",
              success: function (mensagem) {

                if (mensagem.trim() === 'Excluído com Sucesso!!') {


                  $('#btn-cancelar-excluir-matricula').click();
                  window.location = 'index.php?pag='+pag+'&id_turma='+turma+'&id_aluno='+aluno+'&funcao=matriculados';

                }else{

                  $('#mensagem_excluir-matricula').addClass('text-danger')
                  $('#mensagem_excluir-matricula').text(mensagem)
                }

                



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
            "ordering": false,
            "stateSave": true,
            "stateDuration": 60 * 60 * 24,
            "autoWidth": false
          })
          $('#dataTable2').dataTable({
            "ordering": false,
            "stateSave": true,
            "stateDuration": 60 * 60 * 24,
            "autoWidth": false
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



