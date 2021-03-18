<?php
@session_start();
$cpf_usuario = @$_SESSION['cpf_usuario'];
if(@$_SESSION['nivel_usuario'] == null || @$_SESSION['nivel_usuario'] != 'professor'){
	echo "<script language='javascript'> window.location='../index.php' </script>";
	exit();
}

require_once("../conexao.php"); 


//totais dos cards
$hoje = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$dataInicioMes = $ano_atual."-".$mes_atual."-01";

$query = $pdo->query("SELECT * FROM tbprofessor where cpf = '$cpf_usuario' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_prof = $res[0]['IdProfessor'];

// total de disciplinas ministradas pelo professor
$query = $pdo->query("SELECT Distinct IdDisciplina FROM tbprofessordisciplina where IdProfessor = '$id_prof'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$totalDisc = @count($res);

// total de turmas do professor
$totalAndamento = 0;
$totalConcluidas = 0;
$totalAlunos = 0;
$query = $pdo->query("SELECT Distinct IdTurma FROM tbturmaprofessor where IdProfessor = '$id_prof' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
for ($i=0; $i < count($res); $i++) { 
	foreach ($res[$i] as $key => $value) {
	}
	$id_turma = $res[$i]['IdTurma'];

	//total de turmas em andamento
	$query2 = $pdo->query("SELECT * FROM tbturma where IdTurma = '$id_turma' and datafinal >= curDate()");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

	if (count($res2) > 0) {
		$totalAndamento = $totalAndamento + 1;
		$id_turma_andamento = $id_turma;
	}

	//Total de turmas concluídas
	$query3 = $pdo->query("SELECT * FROM tbturma where IdTurma = '$id_turma' and (datafinal < curDate())");
	$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);

	if (count($res3) > 0) {
		$totalConcluidas = $totalConcluidas + 1;
	}

	if ($id_turma_andamento != 0) {
 		//Total de Alunos
		$query4 = $pdo->query("SELECT IdAluno FROM tbalunoturma where IdTurma = '$id_turma_andamento'");
		$res4 = $query4->fetchAll(PDO::FETCH_ASSOC);
		$totalAlunos = $totalAlunos + count($res4);
	}


	$id_turma_andamento = 0;

}




?>


<div class="row">
	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-info shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Disciplinas Ministradas</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalDisc ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-clipboard-list fa-2x text-info"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-secondary shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Total de Alunos</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalAlunos ?> </div>
					</div>
					<div class="col-auto">
						<i class="fas fa-users fa-2x text-secondary"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-danger shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Turmas em Andamentos</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalAndamento ?> </div>
					</div>
					<div class="col-auto" align="center">
						<i class="fas fa-clipboard-list fa-2x text-danger"></i>

					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Pending Requests Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-success shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Turmas Concluídas</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalConcluidas ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-clipboard-list fa-2x text-success"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>






<div class="row">

	<?php 

	$query = $pdo->query("SELECT * FROM tbprofessor where CPF = '$cpf_usuario' ");
	$res1 = $query->fetchAll(PDO::FETCH_ASSOC);
	$id_prof = $res1[0]['IdProfessor'];



	$query = $pdo->query("SELECT Distinct IdTurma FROM tbturmaprofessor where IdProfessor = '$id_prof' order by IdTurma asc ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);

	for ($i=0; $i < count($res); $i++) { 
		foreach ($res[$i] as $key => $value) {
		}

		$id_turma = $res[$i]['IdTurma'];

		$query_2 = $pdo->query("SELECT * FROM tbturma where IdTurma = '$id_turma'");
		$res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);

		$id_serie = $res_2[0]['IdSerie'];
		$id_periodo = $res_2[0]['IdPeriodo'];
		$nome_turma = $res_2[0]['NomeTurma'];
		$sigla = $res_2[0]['SiglaTurma'];
		$totalvagas = $res_2[0]['TotalVagas'];
		$id_sala = $res_2[0]['IdSala'];
		$data_final = $res_2[0]['DataFinal'];
		$turno = $res_2[0]['TurnoPrincipal'];

		$data_finalF = implode('/', array_reverse(explode('-', $data_final)));

		$query_resp = $pdo->query("SELECT * FROM tbserie where IdSerie = '$id_serie' ");
		$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);

		$serie = $res_resp[0]['NomeSerie'];

		$query_ano = $pdo->query("SELECT * FROM tbperiodo where IdPeriodo = '$id_periodo' ");
		$res_ano = $query_ano->fetchAll(PDO::FETCH_ASSOC);

		$ano = $res_ano[0]['SiglaPeriodo'];


		if($data_final < date('Y-m-d')){
			$classe_card = 'text-success';
		}else{
			$classe_card = 'text-danger';
		}

		?>	

		<div class="col-xl-3 col-md-6 mb-4">
			<a class="text-dark" href="index.php?pag=turma&id=<?php echo $id_turma ?>" title="Informações da Turma">
				<div class="card <?php echo $classe_card ?> shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold  <?php echo $classe_card ?> text-uppercase">Série: <?php echo $serie ?> <?php echo $nome_turma ?></div>
								<div class="text-xs font-weight-bold  <?php echo $classe_card ?> text-uppercase">Turma: <?php echo $sigla ?></div>
								<div class="text-xs text-secondary">Turno: <?php echo $turno ?> <br> Ano Letivo: <?php echo $ano ?> </div>
							</div>
							<div class="col-auto" align="center">
								<i class="far fa-calendar-alt fa-2x  <?php echo $classe_card ?>"></i><br>
								<span class="text-xs"><?php echo $data_finalF ?></span>
							</div>
						</div>
					</div>
				</div>
			</a>
		</div>



	<?php } ?>

</div>