<?php 

@session_start();
require_once("../conexao.php"); 

$id_turma = $_GET['id'];
$id_disciplina = $_GET['id_disciplina'];
$id_periodo = $_GET['id_periodo'];



$query = $pdo->query("SELECT * FROM tbaluno where RegistroNascimentoNumero = '$cpf_usu'  order by IdAluno asc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_aluno = $res[0]['IdAluno'];


$query_2 = $pdo->query("SELECT * FROM tbturma where IdTurma = '$id_turma' ");
$res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
$id_serie = $res_2[0]['IdSerie'];

$nome_turma = $res_2[0]['NomeTurma'];
$sigla = $res_2[0]['SiglaTurma'];
$totalvagas = $res_2[0]['TotalVagas'];
$id_sala = $res_2[0]['IdSala'];
$data_final = $res_2[0]['DataFinal'];
$turno = $res_2[0]['TurnoPrincipal'];

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



//RECUPERAR O TOTAL DE MESES ENTRE DATAS
$d1 = new DateTime($data_inicio);
$d2 = new DateTime($data_final);
$intervalo = $d1->diff( $d2 );
$anos = $intervalo->y;
$meses = $intervalo->m + ($anos * 12);

$data_finalF = implode('/', array_reverse(explode('-', $data_final)));

$query_2 = $pdo->query("SELECT * FROM tbdisciplina where IdDisciplina = '$id_disciplina' ");
$res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);

$nome_disciplina = $res_2[0]['NomeDisciplina'];



$query_prof = $pdo->query("SELECT * FROM tbturmaprofessor where IdTurma = '$id_turma' and IdDisciplina = '$id_disciplina' ");
$res_prof = $query_prof->fetchAll(PDO::FETCH_ASSOC); 

$id_professor = $res_prof[0]['IdProfessor'];



$query_resp = $pdo->query("SELECT * FROM tbprofessor where IdProfessor = '$id_professor' ");
$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);                    
$nome_prof = $res_resp[0]['NomeProfessor'];
$email_prof = $res_resp[0]['Email'];
$imagem_prof = $res_resp[0]['foto'];


if($data_final < date('Y-m-d')){
 $concluido = 'Sim';
}else{
 $concluido = 'Não';
}



$id_get_periodo = @$_GET['id_periodo'];


//RECUPERAR A % DE FREQUENCIA DO ALUNO
$contador = 0;
$query = $pdo->query("SELECT * FROM aulas where turma = '$id_turma' and periodo = '$id_get_periodo' and id_disciplina = '$id_disciplina' order by id asc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_aulas2 = count($res);
$totalPorcentagemSoma = 0;
$totalPorcentagemSomaF = 0;
for ($i=0; $i < count($res); $i++) { 
  foreach ($res[$i] as $key => $value) {
  }

  if(@count($res) > 0){
    $contador = $contador + 1;
    $nome = $res[$i]['nome'];
    $id_aula = $res[$i]['id'];

          //CALCULAR FREQUÊNCIA
    $query2 = $pdo->query("SELECT * FROM chamadas where turma = '$id_turma' and aluno = '$id_aluno' and aula = '$id_aula'");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    $total_presencas2 = 0;
    //$total_chamadas2 = 0;
    $porcentagem2 = 0;
    $totalPorcentagem = 0;
    
    $totalPorcentagemF = 0;
    for ($i2=0; $i2 < count($res2); $i2++) { 
      foreach ($res2[$i2] as $key => $value) {
      }
      $total_chamadas2 = count($res2);
      $presenca = @$res2[$i2]['presenca'];

      if($presenca == 'P'){
        $total_presencas2 = $total_presencas2 + 1;
      }

      $porcentagem2 = ($total_presencas2 * 100) / $total_aulas2;
      
    }


    $totalPorcentagem = $totalPorcentagem + $porcentagem2;
    $totalPorcentagemSoma = $totalPorcentagem + $totalPorcentagemSoma;

  }
}

//$totalPorcentagemSoma = $totalPorcentagemSoma / $contador . ' ' ;
$totalPorcentagemSomaF = number_format($totalPorcentagemSoma, 2, ',', '.');

if($totalPorcentagemSoma < $media_porcentagem_presenca){
  $cor_presenca2 = 'text-danger';
}else{
  $cor_presenca2 = 'text-success';
}


$encoding = mb_internal_encoding();

?>

<h6><b><?php echo mb_strtoupper($nome_disciplina, $encoding) ?> / <?php echo strtoupper($nome_disc) ?> <?php echo $nome_turma ?></b>
  <?php if($total_pontos_curso >= $media_pontos_minimo_aprovacao){

    ?>
    <a title="Retirar Certificado" href="../rel/certificado.php?id_turma=<?php echo $id_turma ?>&id_aluno=<?php echo $id_aluno ?>" target="_blank"> 
      <img src="../img/ico-certificado.png" width="30px">
    </a>

  <?php } ?>

</h6>
<hr>

<small>
  <div class="mb-3">

   <span class="mr-3"><i><b>Disciplina Concluída </b> <?php echo $concluido ?></i></span>
   <span class="mr-3"><i><b>Dias de Aula </b> <?php echo $dia ?></i></span>
   <span class="mr-3"><i><b>Horário Aula </b> <?php echo $horario ?></i></span>
   <span class="mr-3"><i><b>Ano Início </b> <?php echo $ano ?></i></span>
   <span class="mr-3"><i><b>Data da Conclusão </b> <?php echo $data_finalF ?></i></span>
 </div>
</small>

<hr>

<small>
  <div class="mb-3">
   <span class="mr-3"><img src="../img/professores/<?php echo $imagem_prof ?>" width="70px"></i></span>
   <span class="mr-3"><i><b>Professor:</b> <?php echo $nome_prof ?></i></span>
   <span class="mr-3"><i><b>Email Professor: </b> <?php echo $email_prof ?></i></span>


 </div>
</small>
<hr>


<div class="row">

  <div class="col-xl-3 col-md-6 mb-4">
   <a class="text-dark" href="" data-toggle="modal" data-target="#modal-pagamentos" title="Informações da Turma">
     <div class="card text-danger shadow h-100 py-2">
      <div class="card-body">
       <div class="row no-gutters align-items-center">
        <div class="col mr-2">
         <div class="text-xs font-weight-bold  text-danger text-uppercase">MENSALIDADES</div>
         <div class="text-xs text-secondary"> <?php echo $meses ?> PARCELAS</div>
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
  <a class="text-dark" href="index.php?pag=turma&funcao=periodos&id=<?php echo $id_turma ?>&id_disciplina=<?php echo $id_disciplina ?>&id_periodo=<?php echo $id_periodo ?>&frequencia=sim" title="Frequência na disciplina">
   <div class="card text-dark shadow h-100 py-2">
    <div class="card-body">
     <div class="row no-gutters align-items-center">
      <div class="col mr-2">
       <div class="text-xs font-weight-bold  text-dark text-uppercase">FREQUÊNCIA</div>
       <div class="text-xs text-secondary"> <span class="<?php echo $cor_presenca2 ?>"><?php echo $totalPorcentagemSomaF ?>% </span> DE FREQUÊNCIA</div>
     </div>
     <div class="col-auto" align="center">
       <i class="fas fa-calendar-day fa-2x  text-dark"></i><br>
       <span class="text-xs"></span>
     </div>
   </div>
 </div>
</div>
</a>
</div>




<div class="col-xl-3 col-md-6 mb-4">
  <?php $id_periodo = @$_GET['id_periodo'] ?>
  <a class="text-dark" href="index.php?pag=turma&funcao=periodos&id=<?php echo $id_turma ?>&id_disciplina=<?php echo $id_disciplina ?>&id_periodo=<?php echo $id_periodo ?>&boletim=sim" title="Boletim da Disciplina">
   <div class="card text-primary shadow h-100 py-2">
    <div class="card-body">
     <div class="row no-gutters align-items-center">
      <div class="col mr-2">
       <div class="text-xs font-weight-bold  text-primary text-uppercase">BOLETIM</div>
       <div class="text-xs text-secondary"> CONSULTAR NOTAS</div>
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
  <a class="text-dark" href="index.php?pag=turma&funcao=periodos&id=<?php echo $id_turma ?>&id_disciplina=<?php echo $id_disciplina ?>&id_periodo=<?php echo $id_periodo ?>&aulas=sim" title="Aulas da Disciplina">
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


</div>



<div class="modal" id="modal-pagamentos" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <?php 
        $id_m = $_GET['id'];
        $query = $pdo->query("SELECT * FROM matriculas where id = '$id_mat' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        $id = $res[0]['aluno'];
        $id_turma = $res[0]['turma'];

        $query = $pdo->query("SELECT * FROM tbaluno where IdAluno = '$id' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        $nome_aluno = $res[0]['nome'];

        $query = $pdo->query("SELECT * FROM turmas where id = '$id_turma' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        $disciplina = $res[0]['disciplina'];

        $query = $pdo->query("SELECT * FROM disciplinas where id = '$disciplina' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
       // $nome_disciplina = $res[0]['nome'];
        ?>
        <h6 class="modal-title"></h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

      </div>
      <div class="modal-body">

        <small>
         <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">Parcela</th>
              <th scope="col">Vencimento</th>
              <th scope="col">Valor</th>
              <th scope="col">Pago</th>
              <?php if($pgto_boleto == 'Sim'){ 
                echo '<th scope="col">Arquivo</th>';
              } ?>
            </tr>
          </thead>
          <tbody>



            <?php 



                  //VERIFICAR SE EXISTE ATRASO NO PAGAMENTO DAS MATRICULAS
            $query_3 = $pdo->query("SELECT * FROM pgto_matriculas where matricula = '$id_mat' ");
            $res_3 = $query_3->fetchAll(PDO::FETCH_ASSOC);


            for ($i2=0; $i2 < count($res_3); $i2++) { 
              foreach ($res_3[$i2] as $key => $value) {
              }

              $data_venc = $res_3[$i2]['data_vencimento'];
              $pago = $res_3[$i2]['pago'];
              $valor = $res_3[$i2]['valor'];
              $id_pgto = $res_3[$i2]['id'];
              $arquivo = $res_3[$i2]['arquivo'];

              if($data_venc < date('Y-m-d') and $pago != 'Sim'){
                $atrasado = 'Sim';
              }

              $valor = number_format($valor, 2, ',', '.');
              $data_venc = implode('/', array_reverse(explode('-', $data_venc)));





              ?>


              <tr>
                <td scope="row"><?php echo $i2+1 ?></td>

                <td>
                  <?php if($atrasado == 'Sim'){ ?>
                   <span class="text-danger"><?php echo $data_venc; 
                   $atrasado = 'Não';
                   ?></span>
                 <?php }else{ ?>
                  <span class="text-dark"> <?php echo $data_venc ?></span>
                <?php } ?>
              </td>

              <td> R$ <?php echo $valor ?> </td>

              <td>
                <?php if($pago == 'Sim'){ ?>
                  <span class="text-success"> <?php echo $pago ?></span>
                <?php }else{ ?>
                  <span class="text-danger"><?php echo $pago ?></span>
                <?php } ?>
              </td>

              <td>
               <?php if($pgto_boleto == 'Sim'){ ?>

                <?php if($arquivo != ''){ ?>
                 <a href="../img/arquivos/<?php echo $arquivo ?>" class="text-primary ml-2" target="_blank" title="Abrir o Boleto / Carnê">Ver Arquivo</a>   
               <?php } } ?>
             </td>

           </tr>

         <?php  }  ?>

       </tbody>
     </table>
   </small>

 </div>

</div>
</div>
</div>


<div class="modal" id="modal-periodos" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Disciplina: <?php echo $nome_disciplina ?> / <?php echo $nome_disc ?> <?php echo $nome_turma?>
      </h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">

      <?php 

      $id_turma = @$_GET['id'];
      $id_periodo = @$_GET['id_periodo'];
      $id_disciplina = @$_GET['id_disciplina'];


      if(@$_GET['aulas'] != ""){
        $query = $pdo->query("SELECT * FROM tbfases_ano where NumeroFase >=1 and NumeroFase <=3 order by NumeroFase asc ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
      }

      if(@$_GET['notas'] != ""){
        $query = $pdo->query("SELECT * FROM tbfases_ano where FaseInformada = 1 order by NumeroFase asc ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
      }

      if(@$_GET['frequencia'] != ""){
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
          <a href="index.php?pag=turma&funcao=aulas&id=<?php echo $id_turma ?>&numero_fase=<?php echo $numeroFase ?>&id_aluno=<?php echo $id_aluno?>&id_periodo=<?php echo $id_periodo ?>&id_disciplina=<?php echo $id_disciplina ?>" name="btn-salvar-aula" class="btn btn-primary text-light m-1"><?php echo $nome ?></a>
        <?php } ?>


        <?php if(@$_GET['notas'] != ""){ ?>
          <a href="index.php?pag=turma&funcao=notas&id=<?php echo $id_turma ?>&numero_fase=<?php echo $numeroFase ?>&id_aluno=<?php echo $id_aluno?>&id_periodo=<?php echo $id_periodo ?>&id_disciplina=<?php echo $id_disciplina ?>" name="btn-salvar-notas" class="btn btn-primary text-light m-1"><?php echo $nome ?></a>
        <?php } ?>


        <?php if(@$_GET['frequencia'] != ""){ ?>
          <a href="index.php?pag=turma&funcao=frequencias&id=<?php echo $id_turma ?>&numero_fase=<?php echo $numeroFase ?>&id_aluno=<?php echo $id_aluno?>&id_periodo=<?php echo $id_periodo ?>&id_disciplina=<?php echo $id_disciplina ?>" name="btn-salvar-chamada" class="btn btn-primary text-light m-1"><?php echo $nome ?></a>
        <?php } ?>


      <?php } ?>

      <?php if(@$_GET['boletim'] != ""){ ?>
        <div class="row">
          <div class="col-md-6">
            <a href="../rel/boletim_geral.php?id_turma=<?php echo $id_turma ?>" target="_blank" title="Gerar Boletim">
              <i class='fas fa-clipboard text-primary mr-1'></i>Boletim Geral </a>
            </div>

            <div class="col-md-6" align="right">
              <span class="<?php echo $classe_media_nota ?>" ><?php echo $total_notas_curso ?> Pontos no Total</span>
            </div>
          </div>
        <?php } ?>

      </div>




    </div>
  </div>
</div>


<div class="modal" id="modal-aulas" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <?php  
        $id_turma = @$_GET['id'];
        $id_periodo = @$_GET['id_periodo'];
        $id_disciplina = @$_GET['id_disciplina'];
        $numerofase = @$_GET['numero_fase'];

        $query = $pdo->query("SELECT * FROM aulas where turma = '$id_turma' and periodo = '$id_periodo' and id_disciplina = '$id_disciplina' and NumeroFase = '$numerofase' order by id asc ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC); 
        $total_aulas = count($res);


        ?>
        <h5 class="modal-title">Disciplina: <?php echo $nome_disciplina ?> / <?php echo $nome_disc ?> <?php echo $nome_turma?> - <?php echo $total_aulas ?> Aulas </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <?php if ($total_aulas == 0){?>
          <div class="text-danger text-center">Ainda não foi lançada a frequência para esse trimestre!</div>
        <?php }else{ ?>

          <span class=""><b>Aulas do Curso</b></span>
          <div id="listar-aulas" class="mt-2">

          </div>



        </div>
        <?php 

        $id_turma = @$_GET['id'];
        $id_periodo = @$_GET['id_periodo'];
        $id_disciplina = @$_GET['id_disciplina'];
        $id_aluno = @$_GET['id_aluno'];
        $numerofase = @$_GET['numero_fase'];
       //CALCULAR FREQUÊNCIA
        $query = $pdo->query("SELECT * FROM aulas where turma = '$id_turma' and periodo = '$id_periodo' and id_disciplina = '$id_disciplina' and NumeroFase = '$numerofase' order by id asc ");

        $res = $query->fetchAll(PDO::FETCH_ASSOC);

        $total_presencas = 0;
        $total_aulas = 0;
        $porcentagem = 0;
        $porcentagemF = 0;
        for ($i2=0; $i2 < count($res); $i2++) { 
          foreach ($res[$i2] as $key => $value) {
          }
          $total_aulas = count($res);
         // $presenca = @$res2[$i2]['presenca'];
          $id_aula = $res[$i2]['id'];

          $query2 = $pdo->query("SELECT * FROM chamadas where turma = '$id_turma' and aluno = '$id_aluno' and aula = '$id_aula'");
          $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

          $presenca = @$res2[0]['presenca'];




          if($presenca == 'P'){
            $total_presencas = $total_presencas + 1;
          }

          $porcentagem = ($total_presencas * 100) / $total_aulas;
          $porcentagemF = number_format($porcentagem, 2, ',', '.');


          if($porcentagem < $media_porcentagem_presenca){
            $cor_presenca = 'text-danger';
          }else{
            $cor_presenca = 'text-success';
          }

        }


        ?>



        <div class="modal-footer">
         <small> <div class="text-primary">Porcentagem de Frequência:</div></small> <small><span class="<?php echo $cor_presenca ?>"><?php echo $porcentagemF ?>%</span>

         </div>

       <?php } ?>


     </div>

   </div>
 </div>
</div>

<div class="modal" id="modal-aulas-grade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <?php 

        $id_turma = @$_GET['id'];
        $id_periodo = @$_GET['id_periodo'];
        $id_disciplina = @$_GET['id_disciplina'];
        $numerofase = @$_GET['numero_fase'];

        $query = $pdo->query("SELECT * FROM aulas where turma = '$id_turma' and periodo = '$id_periodo' and id_disciplina = '$id_disciplina' and NumeroFase = '$numerofase' order by id asc ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC); 
        $total_aulas = count($res);


        ?>


        <h5 class="modal-title"><?php echo $nome_disciplina ?> - <?php echo $nome_disc ?> <?php echo $nome_turma?> - <?php echo $total_aulas ?> Aulas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <?php if ($total_aulas == 0){ ?>

          <div class="text-danger text-center">Ainda não foram lançadas aulas para esse trimestre!</div>
          
        <?php }else{ ?>

          <span class=""><b>Aulas do Curso</b></span> <br><br>

          <small>
           <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">Aula</th>
                <th scope="col">Nome</th>
                <th scope="col">Descrição</th>
                <th scope="col">Data</th>
                <th scope="col">Arquivo da aula</th>

              </tr>
            </thead>
            <tbody>

              <?php 


              for ($i=0; $i < count($res); $i++) { 
                foreach ($res[$i] as $key => $value) {
                }

                $nome = $res[$i]['nome'];
                $descricao = $res[$i]['descricao'];
                $arquivo = $res[$i]['arquivo'];
                $id_aula = $res[$i]['id'];
                $data = $res[$i]['data'];

                $dataF = implode('/', array_reverse(explode('-', $data)));


                ?>

                <tr>
                  <td><?php echo ($i+1) ?></td>
                  <td><?php echo $nome ?></td>
                  <td><?php echo $descricao ?></td>
                  <td><?php echo $dataF ?></td>
                  <td>
                    <?php if ($arquivo != ""): ?>


                      <span class="ml-1" ><a href="../img/arquivos-aula/<?php echo $arquivo ?>" target="_blank" class="text-primary"> Ver Arquivo </a></span>
                    <?php endif ?>
                  </td>  



                </tr>

              <?php } ?> 


            </tbody>
          </table>
        </small>

      <?php } ?>

    </div>


  </div>

</div>
</div>
</div>




<?php  

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "periodos") {
  echo "<script>$('#modal-periodos').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "frequencias") {
  echo "<script>$('#modal-aulas').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "aulas") {
  echo "<script>$('#modal-aulas-grade').modal('show');</script>";
}


?>



<!--AJAX PARA LISTAR OS DADOS -->
<script type="text/javascript">
  $(document).ready(function(){
   listarDados();
   
 })
</script>


<script type="text/javascript">
  function listarDados(){
    var pag = "<?=$pag?>";
    var turma = "<?=$_GET['id']?>";
    var periodo = "<?=$_GET['id_periodo']?>";
    var disciplina = "<?=$_GET['id_disciplina']?>";
    var aluno = "<?=$_GET['id_aluno']?>";
    var numerofase = "<?=$_GET['numero_fase']?>";

    

    $.ajax({
     url: pag + "/listar-aulas.php",
     method: "post",
     data: {turma, periodo, disciplina, aluno, numerofase},
     dataType: "html",
     success: function(result){
      $('#listar-aulas').html(result)

    },


  })
  }
</script>