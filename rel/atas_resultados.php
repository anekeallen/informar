<?php  
@session_start();
require_once("../conexao.php"); 
require_once('../vendor/autoload.php');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Fortaleza');

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

$mpdf->SetTitle('Atas de Resultados');



$dia_hoje = strftime("%e");
$mes_hoje = strftime("%B");
$ano_hoje = strftime("%Y");



$html = '<htmlpageheader name="myHTMLHeader1">
<table width="100%" style=" vertical-align: bottom; font-family: serif; font-size: 11pt; color: #000000;"><tr>
<td width="30%"><img src="../img/logo.png" width="180px"></td>
<td width="60%" align="center"><h2>'.strtoupper($nome_escola).'</h2>'.$endereco_escola.'<br>CEP.: '.$cep_escola.' || E-MAIL: '.$email_escola.' || FONE: '.$telefone_escola.'<br> CNPJ.: '.$cnpj_escola.'</td>
<td width="33%" style="text-align: right;"><span style="font-weight: bold;"></span></td>
</tr></table>
</htmlpageheader>
<sethtmlpageheader name="myHTMLHeader1" page="O" value="on" show-this-page="1" />';



$query_r = $pdo->query("SELECT * FROM tbturma where (IdPeriodo = '$id_periodo') and ((IdSerie BETWEEN 4 and 10) or (IdSerie BETWEEN 18 and 19)) order by IdSerie ");
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
	$codigo_serie = $res_r2[0]['CodigoSerie'];

	$query_r3 = $pdo->query("SELECT * FROM tbcurso where IdCurso = '".$id_curso."' ");
	$res_r3 = $query_r3->fetchAll(PDO::FETCH_ASSOC);

	$nome_curso = $res_r3[0]['NomeCurso'];
	$matutino = $res_r3[0]['horarioManha'];
	$vespertino = $res_r3[0]['horarioTarde'];
	$cargahoraria_anual = $res_r3[0]['CargaHorariaAnual'];

	$query_ano = $pdo->query("SELECT * FROM tbperiodo where IdPeriodo = '$id_periodo' ");
	$res_ano = $query_ano->fetchAll(PDO::FETCH_ASSOC);

	$sigla_periodo = @$res_ano[0]['SiglaPeriodo'];


	$html .= '<div style="margin-top: 70px; border-bottom: 1px solid black; position: absolute; width: 1045px; text-align: center;"><h5>ATA DE RESULTADOS FINAIS - '.$sigla_periodo.'</h5></div>';

	$html .= '<div style="position: absolute; width: 1045px; margin-top: 110px;">';
	$html .= 'Ao '. $dia_hoje.'º dia do mês de '.$mes_hoje.' do ano '.$ano_hoje.', foi concluído o processo de apuração das notas finais dos alunos do curso '.$nome_curso.', '.$nome_serie.', turma '.$nome_turma.', do período do ano letivo de '.$sigla_periodo.'.';

	$html .= '<table id="t02" style="  border-collapse: collapse; font-family: arial, sans-serif; width: 100%;">
	
	
	<tr>
	<th style="">Nº</th>
	<th style="">Aluno</th>';

	$query_r6 = $pdo->query("SELECT * FROM tbgradecurricular where IdSerie = '$id_serie' and IdPeriodo ='$id_periodo' order by IdDisciplina");
	$res_r6 = $query_r6->fetchAll(PDO::FETCH_ASSOC);


	for ($j=0; $j < count($res_r6); $j++) { 
		foreach ($res_r6[$j] as $key => $value) {
		}
		$id_disciplina = @$res_r6[$j]['IdDisciplina'];

		$query_disc = $pdo->query("SELECT * FROM tbdisciplina where IdDisciplina = '$id_disciplina' ");
		$res_disc = $query_disc->fetchAll(PDO::FETCH_ASSOC);

		$nome_disciplina = @$res_disc[0]['NomeDisciplina'];

		$html .= '<th text-rotate="90">'.$nome_disciplina.'</th>';



		if (($j + 1) == count($res_r6)) {
			$html .= '<th text-rotate="90"><p>Frequência anual (%)</p></th>';
			$html .= '<th style=""><p>Situação Final</p></th>';
			$html .= '</tr>';
		}



	}



	$query_r7 = $pdo->query("SELECT * FROM tbalunoturma where IdTurma = '$id_turma'");
	$res_r7 = $query_r7->fetchAll(PDO::FETCH_ASSOC);


	for ($j=0; $j < count($res_r7); $j++) { 
		foreach ($res_r7[$j] as $key => $value) {
		}

		$id_aluno = @$res_r7[$j]['IdAluno'];

		$query = $pdo->query("SELECT * FROM tbaluno where IdAluno = '$id_aluno' ");
		$res111 = $query->fetchAll(PDO::FETCH_ASSOC);

		$nome2 = @$res111[0]['NomeAluno'];

		$html .= '<tr>';

		$html .= '
		<td>'.($j + 1).'</td>
		<td>'.$nome2.'</td>';

		$query_r66 = $pdo->query("SELECT * FROM tbgradecurricular where IdSerie = '$id_serie' and IdPeriodo ='$id_periodo' order by IdDisciplina");
		$res_r66 = $query_r66->fetchAll(PDO::FETCH_ASSOC);
		$total_faltas = 0;
		for ($t=0; $t < count($res_r66); $t++) { 
			foreach ($res_r66[$t] as $key => $value) {
			}

			$id_disciplina2 = @$res_r66[$t]['IdDisciplina'];

			$query = $pdo->query("SELECT * FROM tbhistoriconotas where IdAluno = '$id_aluno' and CodigoSerie = '$codigo_serie' and IdDisciplina = '$id_disciplina2' order by IdDisciplina");
			$res133 = $query->fetchAll(PDO::FETCH_ASSOC);

			if (isset($res133)) {
				$nota = @$res133[0]['NotaFinal'];
				$cargahoraria_anual = @$res133[0]['CargaHorariaAnual'];
				$faltas = @$res133[0]['QuantidadeFaltasAnual'];
				$resultado_final = @$res133[0]['ResultadoFinal'];
				$id_disciplina = @$res133[0]['IdDisciplina'];



				$faltas1 = rtrim($faltas);

				$total_faltas = $total_faltas + $faltas;

				$html .= '
				<td>'.$nota.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$faltas1.'</td>
				';

				
			}else{
				

			}

			if (($t + 1) == count($res_r66)) {

				$frequencia_anual = 100 - (($total_faltas*100) / 1000 );

				
				$html .= '<td>'.$frequencia_anual.'</td>';

				if (($resultado_final == 'A') or ($resultado_final == 'Aprovado Prova Final') or ($resultado_final == 'Aprovado por REC')) {
					$resultado_finalF = 'Aprovado';
				}elseif($resultado_final == 'R'){
					$resultado_finalF = 'Reprovado';
				}elseif($resultado_final == 'C'){
					$resultado_finalF = 'Cursando';
				}else{
					$resultado_finalF = $resultado_final;
				}


				$html .= '<td align= "center">'.$resultado_finalF.'</td>';
				$html .= '</tr>';


			}
			
		}


	}
	$html .= '<tr>
	<td align= "center" colspan="2">CARGA HORÁRIA TOTAL</td>';


	$query_r6 = $pdo->query("SELECT * FROM tbgradecurricular where IdSerie = '$id_serie' and IdPeriodo ='$id_periodo' order by IdDisciplina");
	$res_r6 = $query_r6->fetchAll(PDO::FETCH_ASSOC);

	$cargahoraria_total = 0;

	for ($j=0; $j < count($res_r6); $j++) { 
		foreach ($res_r6[$j] as $key => $value) {
		}
		$id_disciplina = @$res_r6[$j]['IdDisciplina'];

		$query_disc = $pdo->query("SELECT * FROM tbdisciplina where IdDisciplina = '$id_disciplina' ");
		$res_disc = $query_disc->fetchAll(PDO::FETCH_ASSOC);


		if(($id_serie >= 4) && ($id_serie <= 8)){

			$cargahoraria = @$res_disc[0]['CH_Fundamental1'];


		}else{
			$cargahoraria = @$res_disc[0]['CH_Fundamental2'];
		}

		$cargahorariaF = intval($cargahoraria);
		$cargahoraria_total = $cargahoraria_total + $cargahorariaF;

		

		$html .= '<td align= "center">'.$cargahorariaF.'</td>';

	}

	$html .= '<td align= "center" colspan="2">'.$cargahoraria_total.'</td>';


	$html .= '</tr>';

	$html .= '<tr>
	<td align= "center" colspan="2">TOTAL DE FALTAS</td>';

	$query_r6 = $pdo->query("SELECT * FROM tbgradecurricular where IdSerie = '$id_serie' and IdPeriodo ='$id_periodo' order by IdDisciplina");
	$res_r6 = $query_r6->fetchAll(PDO::FETCH_ASSOC);

	$faltas_total_anual = 0;

	for ($j=0; $j < count($res_r6); $j++) { 
		$faltas_total = 0;
		foreach ($res_r6[$j] as $key => $value) {
		}
		$id_disciplina = @$res_r6[$j]['IdDisciplina'];

		$query = $pdo->query("SELECT * FROM tbhistoriconotas where IdDisciplina = '$id_disciplina' and AnoConclusao = '$sigla_periodo' and CodigoSerie = '$codigo_serie' order by IdDisciplina");
		$res133 = $query->fetchAll(PDO::FETCH_ASSOC);

		for ($y=0; $y < count($res133); $y++) { 
			
			foreach ($res133[$y] as $key => $value) {
			}


			if (isset($res133)) {
				
				$faltas = @$res133[$y]['QuantidadeFaltasAnual'];
				
				$faltas_total = $faltas_total + $faltas;
				$faltas_total_anual = $faltas_total_anual + $faltas;
				
			}			


		}
		$html .= '<td align= "center">'.$faltas_total.'</td>';
	}

	$html .= '<td align= "center" colspan="2">'. $faltas_total_anual.'</td>';
	$html .= '</tr>';




	$html .= '</table><br><br>
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


$stylesheet = file_get_contents('style1.css');


$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($html,\Mpdf\HTMLParserMode::HTML_BODY);

$mpdf->Output("atas_de_resultados_".$sigla_periodo.".pdf", "I");




?>