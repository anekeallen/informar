<?php  
@session_start();
require_once("../conexao.php"); 
require_once('../vendor/autoload.php');

if(@isset($_SESSION['id_usuario'])){
    $query = $pdo->query("SELECT * FROM usuarios where id = '$_SESSION[id_usuario]'");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);

}

$nome_usu = @$res[0]['nome'];




$id_periodo = $_POST['ano_letivo'];

$mpdf = new \Mpdf\Mpdf([
	'mode' => 'utf-8', 
	'format' => 'A4-L',
	'margin_top' => 10,
	'margin_left' => 10,
	'margin_right' => 10,
	'margin_bottom' => 0,
	'margin_header' => 9,
	'margin_footer' => 5

]);




$html = '<htmlpageheader name="myHTMLHeader1">
<table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family: serif; font-size: 11pt; color: #000000;"><tr>
<td width="30%"><img src="../img/logo.png" width="180px"></td>
<td width="60%" align="center"><h2>'.strtoupper($nome_escola).'</h2>'.$endereco_escola.'<br>CEP.: '.$cep_escola.' || E-MAIL: '.$email_escola.' || FONE: '.$telefone_escola.'<br> CNPJ.: '.$cnpj_escola.'</td>
<td width="33%" style="text-align: right;"><span style="font-weight: bold;"></span></td>
</tr></table>
</htmlpageheader>
<sethtmlpageheader name="myHTMLHeader1" page="O" value="on" show-this-page="1" />';



$query_r = $pdo->query("SELECT * FROM tbturma where IdPeriodo = '$id_periodo' ");
$res = $query_r->fetchAll(PDO::FETCH_ASSOC);
for ($i=0; $i < count($res); $i++) { 
	foreach ($res[$i] as $key => $value) {
	}

	$id_turma = @$res[$i]['IdTurma'];
	$id_serie = @$res[$i]['IdSerie'];
	$nome_turma = @$res[$i]['NomeTurma'];
	$sigla_turma = @$res[$i]['SiglaTurma'];
	$turno = @$res[$i]['TurnoPrincipal'];
	$dataInicial = @$res[$i]['DataInicial'];
	$dataFinal = @$res[$i]['DataFinal'];

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

	$query_ano = $pdo->query("SELECT * FROM tbperiodo where IdPeriodo = '$id_periodo' ");
	$res_ano = $query_ano->fetchAll(PDO::FETCH_ASSOC);

	$sigla_periodo = @$res_ano[0]['SiglaPeriodo'];


	$html .= '<div style="margin-top: 70px; position: absolute; width: 1045px; text-align: center;"><h5>LIVRO DE MATRÍCULA</h5></div>';

	$html .= '<div style="position: absolute; width: 1045px; margin-top: 110px;">
	<table id="t02" style=" border-collapse: collapse; font-family: arial, sans-serif; width: 100%;">
	<tr>
	<th style="font-size: 9pt; text-align: left; border-bottom: 1px solid black; border-top: 1px solid black;" colspan="7">'.$nome_curso.' / '.$nome_serie.' / '.$sigla_periodo.' / '.$nome_turma.'</th>
	
	</tr>
	
	<tr >
	<th style="">Nº</th>
	<th style="">Aluno</th>
	<th style="">Filiação</th>
	<th style="">Data de nascimento</th>
	<th style="">Naturalidade</th>
	<th style="">Data de matrícula</th>
	<th style="">Endereço</th>
	</tr>';

	$query_orc = $pdo->query("SELECT * FROM tbalunoturma where IdTurma = '$id_turma' ");
	$res_orc = $query_orc->fetchAll(PDO::FETCH_ASSOC);
	$quantidade_alunos = 0;
	for ($j=0; $j < count($res_orc); $j++) { 
		foreach ($res_orc[$j] as $key => $value) {
		}
		$quantidade_alunos = count($res_orc);
		$id_aluno = @$res_orc[$j]['IdAluno'];
		$data_matricula = @$res_orc[$j]['DataSituacaoAtivo'];
		$data_matriculaF = implode('/', array_reverse(explode('-', $data_matricula)));

		$query = $pdo->query("SELECT * FROM tbaluno where IdAluno = '$id_aluno' ");
		$res111 = $query->fetchAll(PDO::FETCH_ASSOC);

		$nome2 = @$res111[0]['NomeAluno'];
		$data2 = @$res111[0]['DataNascimento'];
		$data_nascimento = implode('/', array_reverse(explode('-', $data2)));


		$sexo2 = @$res111[0]['Sexo'];
		$mae2 = @$res111[0]['NomeMae'];
		$pai2 = @$res111[0]['NomePai'];
		$email2 = @$res111[0]['Email'];
		$telefone2 = $res111[0]['Celular'];
		$cpf2 = @$res111[0]['CPF'];
		$rg2 = @$res111[0]['RG'];
		$registro2 = @$res111[0]['RegistroNascimentoNumero'];
		$cartorio2 = @$res111[0]['RegistroNascimentoCartorio'];
		$livro2 = @$res111[0]['RegistroNascimentoLivro'];
		$folha2 = @$res111[0]['RegistroNascimentoFolha'];
		$dataRegistro2 = @$res111[0]['RegistroNascimentoData'];
		$foto2 = @$res[0]['foto'];
		$naturalidade2 = @$res111[0]['NaturalidadeCidade'];
		$nacionalidade2 = @$res111[0]['Nacionalidade'];
		$naturalidadeUF2 = @$res111[0]['NaturalidadeUF'];
		$id_responsavel2 = @$res111[0]['IdResponsavel'];

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



		$html .= '<tr>
		<td style="  text-align:center;">'.($j+1).'</td>
		<td style=" ">'.$nome2.'</td>
		<td style=" ">'.$nome_responsavel.'</td>
		<td class="td-center">'.$data_nascimento.'</td>


		<td style="">'; 

		if(!isset($naturalidade2)){
			$naturalidade2 = "(Não informado)" ;
		}
		if(!isset($naturalidadeUF2)){
			$naturalidadeUF2 = "(Não informado)" ;
		}
		
		
		$html .=''.$naturalidade2.' / '.$naturalidadeUF2.'</td>
		


		<td class="td-center">'.$data_matriculaF.'</td>';

		if (!isset($logradouro)) {
			$logradouro = "(Não informado)";
		}
		if (!isset($bairro)) {
			$bairro = "(Não informado)";
		}
		if (!isset($cep)) {
			$cep = "(Não informado)";
		}



		$html .='
		<td style=" width=20%;">'.$logradouro.' / '.$bairro.' / '.$cep.'</td>
		</tr>


		';



	}

	$html .= '<tr style=" background-color: white;"><td style="border-top: 1px solid black;" colspan="7">Quantidades de alunos na turma: '.$quantidade_alunos.'</td></tr>';

	$html .= '</table>
	<span style="font-size: 9pt;">E, para constar, eu, '.$nome_usu.', Secretário(a), lavrei o presente livro que vai assinado por mim e pelo(a) Diretor(a) da Escola.</span>
	<br><br><br>
	<div style="font-size: 9pt;" align="center">
			______________________________________________________
			<br>
			(DIREÇÃO/SECRETARIA)
		</div>
	</div>';


	if (($i + 1) != count($res)) {
		$html .= '<pagebreak />';
	}
		
	

}








$mpdf->SetHTMLFooter('

	<table class="table-footer" width="100%" style="border-top: 1px solid #000000;">

	<tr>

	<td width="33%" style="text-align: right;"><span style="font-size:9pt;">{DATE j/m/Y H:i} - Página {PAGENO}</span></td>


	</tr>
	</table>
	');


$stylesheet = file_get_contents('style.css');


$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($html,\Mpdf\HTMLParserMode::HTML_BODY);

$mpdf->Output("livro_de_matriculas_".$sigla_periodo.".pdf", "I");




?>