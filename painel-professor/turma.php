<?php 

@session_start();
$pag = "turma";

require_once("../conexao.php"); 

$id_turma = $_GET['id'];
$id_disciplina = $_GET['id_disciplina'];
$id_periodo = $_GET['id_periodo'];


$query_2 = $pdo->query("SELECT * FROM tbdisciplina where IdDisciplina = '$id_disciplina' ");
$res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);

$nome_disciplina = $res_2[0]['NomeDisciplina'];



$query_2 = $pdo->query("SELECT * FROM tbturma where IdTurma = '$id_turma' ");
$res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
$id_serie = $res_2[0]['IdSerie'];
$id_periodo = $res_2[0]['IdPeriodo'];
$nome_turma = $res_2[0]['NomeTurma'];
$sigla = $res_2[0]['SiglaTurma'];
$totalvagas = $res_2[0]['TotalVagas'];
$id_sala = $res_2[0]['IdSala'];
$data_final = $res_2[0]['DataFinal'];
$turno = $res_2[0]['TurnoPrincipal'];


//RECUPERAR O TOTAL DE MESES ENTRE DATAS
//$d1 = new DateTime($data_inicio);
//$d2 = new DateTime($data_final);
//$intervalo = $d1->diff( $d2 );
//$anos = $intervalo->y;
//$meses = $intervalo->m + ($anos * 12);

$data_finalF = implode('/', array_reverse(explode('-', $data_final)));

$query_resp = $pdo->query("SELECT * FROM tbserie where IdSerie = '$id_serie' ");
$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);                    
$nome_disc = $res_resp[0]['NomeSerie'];
$id_curso = $res_resp[0]['IdCurso'];
$id_periodo = $res_resp[0]['IdPeriodo'];

$query_resp = $pdo->query("SELECT * FROM tbcurso where IdCurso = '$id_curso' ");
$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC); 
$nome_curso = $res_resp[0]['NomeCurso'];

$query_resp = $pdo->query("SELECT * FROM tbperiodo where IdPeriodo = '$id_periodo' ");
$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC); 
$nome_periodo = $res_resp[0]['SiglaPeriodo'];

$query = $pdo->query("SELECT * FROM tbprofessor where CPF = '$cpf_usu' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_prof = $res[0]['IdProfessor'];


$query_resp = $pdo->query("SELECT * FROM tbprofessor where IdProfessor = '$id_prof' ");
$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);                    
$nome_prof = $res_resp[0]['NomeProfessor'];
$email_prof = $res_resp[0]['Email'];
$imagem_prof = $res_resp[0]['foto'];


$query_resp2 = $pdo->query("SELECT * FROM tbalunoturma where IdTurma = '$id_turma' ");
$res_resp2 = $query_resp2->fetchAll(PDO::FETCH_ASSOC);                    
$total_alunos = count(@$res_resp2);

$id_get_periodo = @$_GET['id_periodo'];

$query_resp = $pdo->query("SELECT * FROM aulas where turma = '$id_turma' and periodo = '$id_get_periodo' and id_disciplina = '$id_disciplina'");
$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);                 
$total_aulas = @count($res_resp);


if($data_final < date('Y-m-d')){
 $concluido = 'Sim';
}else{
 $concluido = 'Não';
}

$encoding = mb_internal_encoding(); // ou UTF-8, ISO-8859-1...


?>

<h6><b><?php echo mb_strtoupper($nome_disciplina, $encoding) ?> / <?php echo strtoupper($nome_disc) ?> <?php echo $nome_turma ?></h6></b>
<hr>

<small>
  <div class="mb-3">
   <span class="mr-3"><i><b>Aulas Concluídas:</b> <?php echo $total_aulas ?> Aulas</i></span>
   <span class="mr-3"><i><b>Disciplina Concluída: </b> <?php echo $concluido ?></i></span>
   <span class="mr-3"><i><b>Dias de Aula </b> <?php echo $dia ?></i></span>
   <span class="mr-3"><i><b>Horário Aula: </b> <?php echo $turno ?></i></span>
   
 </div>
</small>

<hr>



<div class="row">

  <div class="col-xl-3 col-md-6 mb-4">
    <?php $id_periodo = @$_GET['id_periodo'] ?>
    <a class="text-dark" href="index.php?pag=turma&funcao=periodos&id=<?php echo $id_turma ?>&id_periodo=<?php echo $id_periodo ?>&id_disciplina=<?php echo $id_disciplina ?>&chamada=sim" title="Fazer Chamada">
     <div class="card text-danger shadow h-100 py-2">
      <div class="card-body">
       <div class="row no-gutters align-items-center">
        <div class="col mr-2">
         <div class="text-xs font-weight-bold  text-danger text-uppercase">CHAMADA</div>
         <div class="text-xs text-secondary"> <?php echo $total_alunos ?> ALUNOS MATRICULADOS</div>
       </div>
       <div class="col-auto" align="center">
         <i class="far fa-calendar-alt fa-2x  text-danger"></i><br>
         <span class="text-xs"></span>
       </div>
     </div>
   </div>
 </div>
</a>
</div>



<div class="col-xl-3 col-md-6 mb-4">
  <?php $id_periodo = @$_GET['id_periodo'] ?>
  <a class="text-dark" href="index.php?pag=turma&funcao=periodos&id=<?php echo $id_turma ?>&id_periodo=<?php echo $id_periodo ?>&id_disciplina=<?php echo $id_disciplina ?>&notas=sim" title="Informações da Turma">
   <div class="card text-primary shadow h-100 py-2">
    <div class="card-body">
     <div class="row no-gutters align-items-center">
      <div class="col mr-2">
       <div class="text-xs font-weight-bold  text-primary text-uppercase">BOLETIM</div>
       <div class="text-xs text-secondary"> LANÇAR NOTAS</div>
     </div>
     <div class="col-auto" align="center">
       <i class="fas fa-file-invoice fa-2x  text-primary"></i><br>
       <span class="text-xs"></span>
     </div>
   </div>
 </div>
</div>
</a>
</div>




<div class="col-xl-3 col-md-6 mb-4">
  <?php $id_periodo = @$_GET['id_periodo'] ?>
  <a class="text-dark" href="index.php?pag=turma&funcao=periodos&id=<?php echo $id_turma ?>&id_periodo=<?php echo $id_periodo ?>&id_disciplina=<?php echo $id_disciplina ?>&aulas=sim" title="Lançar Aulas">
   <div class="card text-info shadow h-100 py-2">
    <div class="card-body">
     <div class="row no-gutters align-items-center">
      <div class="col mr-2">
       <div class="text-xs font-weight-bold  text-info text-uppercase">AULAS</div>
       <div class="text-xs text-secondary"> GRADE DA DISCIPLINA</div>
     </div>
     <div class="col-auto" align="center">
       <i class="fas fa-video fa-2x  text-info"></i><br>
       <span class="text-xs"></span>
     </div>
   </div>
 </div>
</div>
</a>
</div>

<!--
<div class="col-xl-3 col-md-6 mb-4">
  <a class="text-dark" href="index.php?pag=periodos&id=<?php  $id_turma ?>" title="Cadastro de Períodos">
    <div class="card text-dark shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold  text-dark text-uppercase">PERÍODOS</div>
            <div class="text-xs text-secondary"> PERÍODOS DO CURSO</div>
          </div>
          <div class="col-auto" align="center">
            <i class="fas fa-calendar-day fa-2x  text-dark"></i><br>
            <span class="text-xs"></span>
          </div>
        </div>
      </div>
    </div>
  </a>
</div> -->


</div>




<div class="modal" id="modal-aulas" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <?php 
        $numerofase = $_GET['numero_fase'];

        $query_r11 = $pdo->query("SELECT * FROM tbfases_ano where NumeroFase = '$numerofase'");
        $res_r11= $query_r11->fetchAll(PDO::FETCH_ASSOC);
        $nomefase = $res_r11[0]['NomeFase'];


        ?>
        <h5 class="modal-title">Disciplina: <?php echo $nome_disciplina ?> / <?php echo $nome_disc ?> <?php echo $nome_turma?> - <?php echo $nomefase ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-md-7">

            <span class=""><b>Aulas da Disciplina</b></span>
            <small><div id="listar-aulas" class="mt-2">


            </div></small>

          </div>
          <div class="col-md-5">

            <span class="mb-2"><b>Inserir nova aula</b></span>


            <form id="form" method="POST" class="mt-2">



              <div class="form-group">
               <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome da Aula">
             </div>

             <div class="form-group">
               <textarea placeholder="Descrição do conteúdo da aula (caso tenha)" class="form-control" id="descricao" name="descricao"></textarea>  
             </div>
             <div class="form-group">
               <input required type="date" class="form-control" id="data_aula" name="data_aula" >
             </div>

             <div align="right">
              <button type="submit" name="btn-salvar-aula" id="btn-salvar-aula" class="btn btn-primary">Salvar</button>
            </div>

            <input type="hidden" name="turma" value="<?php echo $_GET['id'] ?>">
            <input type="hidden" name="periodo" value="<?php echo $_GET['id_periodo'] ?>">
            <input type="hidden" name="professor" value="<?php echo $_GET['id_prof'] ?>">
            <input type="hidden" name="fase" value="<?php echo $_GET['numero_fase'] ?>">
            <input type="hidden" name="disc-cat" value="<?php echo $_GET['id_disciplina'] ?>">

            <?php $id_per = @$_GET['id_periodo']; 
            $fase = @$_GET['numero_fase'];
            $id_disciplina = @$_GET['id_disciplina'];

            ?>

          </form>
        </div>
      </div>

      <div align="center" id="mensagem_aulas" class="">

      </div>

    </div>

  </div>
</div>
</div>




<div class="modal" id="modal-periodos" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Disciplina: <?php echo $nome_disciplina ?> / <?php echo $nome_disc ?> <?php echo $nome_turma?> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <?php 

        $id_turma = @$_GET['id'];

        if(@$_GET['aulas'] != ""){
          $query = $pdo->query("SELECT * FROM tbfases_ano where NumeroFase >=1 and NumeroFase <=3 order by NumeroFase asc ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        }

        if(@$_GET['notas'] != ""){
          $query = $pdo->query("SELECT * FROM tbfases_ano where FaseInformada = 1 order by NumeroFase asc ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        }

        if(@$_GET['chamada'] != ""){
          $query = $pdo->query("SELECT * FROM tbfases_ano where NumeroFase >=1 and NumeroFase <=3 order by NumeroFase asc ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        }

        if(@count($res)==0){
          echo "<span class='text-danger'><small>Não existem períodos cadastrados, por favor cadastre os períodos da turma!</small></span>";

        }

        for ($i=0; $i < count($res); $i++) { 
          foreach ($res[$i] as $key => $value) {
          }

          $nome = $res[$i]['NomeFase'];
          $numeroFase = $res[$i]['NumeroFase'];
          ?>

          <?php if(@$_GET['aulas'] != ""){ ?>
            <a href="index.php?pag=turma&funcao=aulas&id=<?php echo $id_turma ?>&numero_fase=<?php echo $numeroFase ?>&id_prof=<?php echo $id_prof ?>&id_periodo=<?php echo $id_periodo ?>&id_disciplina=<?php echo $id_disciplina ?>" name="btn-salvar-aula" class="btn btn-primary text-light m-1"><?php echo $nome ?></a>
          <?php } ?>


          <?php if(@$_GET['notas'] != ""){ ?>
            <a href="index.php?pag=turma&funcao=notas&id=<?php echo $id_turma ?>&numero_fase=<?php echo $numeroFase ?>&id_prof=<?php echo $id_prof ?>&id_periodo=<?php echo $id_periodo ?>&id_disciplina=<?php echo $id_disciplina ?>" name="btn-salvar-notas" class="btn btn-primary text-light m-1"><?php echo $nome ?></a>
          <?php } ?>


          <?php if(@$_GET['chamada'] != ""){ ?>
            <a href="index.php?pag=turma&funcao=chamada&id=<?php echo $id_turma ?>&numero_fase=<?php echo $numeroFase ?>&id_prof=<?php echo $id_prof ?>&id_periodo=<?php echo $id_periodo ?>&id_disciplina=<?php echo $id_disciplina ?>" name="btn-salvar-chamada" class="btn btn-primary text-light m-1"><?php echo $nome ?></a>
          <?php } ?>


        <?php } ?>

      </div>

    </div>
  </div>
</div>


<div class="modal" id="modal-upload" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Carregar Arquivo </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form2" method="POST">
        <div class="modal-body">

         <div class="form-group">
          <label >Imagem</label>
          <input type="file" value="<?php echo @$foto2 ?>"  class="form-control-file" id="imagem" name="imagem" onChange="carregarImg();">
        </div>

        <div id="divImgConta">
          <?php if(@$foto2 != ""){ ?>
            <img src="../img/arquivos-aula/<?php echo $foto2 ?>" width="200" height="200" id="target">
          <?php  }else{ ?>
            <img src="../img/arquivos-aula/sem-foto.jpg" width="200" height="200" id="target">
          <?php } ?>
        </div>

        <small>
          <div id="mensagem-upload">

          </div>
        </small> 
        

      </div>

      <div class="modal-footer">



        <input value="<?php echo @$_GET['id'] ?>" type="hidden" name="txtidaula" id="txtidaula">
        

        <button type="button" id="btn-cancelar-upload" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="btn-salvar-upload" id="btn-salvar-upload" class="btn btn-primary">Salvar</button>
      </div>
    </form>

  </div>
</div>
</div>


<div class="modal" id="modal-notas" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <?php 

        $numerofase = $_GET['numero_fase'];

        $query_r11 = $pdo->query("SELECT * FROM tbfases_ano where NumeroFase = '$numerofase'");
        $res_r11= $query_r11->fetchAll(PDO::FETCH_ASSOC);
        $nomefase = $res_r11[0]['NomeFase'];

        ?>
        <h5 class="modal-title">Lançar Notas - Disciplina: <?php echo $nome_disciplina ?> - <?php echo $nomefase ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form2" method="POST">
        <div class="modal-body">


         <!-- DataTales Example -->
         <div class="card shadow mb-4">

          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable-alunos" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Nome</th>

                    <th>Situação na disciplina</th>

                    <th>Média Trimestral</th>
                    <th>Ações</th>

                  </tr>
                </thead>

                <tbody>

                 <?php 
                 $id_turma = $_GET['id'];
                 $id_prof = $_GET['id_prof'];
                 $id_disciplina = $_GET['id_disciplina'];
                 $numeroFase = $_GET['numero_fase'];
                 $id_periodo = $_GET['id_periodo'];

                 $query_4 = $pdo->query("SELECT * FROM tbturma where IdTurma = '$id_turma'");
                 $res_4 = $query_4->fetchAll(PDO::FETCH_ASSOC);
                 $serie = $res_4[0]['IdSerie'];

                 $query_3 = $pdo->query("SELECT * FROM tbdisciplina where IdDisciplina = '$id_disciplina'");
                 $res_3 = $query_3->fetchAll(PDO::FETCH_ASSOC);
                 $disciplina = $res_3[0]['NomeDisciplina'];

                 if ($numeroFase != 5) {


                   $query = $pdo->query("SELECT * FROM tbalunoturma where IdTurma = '$id_turma' ");
                   $res = $query->fetchAll(PDO::FETCH_ASSOC);

                   for ($i=0; $i < count($res); $i++) { 
                    foreach ($res[$i] as $key => $value) {
                    }

                    $aluno = $res[$i]['IdAluno'];
                    $id_situacao = $res[$i]['IdSituacaoAlunoTurma'];

                    $query_r = $pdo->query("SELECT * FROM tbaluno where IdAluno = '$aluno' order by NomeAluno");
                    $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);

                    $nome = $res_r[0]['NomeAluno'];
                  //$telefone = $res_r[0]['telefone'];
                    $email = $res_r[0]['Email'];
                    $id_endereco = $res_r[0]['IdEndereco'];
                    $cpf = $res_r[0]['CPF'];
                    $foto = $res_r[0]['foto'];
                    $id_aluno = $res_r[0]['IdAluno'];

                    $query_r1 = $pdo->query("SELECT * FROM tbsituacaoalunodisciplina where IdAluno = '$aluno' and IdTurma = '$id_turma' and IdDisciplina = '$id_disciplina'");
                    $res_r1 = $query_r1->fetchAll(PDO::FETCH_ASSOC);

                    $situacao = $res_r1[0]['SituacaoAtual'];

                    if ($situacao == "Aprovado") {
                      $classe_sit = "text-success";
                    }else if($situacao == "Recuperação Anual"){
                      $classe_sit = "text-danger";
                    }else{
                      $classe_sit = "text-dark";
                    }


                    ?>


                    <tr>
                      <td>
                        <?php echo $nome ?>
                      </td>

                      <td id="situacao_disc" class="<?php echo $classe_sit ?>"><?php echo  $situacao ?></td>

                      <td></td>


                      <td>
                        <a onclick="lancarNotas(<?php echo  $id_aluno; ?>, '<?php echo $nome ?>', <?php echo $maximo_nota ?>, '<?php echo $disciplina ?>', <?php echo $id_disciplina ?>,<?php echo $numeroFase ?>)" href="" class='text-info mr-1' title='Lançar Notas'><i class='fas fa-sticky-note fa-1x'></i></a>
                      </td>
                    </tr>
                  <?php } } elseif ($numeroFase == 5) {

                    $query_r11 = $pdo->query("SELECT * FROM tbsituacaoalunodisciplina where IdTurma = '$id_turma' and IdDisciplina = '$id_disciplina' and SituacaoAtual = 'Recuperação Anual'");
                    $res_r11 = $query_r11->fetchAll(PDO::FETCH_ASSOC);
                    for ($i=0; $i < count($res_r11); $i++) { 
                      foreach ($res_r11[$i] as $key => $value) {
                      }
                      $aluno_rec = $res_r11[$i]['IdAluno'];
                      $situacao = $res_r11[$i]['SituacaoAtual'];

                      $query_r = $pdo->query("SELECT * FROM tbaluno where IdAluno = '$aluno_rec' order by NomeAluno");
                      $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);

                      $nome = $res_r[0]['NomeAluno'];
                      $email = $res_r[0]['Email'];
                      $id_endereco = $res_r[0]['IdEndereco'];
                      $cpf = $res_r[0]['CPF'];
                      $foto = $res_r[0]['foto'];

                      if ($situacao == "Aprovado") {
                        $classe_sit = "text-success";
                      }else if($situacao == "Recuperação Anual"){
                        $classe_sit = "text-danger";
                      }else{
                        $classe_sit = "text-dark";
                      }

                      ?>

                      <tr>
                        <td>
                          <?php echo $nome ?>
                        </td>

                        <td id="" class="<?php echo $classe_sit ?>"><?php echo  $situacao ?></td>

                        <td><img src="../img/alunos/<?php echo $foto ?>" width="50"></td>


                        <td>
                          <a onclick="lancarNotas_rec(<?php echo  $aluno_rec; ?>, '<?php echo $nome ?>', <?php echo $maximo_nota_rec ?>, '<?php echo $disciplina ?>', <?php echo $id_disciplina ?>,<?php echo $numeroFase ?>)" href="" class='text-info mr-1' title='Lançar nota Recuperação Anual'><i class='fas fa-sticky-note fa-1x'></i></a>
                        </td>
                      </tr>


                    <?php } } ?>  


                  </tbody>
                </table>
              </div>
            </div>
          </div>



        </div>


      </form>

    </div>
  </div>
</div>




<div class="modal" id="modal-lancar-notas" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-light">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo $nome_disc ?> - <?php echo $nome_turma ?> - <span id="txtnomealuno"></span> - <span id="txtdisciplina"></span></h5>
        <button type="button" onclick="atualizarPagina()" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


        <span class=""><b>Notas do Aluno </b></span>
        - <span id="total_notas">  </span> de <span id="maximonota"> <?php echo $maximo_nota ?></span> Pontos
        <div id="listar-notas" class="mt-2">

        </div>

        <?php  
        $id_turma = $_GET['id'];
        $id_disciplina = $_GET['id_disciplina'];

           // $query_4 = $pdo->query("SELECT * FROM tbfasenotaaluno where IdTurma = '$id_turma' and IdProfessor = '$id_prof'");
           // $res_4 = $query_4->fetchAll(PDO::FETCH_ASSOC);


        ?>


        <form id="form-notas" method="POST" class="mt-2">


          <div class="form-group">
            <label>Nota 1</label>
            <input type="number"  min=0 step="0.01" max="<?php echo $nota_maxima1 ?>" class="form-control" id="nota1" name="nota1" placeholder="Participação, comportamento etc">
          </div>


          <div class="form-group">
            <label>Nota 2</label>
            <input type="number" min=0 step="0.01" max="<?php echo $nota_maxima2 ?>" class="form-control" id="nota2" name="nota2" placeholder="Testes, trabalhos, seminários">
          </div>

          <div class="form-group">
            <label>Nota 3</label>
            <input type="number" min=0 step="0.01" max="<?php echo $nota_maxima3 ?>" class="form-control" id="nota3" name="nota3" placeholder="Atividade Avaliativa Final">
          </div>



          <div align="right">
            <button type="submit" name="btn-salvar-nota" id="btn-salvar-nota" class="btn btn-primary mb-4">Salvar</button>
          </div>

          <input type="hidden" name="turma" value="<?php echo $_GET['id'] ?>">
          <input type="hidden" name="periodo" value="<?php echo $_GET['id_periodo'] ?>">
          <input type="hidden" id="fase" name="fase" value="<?php echo $_GET['numero_fase'] ?>">
          <input type="hidden" id="txtidaluno" name="aluno"> 
          <input type="hidden" id="disciplina" name="disciplina" value="<?php echo $_GET['id_disciplina'] ?>"> 

          <input type="hidden" name="serie" value="<?php echo $id_serie ?>">



        </form>
        


        <small> <div align="center" id="mensagem-notas" class=""></div></small>

      </div>

    </div>
  </div>
</div>

<div class="modal" id="modal-lancar-notas-rec" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-light">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo $nome_disc ?> - <?php echo $nome_turma ?> - <span id="txtnomealuno_rec"></span> - <span id="txtdisciplina_rec"></span></h5>
        <button type="button" onclick="atualizarPagina()" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


        <span class=""><b>Notas do Aluno </b></span>
        - <span id="total_notas_rec">  </span> de <span id="maximonota_rec"> <?php echo $maximo_nota_rec ?></span> Pontos
        <div id="listar-notas_rec" class="mt-2">

        </div>

        <?php  
        $id_turma = $_GET['id'];
        $id_disciplina = $_GET['id_disciplina'];

           // $query_4 = $pdo->query("SELECT * FROM tbfasenotaaluno where IdTurma = '$id_turma' and IdProfessor = '$id_prof'");
           // $res_4 = $query_4->fetchAll(PDO::FETCH_ASSOC);


        ?>


        <form id="form-notas_rec" method="POST" class="mt-2">


          <div class="form-group">
            <label>Nota Recuperação Anual</label>
            <input type="number"  min=0 step="0.01" max="<?php echo $maximo_nota_rec ?>" class="form-control" id="nota_rec" name="nota_rec" placeholder="Nota recuperação anual">
          </div>


          <div align="right">
            <button type="submit" name="btn-salvar-nota_rec" id="btn-salvar-nota_rec" class="btn btn-primary mb-4">Salvar</button>
          </div>

          <input type="hidden" name="turma_rec" value="<?php echo $_GET['id'] ?>">
          <input type="hidden" name="periodo_rec" value="<?php echo $_GET['id_periodo'] ?>">
          <input type="hidden" id="fase_rec" name="fase_rec" value="<?php echo $_GET['numero_fase'] ?>">
          <input type="hidden" id="txtidaluno_rec" name="aluno_rec"> 
          <input type="hidden" id="disciplina_rec" name="disciplina_rec" value="<?php echo $_GET['id_disciplina'] ?>"> 

          <input type="hidden" name="serie_rec" value="<?php echo $id_serie ?>">



        </form>
        


        <small> <div align="center" id="mensagem-notas_rec" class=""></div></small>

      </div>

    </div>
  </div>
</div>


<div class="modal" id="modal-chamada-aulas" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Disciplina: <?php echo $nome_disciplina ?> / <?php echo $nome_disc ?> - Aulas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <?php  
        $numerofase = $_GET['numero_fase'];

        $query_r11 = $pdo->query("SELECT * FROM tbfases_ano where NumeroFase = '$numerofase'");
        $res_r11= $query_r11->fetchAll(PDO::FETCH_ASSOC);
        $nomefase = $res_r11[0]['NomeFase'];
        ?>


        <span class=""><b>Aulas da Disciplina - <?php echo $nomefase ?></b></span>
        <div id="listar-aulas-chamada" class="mt-2">

        </div>


        <div align="center" id="mensagem_chamada" class="">

        </div>

      </div>

    </div>
  </div>
</div>








<div class="modal" id="modal-chamada" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">

        <?php  
        $numerofase = @$_GET['numero_fase'];

        $query_r11 = $pdo->query("SELECT * FROM tbfases_ano where NumeroFase = '$numerofase'");
        $res_r11= $query_r11->fetchAll(PDO::FETCH_ASSOC);
        $nomefase = $res_r11[0]['NomeFase'];

        ?>
        <h5 class="modal-title">Fazer Chamada - Disciplina: <?php echo $nome_disciplina ?> / <?php echo $nomefase ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form3" method="POST">
        <div class="modal-body">

         <!-- DataTales Example -->
         <div class="card shadow mb-4">

          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Nome</th>
                    
                    <th>Email</th>
                    
                    <th>Foto</th>
                    <th>Ações</th>
                  </tr>
                </thead>

                <tbody>

                 <?php 

                 

                 $query = $pdo->query("SELECT * FROM tbalunoturma where IdTurma = '$id_turma'");
                 $res = $query->fetchAll(PDO::FETCH_ASSOC);

                 for ($i=0; $i < count($res); $i++) { 
                  foreach ($res[$i] as $key => $value) {
                  }

                  $aluno = $res[$i]['IdAluno'];

                  $query_r = $pdo->query("SELECT * FROM tbaluno where IdAluno = '$aluno' order by NomeAluno asc");
                  $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);

                  $nome = $res_r[0]['NomeAluno'];
                  //$telefone = $res_r[0]['telefone'];
                  $email = $res_r[0]['Email'];
                  $id_endereco = $res_r[0]['IdEndereco'];
                  $cpf = $res_r[0]['CPF'];
                  $foto = $res_r[0]['foto'];
                  $id_aluno = $res_r[0]['IdAluno'];


                  $query2 = $pdo->query("SELECT * FROM chamadas where turma = '$_GET[id]' and aluno = '$id_aluno' and aula = '$_GET[id_aula]' ");
                  $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                  $presenca = $res2[0]['presenca'];

                  if($presenca == 'P'){
                    $classe_chamada = 'text-success';
                  }else{
                    $classe_chamada = 'text-danger';
                  }

                  ?>


                  <tr>
                    <td>
                      <?php echo $nome ?>
                    </td>
                    
                    <td><?php echo $email ?></td>
                    
                    <td><img src="../img/alunos/<?php echo $foto ?>" width="50"></td>


                    <td>
                     <a href="index.php?pag=<?php echo $pag ?>&funcao=presenca&id_aluno=<?php echo $id_aluno ?>&id_aula=<?php echo $_GET['id_aula'] ?>&id=<?php echo $_GET['id'] ?>&id_periodo=<?php echo $_GET['id_periodo'] ?>&numero_fase=<?php echo $_GET['numero_fase'] ?>&id_disciplina=<?php echo $_GET['id_disciplina'] ?>" class='text-success mr-1' title='Presente'><i class='far fa-check-circle'></i></a>

                     <a href="index.php?pag=<?php echo $pag ?>&funcao=falta&id_aluno=<?php echo $id_aluno ?>&id_aula=<?php echo $_GET['id_aula'] ?>&id=<?php echo $_GET['id'] ?>&id_periodo=<?php echo $_GET['id_periodo'] ?>&numero_fase=<?php echo $_GET['numero_fase'] ?>&id_disciplina=<?php echo $_GET['id_disciplina'] ?>" class='text-danger mr-1' title='Falta'><i class="fas fa-times-circle"></i></a>


                     <a href="index.php?pag=<?php echo $pag ?>&funcao=justificado&id_aluno=<?php echo $id_aluno ?>&id_aula=<?php echo $_GET['id_aula'] ?>&id=<?php echo $_GET['id'] ?>&id_periodo=<?php echo $_GET['id_periodo'] ?>&numero_fase=<?php echo $_GET['numero_fase'] ?>&id_disciplina=<?php echo $_GET['id_disciplina'] ?>" class='text-info mr-1' title='Justificar Falta'><i class='fas fa-question-circle fa-1x'></i></a>

                     <?php if($presenca != ""){ ?>
                      - <span class="<?php echo $classe_chamada ?>"><?php echo $presenca ?></span>
                    <?php } ?>

                    

                  </td>
                </tr>
              <?php } ?>





            </tbody>
          </table>
        </div>
      </div>
    </div>

    

  </div>

  
</form>

</div>
</div>
</div>







<?php 

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "aulas") {
  echo "<script>$('#modal-aulas').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "periodos") {
  echo "<script>$('#modal-periodos').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "notas") {
  echo "<script>$('#modal-notas').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "chamada") {
  echo "<script>$('#modal-chamada-aulas').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "fazerchamada") {
  echo "<script>$('#modal-chamada').modal('show');</script>";
}


if (@$_GET["funcao"] != null && @$_GET["funcao"] == "presenca") {

  $id_turma_chamada = $_GET['id'];
  $id_aluno_chamada = $_GET['id_aluno'];
  $id_aula_chamada = $_GET['id_aula'];
  $id_periodo_chamada = $_GET['id_periodo'];
  $numerofase_chamada = $_GET['numero_fase'];
  $disciplina_chamada = $_GET['id_disciplina'];

  $query = $pdo->query("SELECT * FROM chamadas where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  

  if(@count($res) > 0){
    $id_chamada = $res[0]['id'];
    $pdo->query("UPDATE chamadas SET presenca = 'P' where id = '$id_chamada'");
  }else{
    $pdo->query("INSERT INTO chamadas SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'P', data = curDate(), periodo = '$id_periodo_chamada', NumeroFase = '$numerofase_chamada'");
  }

  echo "<script>window.location='index.php?pag=$pag&funcao=fazerchamada&id=$id_turma_chamada&id_periodo=$id_periodo_chamada&id_aula=$id_aula_chamada&id_disciplina=$disciplina_chamada&numero_fase=$numerofase_chamada';</script>";


}



if (@$_GET["funcao"] != null && @$_GET["funcao"] == "falta") {

  $id_turma_chamada = $_GET['id'];
  $id_aluno_chamada = $_GET['id_aluno'];
  $id_aula_chamada = $_GET['id_aula'];
  $id_periodo_chamada = $_GET['id_periodo'];
  $numerofase_chamada = $_GET['numero_fase'];
  $disciplina_chamada = $_GET['id_disciplina'];

  $query = $pdo->query("SELECT * FROM chamadas where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  if(@count($res) > 0){
    $id_chamada = $res[0]['id'];
    $pdo->query("UPDATE chamadas SET presenca = 'F' where id = '$id_chamada'");
  }else{
    $pdo->query("INSERT INTO chamadas SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'F', data = curDate(), periodo = '$id_periodo_chamada', NumeroFase = '$numerofase_chamada'");
  }

  echo "<script>window.location='index.php?pag=$pag&funcao=fazerchamada&id=$id_turma_chamada&id_periodo=$id_periodo_chamada&id_aula=$id_aula_chamada&id_disciplina=$disciplina_chamada&numero_fase=$numerofase_chamada';</script>";


}



if (@$_GET["funcao"] != null && @$_GET["funcao"] == "justificado") {

  $id_turma_chamada = $_GET['id'];
  $id_aluno_chamada = $_GET['id_aluno'];
  $id_aula_chamada = $_GET['id_aula'];
  $id_periodo_chamada = $_GET['id_periodo'];
  $numerofase_chamada = $_GET['numero_fase'];
  $disciplina_chamada = $_GET['id_disciplina'];

  $query = $pdo->query("SELECT * FROM chamadas where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  if(@count($res) > 0){
    $id_chamada = $res[0]['id'];
    $pdo->query("UPDATE chamadas SET presenca = 'J' where id = '$id_chamada'");
  }else{
    $pdo->query("INSERT INTO chamadas SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'J', data = curDate(), periodo = '$id_periodo_chamada', NumeroFase = '$numerofase_chamada'");
  }

  echo "<script>window.location='index.php?pag=$pag&funcao=fazerchamada&id=$id_turma_chamada&id_periodo=$id_periodo_chamada&id_aula=$id_aula_chamada&id_disciplina=$disciplina_chamada&numero_fase=$numerofase_chamada';</script>";


}


?>

<!--AJAX PARA LISTAR OS DADOS -->
<script type="text/javascript">
  $(document).ready(function(){
   listarDados();
   listarAulasChamada();


   

 })
</script>



<script type="text/javascript">
  function listarDados(){
    var pag = "<?=$pag?>";
    var turma = "<?=$id_turma?>";
    var periodo = "<?=$id_per?>";
    var fase = "<?=$fase?>";
    var id_disciplina = "<?=$_GET['id_disciplina']?>";

    //console.log(id_disciplina)
    
    $.ajax({
     url: pag + "/listar-aulas.php",
     method: "post",
     data: {turma, periodo, fase, id_disciplina},
     dataType: "html",
     success: function(result){
      $('#listar-aulas').html(result)

    },


  })
  }
</script>

<script type="text/javascript">
  function listarAulasChamada(){
    var pag = "<?=$pag?>";
    var turma = "<?=$id_turma?>";
    var periodo = "<?=$id_per?>";
    var fase = "<?=$fase?>";
    var id_disciplina = "<?=$_GET['id_disciplina']?>";
    //console.log(periodo)
    $.ajax({
     url: pag + "/listar-aulas-chamada.php",
     method: "post",
     data: {turma, periodo, fase, id_disciplina},
     dataType: "html",
     success: function(result){
      $('#listar-aulas-chamada').html(result)

    },


  })
  }
</script>




<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
  $("#form").submit(function () {
    var pag = "<?=$pag?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: pag + "/inserir-aula.php",
      type: 'POST',
      data: formData,

      success: function (mensagem) {

        $('#mensagem_aulas').removeClass()

        if (mensagem.trim() == "Salvo com Sucesso!") {

          $('#nome').val('');
          $('#descricao').val('');
          $('#data_aula').val('');
          $('#disc-cat').val('');
          $('#mensagem_aulas').addClass('text-success')
          listarDados();
          window.location.reload();
          window.location.reload();

        } else {

          $('#mensagem_aulas').addClass('text-danger')
        }


        $('#mensagem_aulas').text(mensagem)

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

<script type="text/javascript">
  function deletarAula(idaula) {
    event.preventDefault();
    var pag = "<?=$pag?>";
    
    $.ajax({
      url: pag + "/excluir-aula.php",
      method: "post",
      data: {idaula},
      dataType: "text",
      success: function (mensagem) {

        if (mensagem.trim() === 'Excluído com Sucesso!') {


          listarDados();
          window.location.reload();
        }



      },

    })
  }
  
</script>


<script type="text/javascript">
  function upload(idaula) {
    event.preventDefault();
    var pag = "<?=$pag?>";
    document.getElementById('txtidaula').value = idaula;
    $('#modal-upload').modal('show');
  }
  
</script>

<!--SCRIPT PARA CARREGAR IMAGEM -->
<script type="text/javascript">

  function carregarImg() {

    var target = document.getElementById('target');
    var file = document.querySelector("input[type=file]").files[0];


    var arquivo = file['name'];
    resultado = arquivo.split(".", 2);
        //console.log(resultado[1]);

        if(resultado[1] === 'pdf'){
          $('#target').attr('src', "../img/arquivos-aula/pdf.png");
          return;
        }

        if(resultado[1] === 'rar'){
          $('#target').attr('src', "../img/arquivos-aula/zip.png");
          return;
        }


        if(resultado[1] === 'zip'){
          $('#target').attr('src', "../img/arquivos-aula/zip.png");
          return;
        }

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


    <!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
    <script type="text/javascript">
      $("#form2").submit(function () {
        var pag = "<?=$pag?>";
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
          url: pag + "/upload.php",
          type: 'POST',
          data: formData,

          success: function (mensagem) {

            $('#mensagem').removeClass()

            if (mensagem.trim() == "Salvo com Sucesso!") {

              $('#nome').val('');
              $('#descricao').val('');
              listarDados();
              $('#btn-cancelar-upload').click();

            } else {

              $('#mensagem-upload').addClass('text-danger')
            }

            $('#mensagem-upload').text(mensagem)

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


    <script type="text/javascript">
      function lancarNotas(idaluno, nomealuno, maximonota, disciplina, iddisciplina, numerofase) {
        event.preventDefault();

        var pag = "<?=$pag?>";
        

        $("#txtnomealuno").text(nomealuno);
        document.getElementById('txtidaluno').value = idaluno;
        
        //document.getElementById('txtiddisciplina').value = iddisciplina;

        //$("#txtnomealuno").text(nomealuno);
        $("#maximonota").text(maximonota);
        $("#txtdisciplina").text(disciplina);
        


        listarDadosNotas(idaluno, iddisciplina, numerofase);

        $('#modal-lancar-notas').modal('show');
      }


    </script>

    <script type="text/javascript">
      function lancarNotas_rec(idaluno, nomealuno, maximonota, disciplina, iddisciplina, numerofase) {
        event.preventDefault();


        var pag = "<?=$pag?>";
        

        $("#txtnomealuno_rec").text(nomealuno);
        document.getElementById('txtidaluno_rec').value = idaluno;
        
        //document.getElementById('txtiddisciplina').value = iddisciplina;

        //$("#txtnomealuno").text(nomealuno);
        $("#maximonota_rec").text(maximonota);
        $("#txtdisciplina_rec").text(disciplina);
        


       // listarDadosNotas(idaluno, iddisciplina, numerofase);

       $('#modal-lancar-notas-rec').modal('show');
     }


   </script>

   <!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
   <script type="text/javascript">
    $("#form-notas_rec").submit(function () {
      var pag = "<?=$pag?>";

      event.preventDefault();
      var formData = new FormData(this);

      $.ajax({
        url: pag + "/inserir-nota-rec.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {

          $('#mensagem-notas_rec').removeClass()

          if (mensagem.trim() == "Salvo com Sucesso!") {

            var iddisciplina = document.getElementById('disciplina_rec').value;
            var idaluno = document.getElementById('txtidaluno_rec').value;
            var numerofase = document.getElementById('fase_rec').value;

              //console.log(iddisciplina);
              
              listarDadosNotas(idaluno, iddisciplina, numerofase );
              
              $('#mensagem-notas_rec').addClass('text-success')
              $('#mensagem-notas_rec').text(mensagem);
              
             // window.location.reload();


           }else{
            $('#mensagem-notas_rec').addClass('text-danger')
            $('#mensagem-notas_rec').text(mensagem);

          } 



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



  <!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
  <script type="text/javascript">
    $("#form-notas").submit(function () {
      var pag = "<?=$pag?>";

      event.preventDefault();
      var formData = new FormData(this);

      $.ajax({
        url: pag + "/inserir-nota.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {

          $('#mensagem-notas').removeClass()

          if (mensagem.trim() == "Salvo com Sucesso!") {

            var iddisciplina = document.getElementById('disciplina').value;
            var idaluno = document.getElementById('txtidaluno').value;
            var numerofase = document.getElementById('fase').value;

              //console.log(iddisciplina);
              
              listarDadosNotas(idaluno, iddisciplina, numerofase );
              
              $('#mensagem-notas').text(mensagem);
              $('#mensagem-notas').addClass('text-success')
             // window.location.reload();


           } else if(mensagem.trim() == "Atualizado com Sucesso!") {

             var iddisciplina = document.getElementById('disciplina').value;
             var idaluno = document.getElementById('txtidaluno').value;
             var numerofase = document.getElementById('fase').value;

             
             //$('#btn-salvar-nota').click();


             $('#mensagem-notas').text(mensagem);
             $('#mensagem-notas').addClass('text-success')
             //window.location.reload();
             
             listarDadosNotas(idaluno, iddisciplina, numerofase );
             //$('#modal-lancar-notas').modal('show');
             atualizarMedia(iddisciplina, idaluno, numerofase );
             

             //atualizarSituacao(iddisciplina, idaluno, numerofase );

           }else if(mensagem.trim() == "Salvo com Sucesso! E Média Parcial Atualizada!"){

             var iddisciplina = document.getElementById('disciplina').value;
             var idaluno = document.getElementById('txtidaluno').value;
             var numerofase = document.getElementById('fase').value;

             $('#mensagem-notas').addClass('text-success')
             $('#mensagem-notas').text(mensagem);
             $('#btn-salvar-nota').click();
             //console.log("dsadsa")
             listarDadosNotas(idaluno, iddisciplina, numerofase );
             //window.location.reload();
             atualizarMedia(iddisciplina, idaluno, numerofase );

           }



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

  <script type="text/javascript">
    function atualizarMedia(iddisciplina, idaluno, numerofase, turma ){
      var pag = "<?=$pag?>";
      var turma = "<?=$id_turma?>";
      var periodo = "<?=$id_per?>"
      $.ajax({
       url: pag + "/atualizar-media.php",
       method: "post",
       data: {iddisciplina, idaluno, numerofase, turma, periodo},
       dataType: "html",
       success: function(result){
          //window.location.reload();

        },


      })

    }

  </script>

  <script type="text/javascript">
    function atualizarPagina(){

      window.location.reload();


    }
  </script>



  <script type="text/javascript">
    function listarDadosNotas(aluno, disciplina, numerofase){
      var pag = "<?=$pag?>";
      var turma = "<?=$id_turma?>";
      var periodo = "<?=$id_per?>";


      $.ajax({
       url: pag + "/listar-notas.php",
       method: "post",
       data: {turma, periodo, aluno, disciplina, numerofase},
       dataType: "html",
       success: function(result){
        $('#listar-notas').html(result)

      },


    })
    }
  </script>

  <script type="text/javascript">
    function deletarNota(idnota) {
      event.preventDefault();
      var pag = "<?=$pag?>";

      $.ajax({
        url: pag + "/excluir-nota.php",
        method: "post",
        data: {idnota},
        dataType: "text",
        success: function (mensagem) {

          if (mensagem.trim() === 'Excluído com Sucesso!') {


            listarDadosNotas(document.getElementById('txtidaluno').value);
          }



        },

      })
    }

  </script>
  <script type="text/javascript">
    $('#modal-lancar-notas').on('hidden.bs.modal', function(e){
      $("body").addClass("modal-open");
    });

  </script>



  <script type="text/javascript">
    $(document).ready(function () {
      $('#dataTable-alunos').dataTable({
        "ordering": false,
        "stateSave": true,
        "stateDuration": 60 * 60 * 24,
        "autoWidth": false
      })

    });
  </script>

  <script type="text/javascript">
    $(document).ready(function () {
      $('#dataTable2').dataTable({
        "ordering": false,
        "stateSave": true,
        "stateDuration": 60 * 60 * 24,
        "autoWidth": false
      })

    });
  </script>

