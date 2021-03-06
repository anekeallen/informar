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
          <div class="col-md-8">

            <span class=""><b>Aulas da Disciplina</b></span>
            <small><div id="listar-aulas" class="mt-2">


            </div></small>

          </div>
          <div class="col-md-4">

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
      <?php if(@$_GET['notas'] != ""){ ?>
        <div class="modal-footer">

          <div class="container">
            <div class="row">

              <a href="index.php?pag=turma&funcao=notasgerais&id=<?php echo $id_turma ?>&id_prof=<?php echo $id_prof ?>&id_periodo=<?php echo $id_periodo ?>&id_disciplina=<?php echo $id_disciplina ?>" title="Gerar Boletim">
                <i class='fas fa-clipboard text-primary mr-1'></i>Notas Gerais </a>


              </div>
            </div>

          </div>
        <?php } ?>


      </div>
    </div>
  </div>

  <div class="modal" id="modal-notas-gerais" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">

          <h5 class="modal-title">Notas - Disciplina: <?php echo $nome_disciplina ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">


         <!-- DataTales Example -->
         <div class="card shadow mb-4">

          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-sm table-hover" id="dataTable-notas-gerais" width="100%" cellspacing="0">
                <thead class="table-primary">
                  <tr class="text-dark">
                    <th class=""><small><b>Nome</b></small></th>

                    <th class="text-nowrap"><small><b>1º TRIM</b></small></th>
                    <th class="text-nowrap"><small><b>2º TRIM</b></small></th>
                    <th class="text-nowrap"><small><b>3º TRIM</b></small></th>
                    <th><small><b>MP</small></b> </th>
                    <th><small><b>REC</b></small></th>
                    <th><small><b>MA</b></small></th>  
                    <th class="text-nowrap"><small><b>REC FIN</b></small></th>
                    <th><small><b>MF</b></small></th>
                    <th><small><b>Situação</b></small></th>

                  </tr>
                </thead>

                <tbody>

                 <?php 
                 $id_turma = $_GET['id'];
                 $id_prof = $_GET['id_prof'];
                 $id_disciplina = $_GET['id_disciplina'];
                 $numeroFase = $_GET['numero_fase'];
                 $id_periodo = $_GET['id_periodo'];

                 $query = $pdo->query("SELECT * FROM tbalunoturma where IdTurma = '$id_turma' ");
                 $res = $query->fetchAll(PDO::FETCH_ASSOC);

                 for ($i=0; $i < count($res); $i++) { 
                  foreach ($res[$i] as $key => $value) {
                  }
                  $nota_trim1 = null;
                  $nota_trim2 = null;
                  $nota_trim3 = null;
                  $media_parcial = null;
                  $recuperacao = null;
                  $media_anual = null;
                  $recuperacao_final = null;
                  $media_final = null;

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
                  $idfasenotaatual = $res_r1[0]['IdFaseNotaAtual'];

                  

                  if ($situacao == "Aprovado" or $situacao == "Aprovado por REC" or $situacao == "Aprovado Prova Final") {
                    $classe_sit = "text-success";
                  }else if($situacao == "Cursando"){
                    $classe_sit = "text-dark";
                  }else{
                    $classe_sit = "text-danger";
                  }


                  $query11 = $pdo->query("SELECT * FROM tbfasenotaaluno where IdAluno = '$aluno' and IdTurma = '$id_turma' and IdDisciplina = '$id_disciplina' order by IdFaseNota asc");
                  $res11 = $query11->fetchAll(PDO::FETCH_ASSOC);

                  $nota_trim1 = $res11[0]['NotaFase'];
                  $nota_trim2 = $res11[1]['NotaFase'];
                  $nota_trim3 = $res11[2]['NotaFase'];
                  $media_parcial = $res11[3]['NotaFase'];
                  $recuperacao = $res11[4]['NotaFase'];
                  $media_anual = $res11[5]['NotaFase'];
                  $recuperacao_final = $res11[6]['NotaFase'];
                  $media_final = $res11[7]['NotaFase'];

                  if (isset($nota_trim1)) {
                   $nota_trim1F = number_format($nota_trim1, 2, ',', '.');

                   if ($nota_trim1 >= 7) {
                    $classe_notafase = "text-success";
                  }else{
                    $classe_notafase = "text-danger";
                  }
                } else{
                  $nota_trim1F = null;
                }

                if (isset($nota_trim2)) {
                 $nota_trim2F = number_format($nota_trim2, 2, ',', '.');

                 if ($nota_trim2 >= 7) {
                  $classe_notafase = "text-success";
                }else{
                  $classe_notafase = "text-danger";
                }
              } else{
                $nota_trim2F = null;
              }

              if (isset($nota_trim3)) {
                $nota_trim3F = number_format($nota_trim3, 2, ',', '.');

                if ($nota_trim3 >= 7) {
                  $classe_notafase = "text-success";
                }else{
                  $classe_notafase = "text-danger";
                }
              } else{
                $nota_trim3F = null;
              }

              if (isset($media_parcial)) {
               $media_parcialF = number_format($media_parcial, 2, ',', '.');

               if ($media_parcial >= 7) {
                $classe_notafase = "text-success";
              }else{
                $classe_notafase = "text-danger";
              }
            }else{
              $media_parcialF = null;
            }
            if (isset($recuperacao)) {
             $recuperacaoF = number_format($recuperacao, 2, ',', '.');

             if ($recuperacao >= 7) {
              $classe_rec= "text-primary";
            }else{
              $classe_rec = "text-danger";
            }
          } else{
            $recuperacaoF = null;
          }

          if (isset($media_anual)) {
           $media_anualF = number_format($media_anual, 2, ',', '.');

           if ($media_anual >= 7) {
            $classe_anual= "text-success";
          }else{
            $classe_anual = "text-danger";
          }
        } else{
          $media_anualF = null;
        }

        if (isset($recuperacao_final)) {
         $recuperacao_finalF = number_format($recuperacao_final, 2, ',', '.');

         if ($recuperacao_final >= 7) {
          $classe_rec_final= "text-primary";
        }else{
          $classe_rec_final = "text-danger";
        }
      } else{
        $recuperacao_finalF = null;
      }
      if (isset($media_final)) {
       $media_finalF = number_format($media_final, 2, ',', '.');

       if ($media_final >= 5) {
        $classe_final= "text-success";
      }else{
        $classe_final = "text-danger";
      }
    } else{
      $media_finalF = null;
    }

    

    ?>


    <tr class="table-light">
      <td><small><?php echo $nome ?></small></td>

      <td class="text-center <?php echo $classe_notafase ?>"><small><?php echo $nota_trim1F ?></small></td>

      <td class="text-center <?php echo $classe_notafase ?>"><small><?php echo $nota_trim2F ?></small></td>

      <td class="text-center <?php echo $classe_notafase ?>"><small><?php echo $nota_trim3F ?></small></td>

      <td class="text-center <?php echo $classe_notafase ?>"><small><?php echo $media_parcialF ?></small> </td>
      <td class="text-center <?php echo $classe_rec ?>"><small><?php echo $recuperacaoF ?> </small></td>
      <td class="text-center <?php echo $classe_anual ?>"><small><?php echo $media_anualF ?></small> </td>
      <td class="text-center <?php echo $classe_rec_final ?>"><small><?php echo $recuperacao_finalF ?></small> </td>
      <td class="text-center <?php echo $classe_final ?>"><small><?php echo $media_finalF ?></small> </td>
      
      <td class="<?php echo $classe_sit ?>"><small><?php echo $situacao  ?></small></td>
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



<div class="modal" id="modal-upload" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Carregar Arquivo </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form_upload" method="POST">
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
              <table class="table table-hover table-sm" id="dataTable-alunos" width="100%" cellspacing="0">
                <thead class="table-primary">
                  <tr class="text-dark">
                    <th><small><b>Nome</b></small></th>

                    <th><small><b>Situação</b></small></th>

                    <!-- Algumas Colunas so irão aparecer para determinado numero da fase --> 
                    <?php if ($numerofase != 5 and $numerofase != 3 and $numerofase != 7): ?>
                      <th><small><b>Média Trimestral</b></small></th>
                      
                    <?php endif ?>
                    <!-- Algumas Colunas so irão aparecer para determinado numero da fase --> 
                    <?php if ($numerofase == 3): ?>
                     <th class="text-nowrap"><small><b>Média Trimestral</b></small> </th>
                     <th class="text-nowrap"><small><b> Média Parcial</small></b> </th>

                   <?php endif ?>
                   <!-- Algumas Colunas so irão aparecer para determinado numero da fase --> 
                   <?php if ($numerofase == 5): ?>
                    <th class="text-nowrap"><small><b>Média Parcial</b></small></th>
                    <th class="text-nowrap"><small><b>Nota REC</b></small></th>
                    <th class="text-nowrap"><small><b>Média Anual</b></small></th>
                  <?php endif ?>
                  <!-- Algumas Colunas so irão aparecer para determinado numero da fase --> 
                  <?php if ($numerofase == 7): ?>
                    <th class="text-nowrap"><small><b>Média Parcial</b></small></th>
                    <th class="text-nowrap"><small><b>Prova Final</b></small></th>
                    <th class="text-nowrap"><small><b>Média Final</b></small></th>
                  <?php endif ?>


                  <th><small><b>Ações</b></small></th>

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

               // Os dados dos alunos dos trimestres
               if ($numeroFase == 1 or $numeroFase == 2 or $numeroFase == 3) {


                 $query = $pdo->query("SELECT * FROM tbalunoturma where IdTurma = '$id_turma' ");
                 $res = $query->fetchAll(PDO::FETCH_ASSOC);

                 for ($i=0; $i < count($res); $i++) { 
                  foreach ($res[$i] as $key => $value) {
                  }

                  $notafaseF = null;
                  $notafase = null;
                  $notafase_media_parcial = null;
                  $notafase_media_parcialF = null;

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
                  $idfasenotaatual = $res_r1[0]['IdFaseNotaAtual'];
                  $classe_sit_table = 'table-light';
                  

                  if ($situacao == "Aprovado" or $situacao == "Aprovado por REC" or $situacao == "Aprovado Prova Final") {
                    $classe_sit = "text-success";
                    $classe_sit_table = "table-success";
                  }else if($situacao == "Cursando"){
                    $classe_sit = "text-dark";
                    $classe_sit_table = "table-light";
                  }else{
                    $classe_sit = "text-danger";
                    $classe_sit_table = "table-danger";
                  }

                  $query_r223 = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$id_periodo' and IdSerie = '$id_serie' and NumeroFase = '$numeroFase'");
                  $res_r223 = $query_r223->fetchAll(PDO::FETCH_ASSOC);
                  $id_fasenota = $res_r223[0]['IdFaseNota'];

                  $query_r22 = $pdo->query("SELECT * FROM tbfasenotaaluno where IdAluno = '$aluno' and IdTurma = '$id_turma' and IdDisciplina = '$id_disciplina' and IdFaseNota = '$id_fasenota' ");
                  $res_r22 = $query_r22->fetchAll(PDO::FETCH_ASSOC);

                  $notafase = $res_r22[0]['NotaFase'];

                  if (isset($notafase)) {
                   $notafaseF = number_format($notafase, 2, ',', '.');
                 }




                 if ($notafase >= 7) {
                  $classe_notafase = "text-success";
                }else{
                  $classe_notafase = "text-danger";
                }

                $query_r2232 = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$id_periodo' and IdSerie = '$id_serie' and NumeroFase = 4");
                $res_r2232 = $query_r2232->fetchAll(PDO::FETCH_ASSOC);
                $id_fasenota_media = $res_r2232[0]['IdFaseNota'];




                if (isset($id_fasenota_media)) {

                  $query_r222 = $pdo->query("SELECT * FROM tbfasenotaaluno where IdAluno = '$aluno' and IdTurma = '$id_turma' and IdDisciplina = '$id_disciplina' and IdFaseNota = '$id_fasenota_media' ");
                  $res_r222 = $query_r222->fetchAll(PDO::FETCH_ASSOC);

                  $notafase_media_parcial = $res_r222[0]['NotaFase'];


                  if (isset($notafase_media_parcial)) {
                   $notafase_media_parcialF = number_format($notafase_media_parcial, 2, ',', '.');
                 }




                 if ($notafase_media_parcial >= 7) {
                  $classe_sit_media = "text-success";
                }else{
                  $classe_sit_media = "text-danger";
                }

              }



              ?>


              <tr class="table-light">
                <td ><small><?php echo $nome ?></small>

                </td>

                <td id="situacao_disc" class="<?php echo $classe_sit ?> "><small><?php echo  $situacao ?></small></td>

                <td class="text-center <?php echo $classe_notafase ?> "><small><?php echo $notafaseF ?></small></td>

                <?php if ($numerofase == 3): ?>
                  <th class="<?php echo  $classe_sit_media ?> text-center"><small><?php echo $notafase_media_parcialF ?></small></th>

                <?php endif ?>


                <td>
                  <a onclick="lancarNotas(<?php echo  $id_aluno; ?>, '<?php echo $nome ?>', <?php echo $maximo_nota ?>, '<?php echo $disciplina ?>', <?php echo $id_disciplina ?>,<?php echo $numeroFase ?>)" href="" class='text-info mr-1' title='Lançar Notas'><i class='fas fa-sticky-note fa-1x'></i></a>
                </td>
              </tr>


            <?php } } elseif ($numeroFase == 5) {

              $query_r11 = $pdo->query("SELECT * FROM tbsituacaoalunodisciplina where IdTurma = '$id_turma' and IdDisciplina = '$id_disciplina' and (SituacaoAtual = 'Recuperação Anual' or SituacaoAtual = 'Recuperação Prova Final' or SituacaoAtual = 'Aprovado por REC' or SituacaoAtual = 'Aprovado Prova Final' or SituacaoAtual = 'Reprovado Prova Final')");
              $res_r11 = $query_r11->fetchAll(PDO::FETCH_ASSOC);
              for ($i=0; $i < count($res_r11); $i++) { 
                foreach ($res_r11[$i] as $key => $value) {
                }
                $aluno_rec = $res_r11[$i]['IdAluno'];
                $situacao = $res_r11[$i]['SituacaoAtual'];
                
                $notafase_rec = null;
                $notafase_recF = null;
                $notafase_media_parcial = null; 
                $notafase_media_parcialF = null;
                $mediaAnualF = null;
                $mediaAnual = null;
                

                $query_r = $pdo->query("SELECT * FROM tbaluno where IdAluno = '$aluno_rec' order by NomeAluno");
                $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);

                $nome = $res_r[0]['NomeAluno'];
                $email = $res_r[0]['Email'];
                $id_endereco = $res_r[0]['IdEndereco'];
                $cpf = $res_r[0]['CPF'];
                $foto = $res_r[0]['foto'];

                if ($situacao == "Aprovado" or $situacao == "Aprovado por REC" or $situacao == "Aprovado Prova Final") {
                  $classe_sit = "text-success";
                }else if($situacao == "Cursando"){
                  $classe_sit = "text-dark";
                }else{
                  $classe_sit = "text-danger";
                }

                $query_r2232 = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$id_periodo' and IdSerie = '$id_serie' and NumeroFase = 4");
                $res_r2232 = $query_r2232->fetchAll(PDO::FETCH_ASSOC);
                $id_fasenota_media = $res_r2232[0]['IdFaseNota'];


                $query_r222 = $pdo->query("SELECT * FROM tbfasenotaaluno where IdAluno = '$aluno_rec' and IdTurma = '$id_turma' and IdDisciplina = '$id_disciplina' and IdFaseNota = '$id_fasenota_media' ");
                $res_r222 = $query_r222->fetchAll(PDO::FETCH_ASSOC);

                $notafase_media_parcial = $res_r222[0]['NotaFase'];


                if (isset($notafase_media_parcial)) {
                 $notafase_media_parcialF = number_format($notafase_media_parcial, 2, ',', '.');
               }




               if ($notafase_media_parcial >= 7) {
                $classe_sit_media = "text-success";
              }else{
                $classe_sit_media = "text-danger";
              }

              $query_rec = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$id_periodo' and IdSerie = '$id_serie' and NumeroFase = 5");
              $res_rec = $query_rec->fetchAll(PDO::FETCH_ASSOC);
              $id_fasenota_rec = $res_rec[0]['IdFaseNota'];

              if (isset( $id_fasenota_rec)) {

               $query_rec1 = $pdo->query("SELECT * FROM tbfasenotaaluno where IdAluno = '$aluno_rec' and IdTurma = '$id_turma' and IdDisciplina = '$id_disciplina' and IdFaseNota = '$id_fasenota_rec' ");
               $res_rec1 = $query_rec1->fetchAll(PDO::FETCH_ASSOC);

               $notafase_rec = $res_rec1[0]['NotaFase'];

               if (isset($notafase_rec)) {
                 $notafase_recF = number_format($notafase_rec, 2, ',', '.');
               }  



             }

             $query_m = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$id_periodo' and IdSerie = '$id_serie' and NumeroFase = 6");
             $res_m = $query_m->fetchAll(PDO::FETCH_ASSOC);
             $id_fasenota_m = $res_m[0]['IdFaseNota'];

             if (isset( $id_fasenota_m)) {

               $query_media = $pdo->query("SELECT * FROM tbfasenotaaluno where IdAluno = '$aluno_rec' and IdTurma = '$id_turma' and IdDisciplina = '$id_disciplina' and IdFaseNota = '$id_fasenota_m' ");
               $res_media = $query_media->fetchAll(PDO::FETCH_ASSOC);

               $mediaAnual = $res_media[0]['NotaFase'];

               if (isset($mediaAnual)) {
                 $mediaAnualF = number_format($mediaAnual, 2, ',', '.');
               }  

               if ($mediaAnual >= 7) {
                $classe_sit_mediaAnual = "text-success";
              }else{
                $classe_sit_mediaAnual = "text-danger";
              }



            }



            ?>

            <tr class="table-light">
              <td ><small> <?php echo $nome ?></small>

              </td>

              <td class="<?php echo $classe_sit ?>"><small><?php echo  $situacao ?></small></td>

              <td class="<?php echo $classe_sit_media ?> text-center"><small><?php echo $notafase_media_parcialF ?></small></td>

              <th class="text-primary text-center"><small><b><?php echo $notafase_recF ?></b></small></th>

              <th class="<?php echo $classe_sit_mediaAnual ?> text-center"><small><b><?php echo $mediaAnualF ?></b></small></th>


              <td>
                <a onclick="lancarNotas_rec(<?php echo  $aluno_rec; ?>, '<?php echo $nome ?>', <?php echo $maximo_nota_rec ?>, '<?php echo $disciplina ?>', <?php echo $id_disciplina ?>,<?php echo $numeroFase ?>)" href="" class='text-info mr-1' title='Lançar nota Recuperação Anual'><i class='fas fa-sticky-note fa-1x'></i></a>
              </td>
            </tr>




          <?php } } elseif ($numeroFase == 7) 
          //Aqui vai ser listado os alunos que estão na prova final e suas respectivas médias.

          {

            $query_r11 = $pdo->query("SELECT * FROM tbsituacaoalunodisciplina where IdTurma = '$id_turma' and IdDisciplina = '$id_disciplina' and (SituacaoAtual = 'Recuperação Prova Final' or SituacaoAtual = 'Aprovado Prova Final' or SituacaoAtual = 'Reprovado Prova Final')");
            $res_r11 = $query_r11->fetchAll(PDO::FETCH_ASSOC);
            for ($i=0; $i < count($res_r11); $i++) { 
              foreach ($res_r11[$i] as $key => $value) {
              }
              $aluno_recFinal = $res_r11[$i]['IdAluno'];
              $situacao = $res_r11[$i]['SituacaoAtual'];

                //Tenho q colocar as variaveis nulas para nao repetir no loop
              $mediaParcialF = null;
              $mediaParcial = null;
              $mediaFinal = null;
              $mediaFinalF = null;
              $provaFinalF = null;
              $provaFinal = null;

                //selecionar os alinos na prova final
              $query_r = $pdo->query("SELECT * FROM tbaluno where IdAluno = '$aluno_recFinal' order by NomeAluno");
              $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);

              $nome = $res_r[0]['NomeAluno'];
              $email = $res_r[0]['Email'];
              $id_endereco = $res_r[0]['IdEndereco'];
              $cpf = $res_r[0]['CPF'];
              $foto = $res_r[0]['foto'];

                //aplicar as classes de texto
              if ($situacao == "Aprovado" or $situacao == "Aprovado por REC" or $situacao == "Aprovado Prova Final") {
                $classe_sit = "text-success";
              }else if($situacao == "Cursando"){
                $classe_sit = "text-dark";
              }else{
                $classe_sit = "text-danger";
              }


                //Recuperar a nota da Média Parcial e aplicar as classes
              $query_m = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$id_periodo' and IdSerie = '$id_serie' and NumeroFase = 4");
              $res_m = $query_m->fetchAll(PDO::FETCH_ASSOC);
              $id_fasenota_m = $res_m[0]['IdFaseNota'];

              if (isset( $id_fasenota_m)) {

               $query_media = $pdo->query("SELECT * FROM tbfasenotaaluno where IdAluno = '$aluno_recFinal' and IdTurma = '$id_turma' and IdDisciplina = '$id_disciplina' and IdFaseNota = '$id_fasenota_m' ");
               $res_media = $query_media->fetchAll(PDO::FETCH_ASSOC);

               $mediaParcial = $res_media[0]['NotaFase'];


               if (isset($mediaParcial)) {
                 $mediaParcialF = number_format($mediaParcial, 2, ',', '.');
               }  

               if ($mediaParcial >= 7) {
                $classe_sit_mediaParcial = "text-success";
              }else{
                $classe_sit_mediaPacial = "text-danger";
              }

              
            }

            //Recuperar a nota da Prova Final e aplicar as classes
            $query_final = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$id_periodo' and IdSerie = '$id_serie' and NumeroFase = 7");
            $res_final = $query_final->fetchAll(PDO::FETCH_ASSOC);
            $id_fasenota_final = $res_final[0]['IdFaseNota'];

            if (isset( $id_fasenota_final)) {

             $query_provaFinal = $pdo->query("SELECT * FROM tbfasenotaaluno where IdAluno = '$aluno_recFinal' and IdTurma = '$id_turma' and IdDisciplina = '$id_disciplina' and IdFaseNota = '$id_fasenota_final' ");
             $res_provaFinal = $query_provaFinal->fetchAll(PDO::FETCH_ASSOC);

             $provaFinal= $res_provaFinal[0]['NotaFase'];


             if (isset($provaFinal)) {
               $provaFinalF = number_format($provaFinal, 2, ',', '.');
               $classe_sit_provaFinal = "text-primary";
             }  


           }

            //Recuperar a Média Final e aplicar as classes
           $query_Mediafinal = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$id_periodo' and IdSerie = '$id_serie' and NumeroFase = 8");
           $res_Mediafinal = $query_Mediafinal->fetchAll(PDO::FETCH_ASSOC);
           $id_fasenota_Mediafinal = $res_Mediafinal[0]['IdFaseNota'];

           if (isset( $id_fasenota_Mediafinal)) {

             $query_mediaFinal = $pdo->query("SELECT * FROM tbfasenotaaluno where IdAluno = '$aluno_recFinal' and IdTurma = '$id_turma' and IdDisciplina = '$id_disciplina' and IdFaseNota = '$id_fasenota_Mediafinal' ");
             $res_mediaFinal = $query_mediaFinal->fetchAll(PDO::FETCH_ASSOC);

             $mediaFinal= $res_mediaFinal[0]['NotaFase'];


             if (isset($mediaFinal)) {
               $mediaFinalF = number_format($mediaFinal, 2, ',', '.');
               if ($mediaFinal >= $media_aprovacao_prova_final) {
                $classe_sit_mediaFinal = "text-success";
              }else{
                $classe_sit_mediaFinal = "text-danger";
              }
            }  


          }



          ?>

          <tr>
            <td><small> <?php echo $nome ?></small>

            </td>

            <td id="" class="<?php echo $classe_sit ?>"><small><?php echo  $situacao ?></small></td>

            <td class="<?php echo $classe_sit_mediaPacial ?> text-center"><small><?php echo $mediaParcialF ?></small></td>

            <th class="text-primary text-center"><small><b><?php echo $provaFinalF ?></b></small></th>

            <th class="<?php echo $classe_sit_mediaFinal ?> text-center"><small><b><?php echo $mediaFinalF ?></b></small></th>


            <td>
              <!-- Chama uma função com alguns parametros e depois chama a modal -->
              <a onclick="lancarNotas_provaFinal(<?php echo  $aluno_recFinal; ?>, '<?php echo $nome ?>', <?php echo $maximo_nota_prova_final ?>, '<?php echo $disciplina ?>', <?php echo $id_disciplina ?>,<?php echo $numeroFase ?>)" href="" class='text-info mr-1' title='Lançar nota Prova Final'><i class='fas fa-sticky-note fa-1x'></i></a>
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


        ?>


        <form id="form-notas_rec" method="POST" class="mt-2">


          <div class="form-group">
            <label>Nota Recuperação Anual</label>
            <input type="number"  min=0 step="0.01" max="<?php echo $maximo_nota_rec ?>" class="form-control" id="nota_rec" name="nota_rec" placeholder="Nota recuperação anual">
          </div>


          <div align="right">
            <button type="submit" name="btn-salvar-nota_rec" id="btn-salvar-nota_rec" class="btn btn-primary mb-4">Salvar</button>
          </div>

          <!-- input que mandam dados pelo form -->
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

<div class="modal" id="modal-lancar-notas-final" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-light">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo $nome_disc ?> - <?php echo $nome_turma ?> - <span id="txtnomealuno_final"></span> - <span id="txtdisciplina_final"></span></h5>
        <button type="button" onclick="atualizarPagina()" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


        <span class=""><b>Notas do Aluno </b></span>
        - <span id="total_notas_final">  </span> de <span id="maximonota_final"> <?php echo $maximo_nota_prova_final ?></span> Pontos
        <div id="listar-notas_final" class="mt-2">

        </div>

        <?php  
        $id_turma = $_GET['id'];
        $id_disciplina = $_GET['id_disciplina'];

        ?>


        <form id="form-notas_final" method="POST" class="mt-2">


          <div class="form-group">
            <label>Nota Prova Final</label>
            <input type="number"  min=0 step="0.01" max="<?php echo $maximo_nota_prova_final ?>" class="form-control" id="nota_final" name="nota_final" placeholder="Nota prova final">
          </div>


          <div align="right">
            <button type="submit" name="btn-salvar-nota_final" id="btn-salvar-nota_final" class="btn btn-primary mb-4">Salvar</button>
          </div>

          <input type="hidden" name="turma_final" value="<?php echo $_GET['id'] ?>">
          <input type="hidden" name="periodo_final" value="<?php echo $_GET['id_periodo'] ?>">
          <input type="hidden" id="fase_final" name="fase_final" value="<?php echo $_GET['numero_fase'] ?>">
          <input type="hidden" id="txtidaluno_final" name="aluno_final"> 
          <input type="hidden" id="disciplina_final" name="disciplina_final" value="<?php echo $_GET['id_disciplina'] ?>"> 

          <input type="hidden" name="serie_final" value="<?php echo $id_serie ?>">



        </form>
        


        <small> <div align="center" id="mensagem-notas_final" class=""></div></small>

      </div>

    </div>
  </div>
</div>


<div class="modal" id="modal-chamada-aulas" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
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
              <table class="table table-hover" id="dataTable2" width="100%" cellspacing="0">
                <thead class="table-danger">
                  <tr class="text-dark">
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


                  <tr class="table-light">
                    <td>
                      <?php echo $nome ?>
                    </td>
                    
                    <td><?php echo $email ?></td>
                    
                    <td><img src="../img/alunos/<?php echo $foto ?>" width="50"></td>


                    <td class="text-nowrap">
                     <a href="index.php?pag=<?php echo $pag ?>&funcao=presenca&id_aluno=<?php echo $id_aluno ?>&id_aula=<?php echo $_GET['id_aula'] ?>&id=<?php echo $_GET['id'] ?>&id_periodo=<?php echo $_GET['id_periodo'] ?>&numero_fase=<?php echo $_GET['numero_fase'] ?>&id_disciplina=<?php echo $_GET['id_disciplina'] ?>" class='text-success mr-1' title='Presente'><i class='far fa-check-circle'></i></a>

                     <a href="index.php?pag=<?php echo $pag ?>&funcao=falta&id_aluno=<?php echo $id_aluno ?>&id_aula=<?php echo $_GET['id_aula'] ?>&id=<?php echo $_GET['id'] ?>&id_periodo=<?php echo $_GET['id_periodo'] ?>&numero_fase=<?php echo $_GET['numero_fase'] ?>&id_disciplina=<?php echo $_GET['id_disciplina'] ?>" class='text-danger mr-1' title='Falta'><i class="fas fa-times-circle"></i></a>


                    

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

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "notasgerais") {
  echo "<script>$('#modal-notas-gerais').modal('show');</script>";
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

  require('turma/atualizar-faltas.php');




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

  require('turma/atualizar-faltas.php');

  echo "<script>window.location='index.php?pag=$pag&funcao=fazerchamada&id=$id_turma_chamada&id_periodo=$id_periodo_chamada&id_aula=$id_aula_chamada&id_disciplina=$disciplina_chamada&numero_fase=$numerofase_chamada';</script>";


}




/*
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


} */


?>

<a type="button" title="Ver disciplinas" href="index.php?pag=disciplinas&id=<?php echo $_GET['id'] ?>&id_periodo=<?php echo $_GET['id_periodo'] ?>" class="btn btn-primary mb-3">Voltar</a>




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
        }else{
          //listarDados();
          $('#mensagem_aulas').addClass('text-danger')
          $('#mensagem_aulas').text(mensagem);




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
      $("#form_upload").submit(function () {
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
        


        listarDadosNotasREC(idaluno, iddisciplina, numerofase);

        $('#modal-lancar-notas-rec').modal('show');
      }


    </script>

    <script type="text/javascript">
      function lancarNotas_provaFinal(idaluno, nomealuno, maximonota, disciplina, iddisciplina, numerofase) {
        event.preventDefault();


        var pag = "<?=$pag?>";
        

        $("#txtnomealuno_final").text(nomealuno);
        document.getElementById('txtidaluno_final').value = idaluno;
        
        //document.getElementById('txtiddisciplina').value = iddisciplina;

        //$("#txtnomealuno").text(nomealuno);
        $("#maximonota_final").text(maximonota);
        $("#txtdisciplina_final").text(disciplina);
        


        listarDadosNotasFINAL(idaluno, iddisciplina, numerofase);

        $('#modal-lancar-notas-final').modal('show');
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
              
              listarDadosNotasREC(idaluno, iddisciplina, numerofase);
              
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

    <script type="text/javascript">
      $("#form-notas_final").submit(function () {
        var pag = "<?=$pag?>";


        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
          url: pag + "/inserir-nota-final.php",
          type: 'POST',
          data: formData,

          success: function (mensagem) {

            $('#mensagem-notas_final').removeClass()

            if (mensagem.trim() == "Salvo com Sucesso!") {

              var iddisciplina = document.getElementById('disciplina_final').value;
              var idaluno = document.getElementById('txtidaluno_final').value;
              var numerofase = document.getElementById('fase_final').value;

              //console.log(iddisciplina);
              
              listarDadosNotasFINAL(idaluno, iddisciplina, numerofase);
              
              $('#mensagem-notas_final').addClass('text-success')
              $('#mensagem-notas_final').text(mensagem);
              
             // window.location.reload();


           }else{
            $('#mensagem-notas_final').addClass('text-danger')
            $('#mensagem-notas_final').text(mensagem);

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

           }else{
            $('#mensagem-notas').addClass('text-danger')
            $('#mensagem-notas').text(mensagem);

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
      function listarDadosNotasREC(aluno, iddisciplina, numerofase){
        var pag = "<?=$pag?>";
        var turma = "<?=$id_turma?>";
        var periodo = "<?=$id_per?>";


        $.ajax({
         url: pag + "/listar-notas-rec.php",
         method: "post",
         data: {turma, periodo, aluno, iddisciplina, numerofase},
         dataType: "html",
         success: function(result){
          $('#listar-notas_rec').html(result)

        },


      })
      }
    </script>

    <script type="text/javascript">
      function listarDadosNotasFINAL(aluno, iddisciplina, numerofase){
        var pag = "<?=$pag?>";
        var turma = "<?=$id_turma?>";
        var periodo = "<?=$id_per?>";


        $.ajax({
         url: pag + "/listar-notas-final.php",
         method: "post",
         data: {turma, periodo, aluno, iddisciplina, numerofase},
         dataType: "html",
         success: function(result){
          $('#listar-notas_final').html(result)

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
          "ordering": true,
          "stateSave": true,
          "stateDuration": 60 * 60 * 24,
          "autoWidth": false
        })

      });
    </script>

    <script type="text/javascript">
      $(document).ready(function () {
        $('#dataTable2').dataTable({
          "ordering": true,
          "stateSave": true,
          "stateDuration": 60 * 60 * 24,
          "autoWidth": false
        })

      });
    </script>

    <script type="text/javascript">
      $(document).ready(function () {
        $('#dataTable-notas-gerais').dataTable({
          "ordering": true,
          "stateSave": true,
          "stateDuration": 60 * 60 * 24,
          "autoWidth": false
        })

      });
    </script>

