<?php 
require_once("../conexao.php"); 
@session_start();

$id = $_GET['id'];

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_hoje = strtoupper(utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today'))));


//DADOS DA MATRICULAS
$query_orc = $pdo->query("SELECT * FROM matriculas where id = '$id' ");
$res_orc = $query_orc->fetchAll(PDO::FETCH_ASSOC);

$turma = $res_orc[0]['turma'];
$aluno = $res_orc[0]['aluno'];
$data = $res_orc[0]['data'];


$data_F = implode('/', array_reverse(explode('-', $data)));



$query = $pdo->query("SELECT * FROM tbaluno where IdAluno = '$aluno' ");
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
$telefone_responsavel = $res_r[0]['Celular'];
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
$uf_endereco = $res_end[0]['UF'];
$cep = @$res_end[0]['CEP'];
$telefone_res = @@$res_end[0]['Fone'];


$query = $pdo->query("SELECT * FROM tbprofissao where IdProfissao = '" . $id_profissao_responsavel . "' ");
$res_prof = $query->fetchAll(PDO::FETCH_ASSOC);

$profissao = @$res_prof[0]['NomeProfissao'];

$query_r = $pdo->query("SELECT * FROM turmas where id = '$turma' ");
$res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
$disciplina = $res_r[0]['disciplina'];
$data_inicio = $res_r[0]['data_inicio'];
$data_final = $res_r[0]['data_final'];
$valor = $res_r[0]['valor_mensalidade'];



//RECUPERAR O TOTAL DE MESES ENTRE DATAS
$d1 = new DateTime($data_inicio);
$d2 = new DateTime($data_final);
$intervalo = $d1->diff( $d2 );
$anos = $intervalo->y;
$meses = $intervalo->m + ($anos * 12);



$data_inicioF = implode('/', array_reverse(explode('-', $data_inicio)));
$data_finalF = implode('/', array_reverse(explode('-', $data_final)));
$valor_total = $valor * $meses;
$valor_mensalidadeF = number_format($valor, 2, ',', '.');
$valor_totalF = number_format($valor_total, 2, ',', '.');

$query_r = $pdo->query("SELECT * FROM disciplinas where id = '$disciplina' ");
$res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
$nome_disciplina = $res_r[0]['nome'];


?>

<!DOCTYPE html>
<html>
<head>
	<title>Declaração de Matrícula</title>
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
			background-color: #ebebeb;
			padding:100px;
			margin-bottom:30px;
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
			width:50%;
			float:left;
		}

		.direita{
			display:inline;
			width:50%;
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


	</style>

</head>
<body>


	<div class="cabecalho">
		
		<div class="row titulos">
			<div class="col-sm-2 esquerda_float image">	
				<img src="../img/logo.png" width="180px">
			</div>
			<div class="col-sm-10 esquerda_float">	
				<h2 class="titulo"><b><?php echo strtoupper($nome_escola) ?></b></h2>
				<h6 class="subtitulo"><?php echo $endereco_escola . ' Tel: '.$telefone_escola  ?></h6>

			</div>
		</div>
		

	</div>

	<div class="container">

		<div class="row">
			<div class="col-sm-8 esquerda">	
				<big> Matrícula Nº <?php echo $id ?>  </big>
			</div>
			<div class="col-sm-4 direita" align="right">	
				<big> <small> Data: <?php echo $data_hoje; ?></small> </big>
			</div>
		</div>


		<hr>

		<br><br>
		<p class="titulo" align="center"><b>DECLARAÇÃO DE MATRÍCULA</b></p>
		<br><br>

		<p>Declaro para todos os fins que o aluno <b><?php echo $nome2 ?></b> com número de registro <b><?php echo $registro2 ?></b> está devidamente matriculado em nossa escola cursando o curso de <b><?php echo $nome_disciplina ?></b> no período de <?php echo $data_inicioF ?> à <?php echo $data_finalF ?></p>

		<p>Declaro ainda que o referido aluno frequenta normalmente as aulas até a presente data.</p>

		<br><br>
		<p align="center">
			<?php echo strtoupper($cidade_escola) .' '. $data_hoje ?>
		</p>

		<br><br>
		<p align="center">
			_________________________________________________________________
			<br>
			(Assinatura do Responsável)
		</p>

		<br><br><br>


	</div>


	<div class="footer">
		<p style="font-size:14px" align="center"><?php echo $rodape_relatorios ?></p> 
	</div>




</body>
</html>
