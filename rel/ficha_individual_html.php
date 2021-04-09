<?php 

require_once("../conexao.php"); 
require_once('../vendor/autoload.php');

ob_start();



$id = $_GET['id'];


setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$encoding = mb_internal_encoding(); // ou UTF-8, ISO-8859-1...

$data_hoje = mb_strtoupper(utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today'))),$encoding);

$data_hoje2 = mb_strtoupper(utf8_encode(strftime('%F', strtotime('today'))),$encoding);
$data_hojeF = implode('/', array_reverse(explode('-', $data_hoje2)));

//DADOS DA MATRICULAS
$query_orc = $pdo->query("SELECT * FROM tbalunoturma where IdAlunoTurma = '$id' ");
$res_orc = $query_orc->fetchAll(PDO::FETCH_ASSOC);

$id_turma = @$res_orc[0]['IdTurma'];
$id_aluno = @$res_orc[0]['IdAluno'];
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
	<title>Ficha individual.pdf</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<style>

		@page {
			margin: 0px;

			
		}


		.footer {
			margin-top:20px;
			width:100%;
			background-color: #ebebeb;
			padding:10px;
		}

		.cabecalho {    
			
			padding-top: 50px;
			padding-left: 50px;
			margin-bottom:10px;
			width:100%;
			height:100px;
			
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
			border : 0.5px solid #bcbcbc;
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
			padding-left: 50px;
			padding-right: 50px;


		}

		.container p{ 
			padding-left: 30px;
			padding-right: 30px;
		}

		#hr{

			height:5px;


		}

		.esquerda-elemento{
			display:inline;
			width:70%;
			float:left;

		}

		.direita-elemento{
			display:inline;
			width:30%;
			float:right;
		}

		table, th, td {
			border: 0.1mm solid black;
			border-collapse: collapse;

		}
		table{
			table-layout: fixed;
			width: 100%
		}

		th, td {
			padding: 5px;
			white-space: -o-pre-wrap; 
			word-wrap: break-word;
			white-space: pre-wrap; 
			white-space: -moz-pre-wrap; 
			white-space: -pre-wrap; 
		}

		#t01 th {
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
			font-size: 12px;
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

	<div class="container">

		<p class="titulo02" align="center">FICHA INDIVIDUAL</p>
		<hr style="height: 0.5mm; color: black;">
		

		<div class="esquerda-elemento fonte12">
			Aluno: <?php echo $nome2 ?><br>
			Filiação: <br>
			Naturalidade: <?php echo $naturalidade2 ?> - <?php echo $naturalidadeUF2 ?><br>
		</div>
		<div class="direita-elemento fonte12" align="left">
			Matrícula Nº <?php echo $id ?> <br>
			Data de nascimento: <?php echo $data_nascimento ?> <br>
			Data de emissão: <?php echo $data_hojeF; ?>
		</div>

		<hr>

		<div class="esquerda-elemento negrito fonte12">
			<?php echo $nome_curso ?> / <?php echo $nome_serie ?> / <?php echo $sigla_periodo ?> / <?php echo $nome_turma ?>

		</div>
		<div class="direita-elemento negrito fonte12" align="right">
			Situação Final: <?php echo $situacao_turma ?>
		</div>
		<table id="t01" style="width:100%">
			<tr id="linha01">
				<th><small>Disciplina</small></th>


				<th class="fonte12"><small>1º TRIM</small></th>
				<th class="fonte12"><small>2º TRIM</small></th>
				<th class="fonte12"><small>3º TRIM</small></th>
				<th class="fonte12"><small>MP</small> </th>
				<th class="fonte12"><small>REC</small></th>
				<th class="fonte12"><small>MA</small></th>  
				<th class="fonte12"><small>REC_FIN</small></th>
				<th class="fonte12"><small>MF</small></th>
				<th class="fonte12"><small>CH</small></th>
				<th class="fonte12"><small>Situação</small></th>
			</tr>


			<?php  



			$query = $pdo->query("SELECT * FROM tbgradecurricular where IdSerie = '$id_serie' and IdPeriodo = '$id_periodo' order by IdDisciplina asc ");
			$res = $query->fetchAll(PDO::FETCH_ASSOC);

			for ($i=0; $i < count($res); $i++) { 
				foreach ($res[$i] as $key => $value) {
				}

				$id_disciplina = $res[$i]['IdDisciplina'];

				$query_r = $pdo->query("SELECT * FROM tbdisciplina where IdDisciplina = '$id_disciplina'");
				$res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);

				$nome_disciplina = $res_r[0]['NomeDisciplina'];

				$query_r1 = $pdo->query("SELECT * FROM tbsituacaoalunodisciplina where IdAluno = '$id_aluno' and IdTurma = '$id_turma' and IdDisciplina = '$id_disciplina'");
				$res_r1 = $query_r1->fetchAll(PDO::FETCH_ASSOC);

				$situacao = $res_r1[0]['SituacaoAtual'];
				$idfasenotaatual = $res_r1[0]['IdFaseNotaAtual'];



				$query11 = $pdo->query("SELECT * FROM tbfasenotaaluno where IdAluno = '$id_aluno' and IdTurma = '$id_turma' and IdDisciplina = '$id_disciplina' order by IdFaseNota asc");
				$res11 = $query11->fetchAll(PDO::FETCH_ASSOC);

				if (count($res11) == 6) {
					$nota_trim1 = @$res11[0]['NotaFase'];
					$idfasenota1 = @$res11[0]['IdFaseNota'];

					$nota_trim2 = @$res11[1]['NotaFase'];
					$idfasenota2 = @$res11[1]['IdFaseNota'];

					$nota_trim3 = @$res11[2]['NotaFase'];
					$idfasenota3 = @$res11[2]['IdFaseNota'];

					$media_parcial = @$res11[3]['NotaFase'];
					$media_anual = @$res11[4]['NotaFase'];
					$media_final = @$res11[5]['NotaFase'];


				}elseif(count($res11) == 8){

					$nota_trim1 = @$res11[0]['NotaFase'];
					$idfasenota1 = @$res11[0]['IdFaseNota'];

					$nota_trim2 = @$res11[1]['NotaFase'];
					$idfasenota2 = @$res11[1]['IdFaseNota'];

					$nota_trim3 = @$res11[2]['NotaFase'];
					$idfasenota3 = @$res11[2]['IdFaseNota'];

					$media_parcial = @$res11[3]['NotaFase'];
					$recuperacao = @$res11[4]['NotaFase'];
					$media_anual = @$res11[5]['NotaFase'];
					$recuperacao_final = @$res11[6]['NotaFase'];
					$media_final = @$res11[7]['NotaFase'];


				}elseif(count($res11) == 0){

					$nota_trim1 = null;
					$idfasenota1 = null;

					$nota_trim2 = null;
					$idfasenota2 = null;

					$nota_trim3 = null;
					$idfasenota3 = null;

					$media_parcial = null;
					$recuperacao = null;
					$media_anual = null;
					$recuperacao_final = null;
					$media_final = null;

				}

				

				//Contador de aulas para cada trimestre

				$query_aulas1 = $pdo->query("SELECT * FROM aulas where turma = '$id_turma' and periodo = '$id_periodo' and id_disciplina = '$id_disciplina' and (NumeroFase = 1) order by id asc ");
				$res_aulas1 = $query_aulas1->fetchAll(PDO::FETCH_ASSOC);
				$total_aulas_1trim = @count($res_aulas1);
				$total_faltas1 = 0;
				for ($i1=0; $i1 < count($res_aulas1); $i1++) { 
					foreach ($res_aulas1[$i1] as $key => $value) {
					}
					$id_aula1 = @$res_aulas1[$i1]['id'];


					$query2 = $pdo->query("SELECT * FROM chamadas where turma = '$id_turma' and aluno = '$id_aluno' and aula = '$id_aula1' and NumeroFase = 1");
					$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

					$presenca = @$res2[0]['presenca'];

					if($presenca == 'F'){
						$total_faltas1 = $total_faltas1 + 1;
					}
				}


				$query_aulas2 = $pdo->query("SELECT * FROM aulas where turma = '$id_turma' and periodo = '$id_periodo' and id_disciplina = '$id_disciplina' and (NumeroFase = 2) order by id asc ");
				$res_aulas2 = $query_aulas2->fetchAll(PDO::FETCH_ASSOC);

				$total_aulas_2trim = @count($res_aulas2);
				$total_faltas2 = 0;
				for ($i2=0; $i2 < count($res_aulas2); $i2++) { 
					foreach ($res_aulas2[$i2] as $key => $value) {
					}
					$id_aula2 = @$res_aulas2[$i2]['id'];


					$query2 = $pdo->query("SELECT * FROM chamadas where turma = '$id_turma' and aluno = '$id_aluno' and aula = '$id_aula2' and NumeroFase = 2");
					$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

					$presenca2 = @$res2[0]['presenca'];

					if($presenca2 == 'F'){
						$total_faltas2 = $total_faltas2 + 1;
					}
				}


				$query_aulas3 = $pdo->query("SELECT * FROM aulas where turma = '$id_turma' and periodo = '$id_periodo' and id_disciplina = '$id_disciplina' and (NumeroFase = 3) order by id asc ");
				$res_aulas3 = $query_aulas3->fetchAll(PDO::FETCH_ASSOC);

				$total_aulas_3trim = @count($res_aulas3);

				$total_faltas3 = 0;
				for ($i3=0; $i3 < count($res_aulas3); $i3++) { 
					foreach ($res_aulas3[$i3] as $key => $value) {
					}
					$id_aula3 = @$res_aulas3[$i3]['id'];


					$query3 = $pdo->query("SELECT * FROM chamadas where turma = '$id_turma' and aluno = '$id_aluno' and aula = '$id_aula3' and NumeroFase = 3");
					$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);

					$presenca3 = @$res3[0]['presenca'];

					if($presenca3 == 'F'){
						$total_faltas3 = $total_faltas3 + 1;
					}
				}


				$total_aulas_disciplina = @$total_aulas_1trim + @$total_aulas_2trim + @$total_aulas_3trim;

				$total_faltas_disciplina = @$total_faltas1 + @$total_faltas2 + @$total_faltas3;



				if (isset($nota_trim1)) {
					$nota_trim1F = number_format($nota_trim1, 1, '.', '.');

				}else{
					$nota_trim1F = null;
				}

				if (isset($nota_trim2)) {
					$nota_trim2F = number_format($nota_trim2, 1, '.', '.');

				} else{
					$nota_trim2F = null;
				}

				if (isset($nota_trim3)) {
					$nota_trim3F = number_format($nota_trim3, 1, '.', '.');

				} else{
					$nota_trim3F = null;
				}

				if (isset($media_parcial)) {
					$media_parcialF = number_format($media_parcial, 1, '.', '.');
				}else{
					$media_parcialF = null;
				}
				if (isset($recuperacao)) {
					$recuperacaoF = number_format($recuperacao, 1, '.', '.');

				} else{
					$recuperacaoF = null;
				}

				if (isset($media_anual)) {
					$media_anualF = number_format($media_anual, 1, '.', '.');

				} else{
					$media_anualF = null;
				}

				if (isset($recuperacao_final)) {
					$recuperacao_finalF = number_format($recuperacao_final, 1, '.', '.');

				} else{
					$recuperacao_finalF = null;
				}
				if (isset($media_final)) {
					$media_finalF = number_format($media_final, 1, '.', '.');

				} else{
					$media_finalF = null;
				}


				
				?>


				<tr>
					<td width="150px" class="td_fonte" id="td01"><?php echo $nome_disciplina ?></td>
					<td class="td_fonte td_align-direita"><?php echo $nota_trim1F ?><br>
						
						<?php if (isset($total_aulas_1trim) and $total_aulas_1trim != 0): ?>
							<i><?php echo $total_aulas_1trim ?>ad</i> 
						<?php endif ?>

						

						<?php if (isset($total_faltas1) and $total_faltas1 !=0): ?>
							<i><?php echo $total_faltas1 ?>f</i>
						<?php endif ?>
						
					</td>
					<td class="td_fonte td_align-direita"><?php echo $nota_trim2F ?><br>
						<?php if (isset($total_aulas_2trim) and $total_aulas_2trim != 0): ?>
							<i><?php echo $total_aulas_2trim ?>ad</i> 
						<?php endif ?>
						<?php if (isset($total_faltas2) and $total_faltas2 !=0): ?>
							<i><?php echo $total_faltas2 ?>f</i>
						<?php endif ?>

					</td>
					<td class="td_fonte td_align-direita"><?php echo $nota_trim3F ?><br>

						<?php if (isset($total_aulas_3trim) and $total_aulas_3trim != 0): ?>
							<i><?php echo $total_aulas_3trim ?>ad</i> 
						<?php endif ?>
						<?php if (isset($total_faltas3) and $total_faltas3 !=0): ?>
							<i><?php echo $total_faltas3 ?>f</i>
						<?php endif ?>
					</td>
					<td class="td_fonte td_align-direita"><?php echo $media_parcialF ?></td>
					<td class="td_fonte td_align-direita"><?php echo $recuperacaoF ?></td>
					<td class="td_fonte td_align-direita"><?php echo $media_anualF ?></td>
					<td class="td_fonte td_align-direita"><?php echo $recuperacao_finalF ?></td>
					<td class="td_fonte td_align-direita"><?php echo $media_finalF ?><br>
						<?php if (isset($total_aulas_disciplina) and $total_aulas_disciplina != 0): ?>
							<i><?php echo $total_aulas_disciplina ?>ad</i> 
						<?php endif ?> 
						<?php if (isset($total_faltas_disciplina) and $total_faltas_disciplina !=0): ?>
							<i><?php echo $total_faltas_disciplina ?>f</i>
						<?php endif ?>
					</td>
					<td class="td_fonte td_align-centro">Jill</td>
					<td width="100px" class="td_fonte td_align-centro"><?php echo $situacao ?></td>

				</tr>


			<?php } ?>

		</table>

		<div  style="border: 0.4mm solid black; margin-top: 5px; text-align: center; font-size: 12px">Carga horária total: <?php echo $cargahoraria_anual ?> - Total de faltas: <?php echo $total_faltas_turma?> - Frequência: <?php echo $totalPorcentagemSomaF ?>%</div>

		<span class="td_fonte ">(ad): aulas dadas; (f): faltas</span>




	</div>



</body>
</html>

<?php  

$html = ob_get_contents();
ob_end_clean();


$mpdf = new \Mpdf\Mpdf();
	//$stylesheet = file_get_contents('../vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css');

	//$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);



$mpdf->WriteHTML($html);

$mpdf->Output("fichaindividual_".$nome2.".pdf", "I");
exit;


?>


