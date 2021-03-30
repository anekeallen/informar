<?php
@session_start();
$cpf_aluno = @$_SESSION['cpf_usuario'];
if(@$_SESSION['nivel_usuario'] == null || @$_SESSION['nivel_usuario'] != 'aluno'){
	echo "<script language='javascript'> window.location='../index.php' </script>";
	exit();
}

require_once("../conexao.php"); 

$query = $pdo->query("SELECT * FROM tbaluno where RegistroNascimentoNumero = '$cpf_aluno' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_aluno = $res[0]['IdAluno'];


//totais dos cards
$hoje = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$dataInicioMes = $ano_atual."-".$mes_atual."-01";

$discConcluidas = 0;
$discPendentes = 0;
$query = $pdo->query("SELECT * FROM matriculas where aluno = '$id_aluno' order by id desc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$totalDisc = @count($res);

for ($i=0; $i < count($res); $i++) { 
	foreach ($res[$i] as $key => $value) {
	}

	$id_turma = $res[$i]['turma'];
	$id_mat = $res[$i]['id'];


	$query2 = $pdo->query("SELECT * FROM turmas where id = '$id_turma'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	$data_final = $res2[0]['data_final'];

	if($data_final < date('Y-m-d')){
		$discConcluidas += 1;
	}else{
		$discPendentes += 1;
	}
	

}


$query = $pdo->query("SELECT * FROM chamadas where aluno = '$id_aluno' and data >= '$dataInicioMes' and data <= curDate()");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$aulasMes = @count($res);

?>








<div class="row">
	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-info shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Cursos Matriculados</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalDisc ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-users fa-2x text-info"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Earnings (Monthly) Card Example -->
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-success shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Disciplinas Concluídas</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$discConcluidas ?> </div>
						</div>
						<div class="col-auto">
							<i class="fas fa-users fa-2x text-success"></i>
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
							<div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Disciplinas Pendentes</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$discPendentes ?> </div>
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
			<div class="card border-left-secondary shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Aulas no Mês</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$aulasMes ?></div>
						</div>
						<div class="col-auto">
							<i class="fas fa-clipboard-list fa-2x text-secondary"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

</div>





<div class="row">

	<?php 

	$query = $pdo->query("SELECT * FROM tbaluno where RegistroNascimentoNumero = '$cpf_aluno' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$id_aluno = $res[0]['IdAluno'];





	$query = $pdo->query("SELECT * FROM tbalunoturma where IdAluno = '$id_aluno' order by IdTurma desc ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	

	for ($i=0; $i < count($res); $i++) { 
		foreach ($res[$i] as $key => $value) {
		}

		$id_turma = $res[$i]['IdTurma'];
		$id_mat = $res[$i]['IdAlunoTurma'];


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
			<a class="text-dark" href="index.php?pag=disciplinas&id=<?php echo $id_turma ?>&id_periodo=<?php echo $id_periodo ?>" title="Informações da Turma">
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