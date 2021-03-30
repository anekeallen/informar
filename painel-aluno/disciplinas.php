<?php  
@session_start();
$pag = "disciplinas";

require_once("../conexao.php"); 

$id_turma = $_GET['id'];



$query_2 = $pdo->query("SELECT * FROM tbturma where IdTurma = '$id_turma' ");
$res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
$id_serie = $res_2[0]['IdSerie'];
$id_periodo = $res_2[0]['IdPeriodo'];
$nome_turma = $res_2[0]['NomeTurma'];
$sigla = $res_2[0]['SiglaTurma'];
$totalvagas = $res_2[0]['TotalVagas'];
$id_sala = $res_2[0]['IdSala'];
$data_final = $res_2[0]['DataFinal'];
$data_inicio = $res_2[0]['DataInicial'];
$turno = $res_2[0]['TurnoPrincipal'];


//RECUPERAR O TOTAL DE MESES ENTRE DATAS
//$d1 = new DateTime($data_inicio);
//$d2 = new DateTime($data_final);
//$intervalo = $d1->diff( $d2 );
//$anos = $intervalo->y;
//$meses = $intervalo->m + ($anos * 12);

$data_finalF = implode('/', array_reverse(explode('-', $data_final)));
$data_inicioF = implode('/', array_reverse(explode('-', $data_inicio)));

$query_resp = $pdo->query("SELECT * FROM tbserie where IdSerie = '$id_serie' ");
$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);                    
$nome_disc = $res_resp[0]['NomeSerie'];
$id_curso = $res_resp[0]['IdCurso'];
//$id_periodo = $res_resp[0]['IdPeriodo'];

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
$nome_prof = $res_resp[0]['nome'];
$email_prof = $res_resp[0]['email'];
$imagem_prof = $res_resp[0]['foto'];


$id_periodo = @$_GET['id_periodo'];

$query_resp = $pdo->query("SELECT * FROM aulas where turma = '$id_turma' and periodo = '$id_get_periodo'");
$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);                 
$total_aulas = @count($res_resp);


if($data_final < date('Y-m-d')){
	$concluido = 'Sim';
}else{
	$concluido = 'Não';
}


?>

<h6><b><?php echo strtoupper($nome_curso) ?> / <?php echo strtoupper($nome_disc) ?> <?php echo $nome_turma ?> </h6></b>
<hr>

<small>
	<div class="mb-3">
		
		<span class="mr-3"><i><b>Turma Concluída </b> <?php echo $concluido ?></i></span>
		<span class="mr-3"><i><b>Dias de Aula </b> <?php echo $dia ?></i></span>
		<span class="mr-3"><i><b>Horário Aula: </b> <?php echo $turno ?></i></span>
		<span class="mr-3"><i><b>Data Início: </b> <?php echo $data_inicioF?></i></span>
		<span class="mr-3"><i><b>Data da Conclusão </b> <?php echo $data_finalF ?></i></span>
	</div>
</small>

<hr>
<h5 class="text-center"><b>Disciplinas</b></h5>

<hr>


<div class="row">

	<?php 


	$query = $pdo->query("SELECT * FROM tbgradecurricular where IdSerie = '$id_serie' and IdPeriodo = '$id_periodo'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);

	for ($i=0; $i < count($res); $i++) { 
		foreach ($res[$i] as $key => $value) {
		}

		$id_disciplina = $res[$i]['IdDisciplina'];

		$query_2 = $pdo->query("SELECT * FROM tbdisciplina where IdDisciplina = '$id_disciplina'");
		$res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);

		
		$nome_disciplina = $res_2[0]['NomeDisciplina'];
		

		//$data_finalF = implode('/', array_reverse(explode('-', $data_final)));

		//$query_resp = $pdo->query("SELECT * FROM tbserie where IdSerie = '$id_serie' ");
		//$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);

		//$serie = $res_resp[0]['NomeSerie'];

		//$query_ano = $pdo->query("SELECT * FROM tbperiodo where IdPeriodo = '$id_periodo' ");
		//$res_ano = $query_ano->fetchAll(PDO::FETCH_ASSOC);

		//$ano = $res_ano[0]['SiglaPeriodo'];


		//if($data_final < date('Y-m-d')){
		//	$classe_card = 'text-success';
		//}else{
		//	$classe_card = 'text-danger';
		//}

		?>	

		<div class="col-xl-3 col-md-6 mb-4">
			<a class="text-dark" href="index.php?pag=turma&id=<?php echo $id_turma ?>&id_periodo=<?php echo $id_periodo ?>&id_disciplina=<?php echo $id_disciplina ?>" title="Informações da Turma">
				<div class="card shadow h-100 py-2 text-primary">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								
								<div class="text-xs font-weight-bold  <?php echo $classe_card ?> text-uppercase"><?php echo $nome_disciplina ?></div>
								
							</div>
							<div class="col-auto" align="center">
								<i class="fas fa-book-open fa-2x"></i><br>
								
							</div>
						</div>
					</div>
				</div>
			</a>
		</div>



	<?php } ?>

</div>