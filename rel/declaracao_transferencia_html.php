<?php 
require_once("../conexao.php"); 
require_once('../vendor/autoload.php');
@session_start();

ob_start();


$id_aluno = $_GET['id_aluno'];
$id_turma = $_GET['id_turma'];

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$encoding = mb_internal_encoding(); // ou UTF-8, ISO-8859-1...

$data_hoje = mb_strtoupper(utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today'))),$encoding);


//DADOS DA MATRICULAS
//DADOS DA MATRICULAS
$query_orc = $pdo->query("SELECT * FROM tbalunoturma where IdAluno = '$id_aluno' and IdTurma = '$id_turma' ");
$res_orc = $query_orc->fetchAll(PDO::FETCH_ASSOC);

//$id_turma = @$res_orc[0]['IdTurma'];
//$id_aluno = @$res_orc[0]['IdAluno'];
$id_aluno_turma = @$res_orc[0]['IdAlunoTurma'];
$id_situacao = @$res_orc[0]['IdSituacaoAlunoTurma'];



//$data_F = implode('/', array_reverse(explode('-', $data)));



$query = $pdo->query("SELECT * FROM tbaluno where IdAluno = '$id_aluno' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$nome2 = @$res[0]['NomeAluno'];
$data2 = @$res[0]['DataNascimento'];
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


$query = $pdo->query("SELECT * FROM tbprofissao where IdProfissao = '" . $id_profissao_responsavel . "' ");
$res_prof = $query->fetchAll(PDO::FETCH_ASSOC);

$profissao = @$res_prof[0]['NomeProfissao'];

$query_r = $pdo->query("SELECT * FROM tbturma where IdTurma = '$id_turma' ");
$res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
$id_serie = @$res_r[0]['IdSerie'];
$id_periodo = @$res_r[0]['IdPeriodo'];
$nome_turma = @$res_r[0]['NomeTurma'];
$sigla_turma = @$res_r[0]['SiglaTurma'];
$turno = @$res_r[0]['TurnoPrincipal'];
$dataInicial = @$res_r[0]['DataInicial'];
$dataFinal = @$res_r[0]['DataFinal'];

$query_r4 = $pdo->query("SELECT * FROM tbperiodo where IdPeriodo = '".$id_periodo."' ");
$res_r4 = $query_r4->fetchAll(PDO::FETCH_ASSOC);

$periodo = $res_r4[0]['SiglaPeriodo'];




//RECUPERAR O TOTAL DE MESES ENTRE DATAS
$d1 = new DateTime($dataInicial);
$d2 = new DateTime($dataFinal);
$intervalo = $d1->diff( $d2 );
$anos = $intervalo->y;
$meses = $intervalo->m + ($anos * 12);



$data_inicioF = implode('/', array_reverse(explode('-', $dataInicial)));
$data_finalF = implode('/', array_reverse(explode('-', $dataFinal)));
//$valor_total = $valor * $meses;
//$valor_mensalidadeF = number_format($valor, 2, ',', '.');
//$valor_totalF = number_format($valor_total, 2, ',', '.');

$query_r2 = $pdo->query("SELECT * FROM tbserie where IdSerie = '".$id_serie."' ");
$res_r2 = $query_r2->fetchAll(PDO::FETCH_ASSOC);

$nome_serie = $res_r2[0]['NomeSerie'];
$id_curso = $res_r2[0]['IdCurso'];
$id_serie_prox = $res_r2[0]['IdProximaSerie'];

$query_r3 = $pdo->query("SELECT * FROM tbcurso where IdCurso = '".$id_curso."' ");
$res_r3 = $query_r3->fetchAll(PDO::FETCH_ASSOC);

$nome_curso = $res_r3[0]['NomeCurso'];
$matutino = $res_r3[0]['horarioManha'];
$vespertino = $res_r3[0]['horarioTarde'];

$query_r2 = $pdo->query("SELECT * FROM tbserie where IdSerie = '".$id_serie_prox."' ");
$res_r2 = $query_r2->fetchAll(PDO::FETCH_ASSOC);

$nome_serie_prox = $res_r2[0]['NomeSerie'];
$id_curso_prox = $res_r2[0]['IdCurso'];

$query_r3 = $pdo->query("SELECT * FROM tbcurso where IdCurso = '".$id_curso_prox."' ");
$res_r3 = $query_r3->fetchAll(PDO::FETCH_ASSOC);

$nome_curso_prox = $res_r3[0]['NomeCurso'];

//calcular o proximo ano
$periodo_int = intval($periodo);
$periodo_prox = $periodo_int + 1;






?>

<!DOCTYPE html>
<html>
<head>
	<title>Declaração de Transferência</title>
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
			margin-bottom:50px;
			width:100%;
			height:100px;
			
		}

		.titulo{
			margin:0;
			font-size:18px;
			font-family:Arial, Helvetica, sans-serif;
			color:#6e6d6d;

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

		 b{
			color: black;
			font-weight: bold;

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

		<p class="titulo" align="center"><b>DECLARAÇÃO DE TRANSFERÊNCIA</b></p>
		<br><br>

		<p>Declaramos, para os devidos fins, que o (a) aluno (a) <?php echo $nome2 ?>, filho (a) do Sr(a) <?php echo $nome_responsavel ?>, foi aprovado (a) no ano letivo de <?php echo $periodo ?>, com direito a ser matriculado (a) no (a) <?php echo $nome_serie_prox ?> do <?php echo $nome_curso_prox ?>, no ano letivo de <?php echo $periodo_prox ?>.</p>

		<p>Declaramos ainda que os documentos serão expedidos, por esta secretaria, no prazo fixado pela Resolução 36/74 do Conselho Estadual de Educação (Art. 5º;parágrafo 1º e 2º) dentro de 45 dias a partir desta data.</p><br>
		<p>Sem mais, </p>

		<br><br>
		<p align="center">
			<?php echo strtoupper($cidade_escola) .' '. $data_hoje ?>
		</p>

		<br><br>
		<p align="center">
			_________________________________________________________________
			<br>
			(DIREÇÃO/SECRETARIA)
		</p>

		<br><br><br>


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

$mpdf->Output("declaracao_transferencia_".$nome2.".pdf", "I");
exit;

 ?>
