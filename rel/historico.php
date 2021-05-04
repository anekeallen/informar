<?php 

require_once("../conexao.php"); 
require_once('../vendor/autoload.php');

ob_start();




$id_aluno = $_GET['id_aluno'];
$id_turma = $_GET['id_turma'];


setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$encoding = mb_internal_encoding(); // ou UTF-8, ISO-8859-1...

$data_hoje = mb_strtoupper(utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today'))),$encoding);

$data_hoje2 = mb_strtoupper(utf8_encode(strftime('%F', strtotime('today'))),$encoding);
$data_hojeF = implode('/', array_reverse(explode('-', $data_hoje2)));

//DADOS DA MATRICULAS
$query_orc = $pdo->query("SELECT * FROM tbalunoturma where IdAluno = '$id_aluno' and IdTurma = '$id_turma' ");
$res_orc = $query_orc->fetchAll(PDO::FETCH_ASSOC);

//$id_turma = @$res_orc[0]['IdTurma'];
//$id_aluno = @$res_orc[0]['IdAluno'];
$id_aluno_turma = @$res_orc[0]['IdAlunoTurma'];
$id_situacao = @$res_orc[0]['IdSituacaoAlunoTurma'];

$query_sit = $pdo->query("SELECT * FROM tbsituacaoalunoturma where IdSituacaoAlunoTurma = '$id_situacao' ");
$res_sit = $query_sit->fetchAll(PDO::FETCH_ASSOC);

$situacao_turma = @$res_sit[0]['SituacaoAlunoTurma'];


$query = $pdo->query("SELECT * FROM tbaluno where IdAluno = '$id_aluno' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$nome2 = @$res[0]['NomeAluno'];
$data2 = @$res[0]['DataNascimento'];
$data_nascimento = implode('/', array_reverse(explode('-', $data2)));


$sexo2 = @$res[0]['Sexo'];
$mae2 = @$res[0]['NomeMae'];
$pai2 = @$res[0]['NomePai'];
$email2 = @$res[0]['Email'];
$telefone2 = $res[0]['Celular'];
$cpf2 = @$res[0]['CPF'];
$rg2 = @$res[0]['RG'];
$registro2 = @$res[0]['RegistroNascimentoNumero'];
$cartorio2 = @$res[0]['RegistroNascimentoCartorio'];
$livro2 = @$res[0]['RegistroNascimentoLivro'];
$folha2 = @$res[0]['RegistroNascimentoFolha'];
$dataRegistro2 = @$res[0]['RegistroNascimentoData'];
$foto2 = @$res[0]['foto'];
$naturalidade2 = @$res[0]['NaturalidadeCidade'];
$nacionalidade2 = @$res[0]['Nacionalidade'];
$naturalidadeUF2 = @$res[0]['NaturalidadeUF'];
$id_responsavel2 = @$res[0]['IdResponsavel'];

$query_r = $pdo->query("SELECT * FROM tbresponsavel where IdResponsavel = '$id_responsavel2' ");
$res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);

$nome_responsavel = @$res_r[0]['NomeResponsavel'];
$data_responsavel = @$res_r[0]['DataNascimento'];
$sexo_responsavel = @$res_r[0]['Sexo'];
$id_profissao_responsavel = @$res_r[0]['IdProfissao'];
$id_endereco_responsavel  = @$res_r[0]['IdEndereco'];
$telefone_trabalho_responsavel = @$res_r[0]['FoneTrabalho'];
$local_trabalho = @$res_r[0]['LocalTrabalho'];@
$email_responsavel = @$res_r[0]['Email'];
$telefone_responsavel = @$res_r[0]['Celular'];
$cpf_responsavel = @$res_r[0]['CPFCNPJ'];
$rg_responsavel = @$res_r[0]['RG'];
$naturalidade_responsavel = @$res_r[0]['NaturalidadeCidade'];
$nacionalidade_responsavel = @$res_r[0]['Nacionalidade'];
$naturalidadeUF_responsavel = @$res_r[0]['NaturalidadeUF'];
$id_responsavel_responsavel = @$res_r[0]['IdResponsavel'];

$query = $pdo->query("SELECT * FROM tbendereco where IdEndereco = '" . $id_endereco_responsavel . "' ");
$res_end = $query->fetchAll(PDO::FETCH_ASSOC);

$logradouro = @$res_end[0]['Logradouro'];
$complemento = @$res_end[0]['Complemento'];
$bairro = @$res_end[0]['Bairro'];
$cidade = @$res_end[0]['Cidade'];
$uf_endereco = @$res_end[0]['UF'];
$cep = @$res_end[0]['CEP'];
$telefone_res = @$res_end[0]['Fone'];

$query_r = $pdo->query("SELECT * FROM tbturma where IdTurma = '$id_turma' ");
$res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
$id_serie = @$res_r[0]['IdSerie'];
$id_periodo = @$res_r[0]['IdPeriodo'];
$nome_turma = @$res_r[0]['NomeTurma'];
$sigla_turma = @$res_r[0]['SiglaTurma'];
$turno = @$res_r[0]['TurnoPrincipal'];
$dataInicial = @$res_r[0]['DataInicial'];
$dataFinal = @$res_r[0]['DataFinal'];

$query_ano = $pdo->query("SELECT * FROM tbperiodo where IdPeriodo = '$id_periodo' ");
$res_ano = $query_ano->fetchAll(PDO::FETCH_ASSOC);

$sigla_periodo = @$res_ano[0]['SiglaPeriodo'];
$ano_conclusao = @$res_ano[0]['AnoConclusao'];


//RECUPERAR O TOTAL DE MESES ENTRE DATAS
$d1 = new DateTime($dataInicial);
$d2 = new DateTime($dataFinal);
$intervalo = $d1->diff( $d2 );
$anos = $intervalo->y;
$meses = $intervalo->m + ($anos * 12);



$data_inicioF = implode('/', array_reverse(explode('-', $dataInicial)));
$data_finalF = implode('/', array_reverse(explode('-', $dataFinal)));

$query_r2 = $pdo->query("SELECT * FROM tbserie where IdSerie = '".$id_serie."' ");
$res_r2 = $query_r2->fetchAll(PDO::FETCH_ASSOC);

$nome_serie = $res_r2[0]['NomeSerie'];
$id_curso = $res_r2[0]['IdCurso'];

$query_r3 = $pdo->query("SELECT * FROM tbcurso where IdCurso = '".$id_curso."' ");
$res_r3 = $query_r3->fetchAll(PDO::FETCH_ASSOC);

$nome_curso = $res_r3[0]['NomeCurso'];
$matutino = $res_r3[0]['horarioManha'];
$vespertino = $res_r3[0]['horarioTarde'];
$cargahoraria_anual = $res_r3[0]['CargaHorariaAnual'];

//RECUPERAR A % DE FREQUENCIA DO ALUNO
$contador = 0;
$query = $pdo->query("SELECT * FROM aulas where turma = '$id_turma' and periodo = '$id_periodo' order by id asc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_aulas2 = @count($res);
$totalPorcentagemSoma = 0;
$totalPorcentagemSomaF = 0;

$total_faltas_turma = 0;
for ($i=0; $i < count($res); $i++) { 
	foreach ($res[$i] as $key => $value) {
	}

	if($total_aulas2 > 0){
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
			}else if($presenca == 'F'){
				$total_faltas_turma = $total_faltas_turma + 1;

			}

			$porcentagem2 = ($total_presencas2 * 100) / $total_aulas2;

		}


		$totalPorcentagem = $totalPorcentagem + $porcentagem2;
		$totalPorcentagemSoma = $totalPorcentagem + $totalPorcentagemSoma;

	}
}

//$totalPorcentagemSoma = $totalPorcentagemSoma / $contador . ' ' ;
$totalPorcentagemSomaF = number_format($totalPorcentagemSoma, 2, ',', '.');


?>

<!DOCTYPE html>
<html>
<head>
	<title>Historico escolar</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<style>

		

		* {
			box-sizing: border-box;
		}


		.footer {
			margin-top:20px;
			width:100%;
			background-color: #ebebeb;
			padding:10px;
		}

		.cabecalho {    
			
			padding-top: 0px;
			padding-left: 20px;
			
			width:100%;
			height:80px;
			
		}

		.titulo{
			margin:0;
			font-size:18px;
			font-family:Arial, Helvetica, sans-serif;
			font-weight: bold;

		}

		.titulo02{
			margin:0;
			font-size:15px;
			font-family:Arial, Helvetica, sans-serif;
			font-weight: bold;

		}

		.subtitulo{
			margin:0;
			font-size:15px;
			font-family:Arial, Helvetica, sans-serif;
		}

		.areaTotais{
			border : 0.5px solid black;
			padding: 15px;
			border-radius: 5px;
			margin-right:25px;
			margin-left:25px;
			position:absolute;
			right:20;
		}

		.areaTotal{
			border : 0.5px solid #bcbcbc;
			padding: 15px;
			border-radius: 5px;
			margin-right:25px;
			margin-left:25px;
			background-color: #f9f9f9;
			margin-top:2px;
		}

		.pgto{
			margin:1px;
		}

		.fonte13{
			font-size:13px;
		}

		.esquerda{
			display:inline;
			width:20%;
			float:left;

		}

		.direita{
			display:inline;
			width:80%;
			float:right;
		}

		.table{
			padding:15px;
			font-family:Verdana, sans-serif;
			margin-top:20px;
		}

		.texto-tabela{
			font-size:12px;
		}


		.esquerda_float{

			margin-bottom:10px;
			float:left;
			display:inline;
		}
		.direita_float{

			margin-bottom:10px;
			float:right;
			display:inline;
		}


		.titulos{
			margin-top:10px;
		}

		.image{
			margin-top:-10px;
		}

		.margem-direita{
			margin-right: 80px;
		}

		hr{
			margin:8px;
			padding:1px;
		}
		.container{
			padding-left: 0px;
			padding-right: 0px;
			font-size: 13px;
			width: 100%;
			


		}

		.container p{ 
			padding-left: 30px;
			padding-right: 30px;
		}

		#hr{

			height:5px;


		}

		

		#t01 table, th, td {
			border: 0.1mm solid black;
			border-collapse: collapse;

		}
		table{
			table-layout: fixed;
			width: 100%
		}

		th, td {
			padding: 5px;
			white-space: nowrap; 
			font-size: 10px;

			/*word-wrap: break-word; */
			
			
		}

		#t02 td{
			text-align: center;
		}

		#t01 th {
			background-color: #eee;
			text-align: center;

		}

		#t02 th {
			background-color: #eee;
			text-align: center;

		}

		#td01 {
			background-color: #eee;
			

		}

		.td_fonte {
			font-size: 10px;

		}

		.td_align-direita {
			text-align: right;

			
		}
		.td_align-centro {
			text-align: center;
			
		}

		#linha01 th{
			font-weight:normal; 
		}

		.negrito{
			font-weight:bold; 
		}

		.fonte12 {
			font-size: 10px;
		}


		.table-footer tr {
			border: none;
			border-collapse: collapse;

		}

		.table-footer th {
			border: none;
			border-collapse: collapse;

		}
		.dados1{
			
			float: left;
			width: 58%;
			font-size: 11px;
			

			

		}

		.dados2{
			
			float: left;
			width: 40%;	
			font-size: 11px;
			margin-left: 2%;
		}

		.dados3{
			
			float: left;
			width: 15%;	
			font-size: 11px;

			
			


		}
		.dados4{
			
			float: left;
			width: 15%;	
			font-size: 11px;
			margin-left: 2%;
			


		}
		.dados5{
			
			float: left;
			width: 68%;	
			font-size: 11px;
			margin-left: 2%;
			


		}

		.bg-secondary{
			box-sizing: border-box;
			background-color: #EEE;
			margin-bottom: 10px;


		}

		.margin-top{
			margin-top: 5px;
		}
		.bg-escuro{
			background-color: #DDD;
		}

		.tdpro{

			text-align: center;

			
			
		}
		
		



	</style>

</head>
<body>


	<div class="cabecalho">
		
		<div class=" titulos">
			<div class=" esquerda image">	
				<img src="../img/logo.png" width="180px">
			</div>
			<div class=" direita">	
				<h3 class="titulo"><b><?php echo strtoupper($nome_escola) ?></b></h3>
				<h6 class="subtitulo"><?php echo $endereco_escola ?></h6>
				<h6 class="subtitulo">CEP.: <?php echo $cep_escola ?> || E-MAIL: <?php echo $email_escola ?> || FONE: <?php echo $telefone_escola ?></h6>
				<h6 class="subtitulo">CNPJ.: <?php echo $cnpj_escola ?> </h6>

			</div>
		</div>
		

	</div>





	<p class="titulo02" align="center">HISTÓRICO ESCOLAR - ENSINO FUNDAMENTAL</p>
	<hr style="height: 0.5mm; color: black;">


	<div class="dados1">Aluno</div>
	<div class="dados2">Naturalidade / Nacionalidade</div>
	<div class="dados1 bg-secondary"><?php echo $nome2 ?></div>
	<div class="dados2 bg-secondary"><?php echo $naturalidade2 ?>-<?php echo $naturalidadeUF2 ?> / <?php echo $nacionalidade2 ?></div>


	<div class="dados3 " > Matrícula</div>
	<div class="dados4 "> Data de nascimento</div>
	<div class="dados5 "> Filiação</div>
	<div class="dados3 bg-secondary"> <?php echo $id_aluno_turma ?></div>
	<div  class="dados4 bg-secondary"> <?php echo $data_nascimento ?></div>
	<div  class="dados5 bg-secondary"> <?php echo $pai2 ?> e <?php echo $mae2 ?></div>

	<table id="t01" style="width:100%">



		<tr id="linha01">
			<th><small>Disciplina</small></th>


			<th class="fonte12"><small>1º Ano <br> Nota</small></th>
			<th class="fonte12"><small>2º Ano <br> Nota</small></th>
			<th class="fonte12"><small>3º Ano <br> Nota</small></th>
			<th class="fonte12"><small>4º Ano <br> Nota</small></th>
			<th class="fonte12"><small>5º Ano <br> Nota</small></th>
			<th class="fonte12"><small>6º Ano <br> Nota</small></th>
			<th class="fonte12"><small>7º Ano <br> Nota</small></th>
			<th class="fonte12"><small>8º Ano <br> Nota</small></th>
			<th class="fonte12"><small>9º Ano <br> Nota</small></th>
			
		</tr>
		<!--
		<tr id="basecomum">
			<td class="fonte12" colspan="10">Base Nacional Comum</td>
		</tr> -->

		<?php  


		$query = $pdo->query("SELECT distinct IdDisciplina FROM tbhistoriconotas where IdAluno = '$id_aluno' order by IdDisciplina");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$faltas_total1 = 0;
		$frequencia1 = 0;
		
		$faltas_total2 = 0;
		$frequencia2 = 0;
		
		$faltas_total3 = 0;
		$frequencia3 = 0;
		
		$faltas_total4 = 0;
		$frequencia4 = 0;
		
		$faltas_total5 = 0;
		$frequencia5 = 0;
		
		$faltas_total6 = 0;
		$frequencia6 = 0;
		
		$faltas_total7 = 0;
		$frequencia7 = 0;
		
		$faltas_total8 = 0;
		$frequencia8 = 0;

		$faltas_total9 = 0;
		$frequencia9 = 0;

		
		for ($i=0; $i < count($res); $i++) { 
			
			

			foreach ($res[$i] as $key => $value) {
			}
			$id_disciplina = $res[$i]['IdDisciplina'];
			

			$query_r = $pdo->query("SELECT * FROM tbdisciplina where IdDisciplina = '$id_disciplina'");
			$res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);

			$nome_disciplina = $res_r[0]['NomeDisciplina'];


			?>

			<tr>
				<td>
					<?php echo $nome_disciplina ?>
				</td>

				<?php 
				$query = $pdo->query("SELECT * FROM tbhistoriconotas where IdAluno = '$id_aluno' and
					IdDisciplina = '$id_disciplina' and CodigoSerie = 'n11'");
				$res1 = $query->fetchAll(PDO::FETCH_ASSOC);

				if (!empty($res1)) {
					$contador1 = 1;
					# code...
				}
				$notafinal1 = @$res1[0]['NotaFinal'];

				
				
				$faltasAnual1 = @$res1[0]['QuantidadeFaltasAnual'];
				
				$faltas_total1 = $faltas_total1 + $faltasAnual1;

				?>

				<td class="tdpro">
					<?php if (isset($notafinal1)): 
						
						?>
						<?php echo $notafinal1 ?>

						<?php else: ?>
							---

						<?php endif ?>


					</td>

					<?php 
				$query = $pdo->query("SELECT * FROM tbhistoriconotas where IdAluno = '$id_aluno' and
					IdDisciplina = '$id_disciplina' and CodigoSerie = 'n12'");
				$res2 = $query->fetchAll(PDO::FETCH_ASSOC);
				if (!empty($res2)) {
					$contador2 = 1;
					# code...
				}

				$notafinal2 = @$res2[0]['NotaFinal'];

				
				
				$faltasAnual2 = @$res2[0]['QuantidadeFaltasAnual'];

				$faltas_total2 = $faltas_total2 + @$faltasAnual2;

				

				?>

				<td class="tdpro">
					<?php if (isset($notafinal2)): 
							
						?>
						<?php echo $notafinal2 ?>
						
						<?php else: ?>
							---
							
						<?php endif ?>
						
						
					</td>
						<?php 
				$query = $pdo->query("SELECT * FROM tbhistoriconotas where IdAluno = '$id_aluno' and
					IdDisciplina = '$id_disciplina' and CodigoSerie = 'n13'");
				$res3 = $query->fetchAll(PDO::FETCH_ASSOC);
				if (!empty($res3)) {
					$contador3 = 1;
					# code...
				}

				$notafinal3 = @$res3[0]['NotaFinal'];
				
				
				$faltasAnual3 = @$res3[0]['QuantidadeFaltasAnual'];

				$faltas_total3 = $faltas_total3 + @$faltasAnual3;

				

				?>

				<td class="tdpro">
					<?php if (isset($notafinal3)): 
							
						?>
						<?php echo $notafinal3 ?>
						
						<?php else: ?>
							---
							
						<?php endif ?>
						
						
					</td>
						<?php 
				$query = $pdo->query("SELECT * FROM tbhistoriconotas where IdAluno = '$id_aluno' and
					IdDisciplina = '$id_disciplina' and CodigoSerie = 'n14'");
				$res4 = $query->fetchAll(PDO::FETCH_ASSOC);
				if (!empty($res4)) {
					$contador4 = 1;
					# code...
				}

				$notafinal4 = @$res4[0]['NotaFinal'];
				
				
				$faltasAnual4 = @$res4[0]['QuantidadeFaltasAnual'];

				$faltas_total4 = $faltas_total4 + @$faltasAnual4;

				
				?>

				<td class="tdpro">
					<?php if (isset($notafinal4)): 
						

						?>
						<?php echo $notafinal4 ?>
						
						<?php else: ?>
							---
							
						<?php endif ?>
						
						
					</td>
						<?php 
				$query = $pdo->query("SELECT * FROM tbhistoriconotas where IdAluno = '$id_aluno' and
					IdDisciplina = '$id_disciplina' and CodigoSerie = 'n15'");
				$res5 = $query->fetchAll(PDO::FETCH_ASSOC);
				if (!empty($res5)) {
					$contador5 = 1;
					# code...
				}

				$notafinal5 = @$res5[0]['NotaFinal'];
				
				
				$faltasAnual5 = @$res5[0]['QuantidadeFaltasAnual'];

				$faltas_total5 = $faltas_total5 + @$faltasAnual5;

				

				?>

				<td class="tdpro">
					<?php if (isset($notafinal5)): 
							
						?>
						<?php echo $notafinal5 ?>
						
						<?php else: ?>
							---
							
						<?php endif ?>
						
						
					</td>
						<?php 
				$query = $pdo->query("SELECT * FROM tbhistoriconotas where IdAluno = '$id_aluno' and
					IdDisciplina = '$id_disciplina' and CodigoSerie = 'n16'");
				$res6 = $query->fetchAll(PDO::FETCH_ASSOC);
				if (!empty($res6)) {
					$contador6 = 1;
					# code...
				}

				$notafinal6 = @$res6[0]['NotaFinal'];

				
				
				$faltasAnual6 = @$res6[0]['QuantidadeFaltasAnual'];

				$faltas_total6 = $faltas_total6 + @$faltasAnual6;

				

				?>

				<td class="tdpro">
					<?php if (isset($notafinal6)): 
						
						
						?>
						<?php echo $notafinal6 ?>
						
						<?php else: ?>
							---
							
						<?php endif ?>
						
						
					</td>
						<?php 
				$query = $pdo->query("SELECT * FROM tbhistoriconotas where IdAluno = '$id_aluno' and
					IdDisciplina = '$id_disciplina' and CodigoSerie = 'n17'");
				$res7 = $query->fetchAll(PDO::FETCH_ASSOC);
				if (!empty($res7)) {
					$contador7 = 1;
					# code...
				}

				$notafinal7 = @$res7[0]['NotaFinal'];
				
				
				$faltasAnual7 = @$res7[0]['QuantidadeFaltasAnual'];

				$faltas_total7 = $faltas_total7 + @$faltasAnual7;

				

				?>

				<td class="tdpro">
					<?php if (isset($notafinal7)): 
						
						?>
						<?php echo $notafinal7 ?>
						
						<?php else: ?>
							---
							
						<?php endif ?>
						
						
					</td>

						<?php 
				$query = $pdo->query("SELECT * FROM tbhistoriconotas where IdAluno = '$id_aluno' and
					IdDisciplina = '$id_disciplina' and CodigoSerie = 'n18'");
				$res8 = $query->fetchAll(PDO::FETCH_ASSOC);
				if (!empty($res8)) {
					$contador8 = 1;
					# code...
				}

				$notafinal8 = @$res8[0]['NotaFinal'];
				
				
				$faltasAnual8 = @$res8[0]['QuantidadeFaltasAnual'];

				$faltas_total8 = $faltas_total8 + @$faltasAnual8;

				

				?>

				<td class="tdpro">
					<?php if (isset($notafinal8)): 
						
						?>
						<?php echo $notafinal8 ?>
						
						<?php else: ?>
							---
							
						<?php endif ?>
						
						
					</td>
						<?php 
				$query = $pdo->query("SELECT * FROM tbhistoriconotas where IdAluno = '$id_aluno' and
					IdDisciplina = '$id_disciplina' and CodigoSerie = 'n19'");
				$res9 = $query->fetchAll(PDO::FETCH_ASSOC);
				if (!empty($res9)) {
					$contador9 = 1;
					# code...
				}

				$notafinal9 = @$res9[0]['NotaFinal'];
				
				
				$faltasAnual9 = @$res9[0]['QuantidadeFaltasAnual'];

				$faltas_total9 = $faltas_total9 + @$faltasAnual9;

				

				?>

				<td class="tdpro">
					<?php if (isset($notafinal9)): 
						

						?>

						<?php echo $notafinal9 ?>
						
						<?php else: ?>
							---
							
						<?php endif ?>
						
						
					</td>





				</tr>
				<?php } ?>


			

		<tr class="bg-escuro">
			<td>Carga horária total</td>
			
			
			<?php if (!empty($contador1)): ?>
				<td class="tdpro"><?php echo $carga_horaria_F1 ?></td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>
			<?php if (!empty($contador2)): ?>
				<td class="tdpro"><?php echo $carga_horaria_F1 ?></td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>

			<?php if (!empty($contador3)): ?>
				<td class="tdpro"><?php echo $carga_horaria_F1 ?></td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>
			<?php if (!empty($contador4)): ?>
				<td class="tdpro"><?php echo $carga_horaria_F1 ?></td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>



			<?php if (!empty($contador5)): ?>
				<td class="tdpro"><?php echo $carga_horaria_F1 ?></td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>
			<?php if (!empty($contador6)): ?>
				<td class="tdpro"><?php echo $carga_horaria_F2 ?></td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>
			<?php if (!empty($contador7)): ?>
				<td class="tdpro"><?php echo $carga_horaria_F2 ?></td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>
			<?php if (!empty($contador8)): ?>
				<td class="tdpro"><?php echo $carga_horaria_F2 ?></td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>
			<?php if (!empty($contador9)): ?>
				<td class="tdpro"><?php echo $carga_horaria_F2 ?></td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>
			
			

		</tr>

		<?php  
			$frequencia1 = (100 - (($faltas_total1*100) / $carga_horaria_F1));
			$frequencia2 = (100 - (($faltas_total2*100) / $carga_horaria_F1));
			$frequencia3 = (100 - (($faltas_total3*100) / $carga_horaria_F1));
			$frequencia4 = (100 - (($faltas_total4*100) / $carga_horaria_F1));
			$frequencia5 = (100 - (($faltas_total5*100) / $carga_horaria_F1));
			$frequencia6 = (100 - (($faltas_total6*100) / $carga_horaria_F2));
			$frequencia7 = (100 - (($faltas_total7*100) / $carga_horaria_F2));
			$frequencia8 = (100 - (($faltas_total8*100) / $carga_horaria_F2));
			$frequencia9 = (100 - (($faltas_total9*100) / $carga_horaria_F2));

			if(@is_real($frequencia1)){
				$frequencia1F = number_format($frequencia1, 1, ',', '.');

			}else{
				$frequencia1F = $frequencia1;
			}
			if(@is_real($frequencia2)){
				$frequencia2F = number_format($frequencia2, 1, ',', '.');

			}else{
				$frequencia2F = $frequencia2;
			}
			if(@is_real($frequencia3)){
				$frequencia3F = number_format($frequencia3, 1, ',', '.');

			}else{
				$frequencia3F = $frequencia3;
			}
			if(@is_real($frequencia4)){
				$frequencia4F = number_format($frequencia4, 1, ',', '.');

			}else{
				$frequencia4F = $frequencia4;
			}
			if(@is_real($frequencia5)){
				$frequencia5F = number_format($frequencia5, 1, ',', '.');

			}else{
				$frequencia5F = $frequencia5;
			}
			if(@is_real($frequencia6)){
				$frequencia6F = number_format($frequencia6, 1, ',', '.');

			}else{
				$frequencia6F = $frequencia6;
			}
			if(@is_real($frequencia7)){
				$frequencia7F = number_format($frequencia7, 1, ',', '.');

			}else{
				$frequencia7F = $frequencia7;
			}
			if(@is_real($frequencia8)){
				$frequencia8F = number_format($frequencia8, 1, ',', '.');

			}else{
				$frequencia8F = $frequencia8;
			}
			if(@is_real($frequencia9)){
				$frequencia9F = number_format($frequencia9, 1, ',', '.');

			}else{
				$frequencia9F = $frequencia9;
			}

			
			
			
			

		?>

		<tr class="bg-escuro">
			<td>Frequência total</td>

			<?php if (!empty($contador1)): ?>
				<td class="tdpro"><?php echo $frequencia1F ?>%</td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>
			<?php if (!empty($contador2)): ?>
				<td class="tdpro"><?php echo $frequencia2F ?>%</td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>
			<?php if (!empty($contador3)): ?>
				<td class="tdpro"><?php echo $frequencia3F ?>%</td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>
			<?php if (!empty($contador4)): ?>
				<td class="tdpro"><?php echo $frequencia4F ?>%</td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>
			<?php if (!empty($contador5)): ?>
				<td class="tdpro"><?php echo $frequencia5F ?>%</td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>
			<?php if (!empty($contador6)): ?>
				<td class="tdpro"><?php echo $frequencia6F ?>%</td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>
			<?php if (!empty($contador7)): ?>
				<td class="tdpro"><?php echo $frequencia7F ?>%</td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>
			<?php if (!empty($contador8)): ?>
				<td class="tdpro"><?php echo $frequencia8F ?>%</td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>
			<?php if (!empty($contador9)): ?>
				<td class="tdpro"><?php echo $frequencia9F ?>%</td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>
			
			
			
		</tr>
	<tr class="bg-escuro">
			<td>Dias letivos</td>

			<?php if (!empty($contador1)): ?>
				<td class="tdpro"><?php echo $dias_letivos ?></td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>
			<?php if (!empty($contador2)): ?>
				<td class="tdpro"><?php echo $dias_letivos ?></td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>
			<?php if (!empty($contador3)): ?>
				<td class="tdpro"><?php echo $dias_letivos ?></td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>
			<?php if (!empty($contador4)): ?>
				<td class="tdpro"><?php echo $dias_letivos ?></td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>
			<?php if (!empty($contador5)): ?>
				<td class="tdpro"><?php echo $dias_letivos ?></td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>
			<?php if (!empty($contador6)): ?>
				<td class="tdpro"><?php echo $dias_letivos ?></td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>
			<?php if (!empty($contador7)): ?>
				<td class="tdpro"><?php echo $dias_letivos ?></td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>
			<?php if (!empty($contador8)): ?>
				<td class="tdpro"><?php echo $dias_letivos ?></td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>
			<?php if (!empty($contador9)): ?>
				<td class="tdpro"><?php echo $dias_letivos ?></td>
			<?php else: ?>
				<td class="tdpro">---</td>
			<?php endif ?>
			
		</tr>


		</table>
<br>
		<table id="t02">
			
			<tr class="bg-escuro" ><th colspan="5">Estabelecimento de ensino</th></tr>
			<tr>
			
			<th class="fonte12 bg"><small>Série</small></th>
			<th class="fonte12"><small>Ano</small></th>
			<th class="fonte12"><small>Nome do estabelecimento</small></th>
			<th class="fonte12"><small>Cidade / Estado (País)</small></th>
			<th class="fonte12"><small>Situação</small></th>
			
			</tr>

			<tr><td>1º Ano</td>


			<?php  
			$query = $pdo->query("SELECT * FROM tbhistorico where IdAluno = '$id_aluno' and CodigoSerie = 'n11'");
			$res1 = $query->fetchAll(PDO::FETCH_ASSOC);
			if (empty($res1)) {
				$ano_conclusao_serie = "---";
				$resultado_final_serie = "---";
				$escola = "---";
				$cidade_estado = "---";
			}else{
				$ano_conclusao_serie = $res1[0]['AnoConclusao'];
				$resultado_final_serie = $res1[0]['ResultadoFinal'];
				$escola = $nome_escola;
				$cidade_estado = $cidade_escola . " (Brasil)";
				if ($resultado_final_serie == 'A') {
					$resultado_final_serie = 'Aprovado';
					
				}elseif ($resultado_final_serie == 'R') {
					$resultado_final_serie = 'Reprovado';
					
				}

			}



			?>

			<td><?php echo $ano_conclusao_serie ?></td>
			<td><?php echo $escola ?></td>
			<td><?php echo $cidade_estado ?></td>
			<td><?php echo $resultado_final_serie ?></td>
			

		</tr>

		<tr><td>2º Ano</td>


			<?php  
			$query = $pdo->query("SELECT * FROM tbhistorico where IdAluno = '$id_aluno' and CodigoSerie = 'n12'");
			$res1 = $query->fetchAll(PDO::FETCH_ASSOC);
			if (empty($res1)) {
				$ano_conclusao_serie = "---";
				$resultado_final_serie = "---";
				$escola = "---";
				$cidade_estado = "---";
			}else{
				$ano_conclusao_serie = $res1[0]['AnoConclusao'];
				$resultado_final_serie = $res1[0]['ResultadoFinal'];
				$escola = $nome_escola;
				$cidade_estado = $cidade_escola . " (Brasil)";
				if ($resultado_final_serie == 'A') {
					$resultado_final_serie = 'Aprovado';
					
				}elseif ($resultado_final_serie == 'R') {
					$resultado_final_serie = 'Reprovado';
					
				}

			}



			?>

			<td><?php echo $ano_conclusao_serie ?></td>
			<td><?php echo $escola ?></td>
			<td><?php echo $cidade_estado ?></td>
			<td><?php echo $resultado_final_serie ?></td>
			

		</tr>

		<tr><td>3º Ano</td>


			<?php  
			$query = $pdo->query("SELECT * FROM tbhistorico where IdAluno = '$id_aluno' and CodigoSerie = 'n13'");
			$res1 = $query->fetchAll(PDO::FETCH_ASSOC);
			if (empty($res1)) {
				$ano_conclusao_serie = "---";
				$resultado_final_serie = "---";
				$escola = "---";
				$cidade_estado = "---";
			}else{
				$ano_conclusao_serie = $res1[0]['AnoConclusao'];
				$resultado_final_serie = $res1[0]['ResultadoFinal'];
				$escola = $nome_escola;
				$cidade_estado = $cidade_escola . " (Brasil)";
				if ($resultado_final_serie == 'A') {
					$resultado_final_serie = 'Aprovado';
					
				}elseif ($resultado_final_serie == 'R') {
					$resultado_final_serie = 'Reprovado';
					
				}

			}



			?>

			<td><?php echo $ano_conclusao_serie ?></td>
			<td><?php echo $escola ?></td>
			<td><?php echo $cidade_estado ?></td>
			<td><?php echo $resultado_final_serie ?></td>
			

		</tr>
		<tr><td>4º Ano</td>


			<?php  
			$query = $pdo->query("SELECT * FROM tbhistorico where IdAluno = '$id_aluno' and CodigoSerie = 'n14'");
			$res1 = $query->fetchAll(PDO::FETCH_ASSOC);
			if (empty($res1)) {
				$ano_conclusao_serie = "---";
				$resultado_final_serie = "---";
				$escola = "---";
				$cidade_estado = "---";
			}else{
				$ano_conclusao_serie = $res1[0]['AnoConclusao'];
				$resultado_final_serie = $res1[0]['ResultadoFinal'];
				$escola = $nome_escola;
				$cidade_estado = $cidade_escola . " (Brasil)";
				if ($resultado_final_serie == 'A') {
					$resultado_final_serie = 'Aprovado';
					
				}elseif ($resultado_final_serie == 'R') {
					$resultado_final_serie = 'Reprovado';
					
				}

			}



			?>

			<td><?php echo $ano_conclusao_serie ?></td>
			<td><?php echo $escola ?></td>
			<td><?php echo $cidade_estado ?></td>
			<td><?php echo $resultado_final_serie ?></td>
			

		</tr>
		<tr><td>5º Ano</td>


			<?php  
			$query = $pdo->query("SELECT * FROM tbhistorico where IdAluno = '$id_aluno' and CodigoSerie = 'n15'");
			$res1 = $query->fetchAll(PDO::FETCH_ASSOC);
			if (empty($res1)) {
				$ano_conclusao_serie = "---";
				$resultado_final_serie = "---";
				$escola = "---";
				$cidade_estado = "---";
			}else{
				$ano_conclusao_serie = $res1[0]['AnoConclusao'];
				$resultado_final_serie = $res1[0]['ResultadoFinal'];
				$escola = $nome_escola;
				$cidade_estado = $cidade_escola . " (Brasil)";
				if ($resultado_final_serie == 'A') {
					$resultado_final_serie = 'Aprovado';
					
				}elseif ($resultado_final_serie == 'R') {
					$resultado_final_serie = 'Reprovado';
					
				}

			}



			?>

			<td><?php echo $ano_conclusao_serie ?></td>
			<td><?php echo $escola ?></td>
			<td><?php echo $cidade_estado ?></td>
			<td><?php echo $resultado_final_serie ?></td>
			

		</tr>
		<tr><td>6º Ano</td>


			<?php  
			$query = $pdo->query("SELECT * FROM tbhistorico where IdAluno = '$id_aluno' and CodigoSerie = 'n16'");
			$res1 = $query->fetchAll(PDO::FETCH_ASSOC);
			if (empty($res1)) {
				$ano_conclusao_serie = "---";
				$resultado_final_serie = "---";
				$escola = "---";
				$cidade_estado = "---";
			}else{
				$ano_conclusao_serie = $res1[0]['AnoConclusao'];
				$resultado_final_serie = $res1[0]['ResultadoFinal'];
				$escola = $nome_escola;
				$cidade_estado = $cidade_escola . " (Brasil)";
				if ($resultado_final_serie == 'A') {
					$resultado_final_serie = 'Aprovado';
					
				}elseif ($resultado_final_serie == 'R') {
					$resultado_final_serie = 'Reprovado';
					
				}

			}



			?>

			<td><?php echo $ano_conclusao_serie ?></td>
			<td><?php echo $escola ?></td>
			<td><?php echo $cidade_estado ?></td>
			<td><?php echo $resultado_final_serie ?></td>
			

		</tr>
		<tr><td>7º Ano</td>


			<?php  
			$query = $pdo->query("SELECT * FROM tbhistorico where IdAluno = '$id_aluno' and CodigoSerie = 'n17'");
			$res1 = $query->fetchAll(PDO::FETCH_ASSOC);
			if (empty($res1)) {
				$ano_conclusao_serie = "---";
				$resultado_final_serie = "---";
				$escola = "---";
				$cidade_estado = "---";
			}else{
				$ano_conclusao_serie = $res1[0]['AnoConclusao'];
				$resultado_final_serie = $res1[0]['ResultadoFinal'];
				$escola = $nome_escola;
				$cidade_estado = $cidade_escola . " (Brasil)";
				if ($resultado_final_serie == 'A') {
					$resultado_final_serie = 'Aprovado';
					
				}elseif ($resultado_final_serie == 'R') {
					$resultado_final_serie = 'Reprovado';
					
				}

			}



			?>

			<td><?php echo $ano_conclusao_serie ?></td>
			<td><?php echo $escola ?></td>
			<td><?php echo $cidade_estado ?></td>
			<td><?php echo $resultado_final_serie ?></td>
			

		</tr>
		<tr><td>8º Ano</td>


			<?php  
			$query = $pdo->query("SELECT * FROM tbhistorico where IdAluno = '$id_aluno' and CodigoSerie = 'n18'");
			$res1 = $query->fetchAll(PDO::FETCH_ASSOC);
			if (empty($res1)) {
				$ano_conclusao_serie = "---";
				$resultado_final_serie = "---";
				$escola = "---";
				$cidade_estado = "---";
			}else{
				$ano_conclusao_serie = $res1[0]['AnoConclusao'];
				$resultado_final_serie = $res1[0]['ResultadoFinal'];
				$escola = $nome_escola;
				$cidade_estado = $cidade_escola . " (Brasil)";
				if ($resultado_final_serie == 'A') {
					$resultado_final_serie = 'Aprovado';
					
				}elseif ($resultado_final_serie == 'R') {
					$resultado_final_serie = 'Reprovado';
					
				}

			}



			?>

			<td><?php echo $ano_conclusao_serie ?></td>
			<td><?php echo $escola ?></td>
			<td><?php echo $cidade_estado ?></td>
			<td><?php echo $resultado_final_serie ?></td>
			

		</tr>

		<tr><td>9º Ano</td>


			<?php  
			$query = $pdo->query("SELECT * FROM tbhistorico where IdAluno = '$id_aluno' and CodigoSerie = 'n19'");
			$res1 = $query->fetchAll(PDO::FETCH_ASSOC);
			if (empty($res1)) {
				$ano_conclusao_serie = "---";
				$resultado_final_serie = "---";
				$escola = "---";
				$cidade_estado = "---";
			}else{
				$ano_conclusao_serie = $res1[0]['AnoConclusao'];
				$resultado_final_serie = $res1[0]['ResultadoFinal'];
				$escola = $nome_escola;
				$cidade_estado = $cidade_escola . " (Brasil)";
				if ($resultado_final_serie == 'A') {
					$resultado_final_serie = 'Aprovado';
					
				}elseif ($resultado_final_serie == 'R') {
					$resultado_final_serie = 'Reprovado';
					
				}

			}



			?>

			<td><?php echo $ano_conclusao_serie ?></td>
			<td><?php echo $escola ?></td>
			<td><?php echo $cidade_estado ?></td>
			<td><?php echo $resultado_final_serie ?></td>
			

		</tr>



		</table>

		<div style="text-align: center; margin-top: 20px; font-size: 10px;"><?php echo $data_hoje ?></div>







		<br><br><br><br><br>




		<p align="center" style="font-size: 10px;">
			______________________________________________________
			<br>
			(DIREÇÃO/SECRETARIA)
		</p>





	</body>
	</html>

	<?php  

	$html = ob_get_contents();
	ob_end_clean();

	try {
		$mpdf = new \Mpdf\Mpdf([
			'margin_top' => 10,
			'margin_left' => 10,
			'margin_right' => 10,
			'margin_bottom' => 0,
			'margin_header' => 9,
			'margin_footer' => 5

		]);
		$mpdf->SetHTMLFooter('
			<hr>
			<table class="table-footer" width="100%">

			<tr>

			<td class="fonte12" width="33%" style="text-align: right;">{DATE j/m/Y H:i:s}</td>


			</tr>
			</table>
			');






		$mpdf->WriteHTML($html);

		$mpdf->Output("historico_".$nome2.".pdf", "I");
		exit;

	} catch (\Mpdf\MpdfException $e) {

		echo $e->getMessage();

	}




	?>


