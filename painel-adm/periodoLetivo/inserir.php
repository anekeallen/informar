<?php 
require_once("../../conexao.php"); 

$periodo = $_POST['periodoLetivo-cat'];
$sigla = $_POST['sigla-cat'];
$dataInicial = $_POST['dataInicial-cat'];
$dataFinal = $_POST['dataFinal-cat'];
$dias_letivos = $_POST['dias_letivos-cat'];
$semanas_letivas = $_POST['semanas_letivas-cat'];
$ano_conclusao = $_POST['ano_conclusao-cat'];

$antigo = $_POST['antigo'];

$id = $_POST['txtid2'];

if($periodo == ""){
	echo 'O Nome do Período é Obrigatório!';
	exit();
}

if($sigla == ""){
	echo 'A Sigla do Período é Obrigatória!';
	exit();
}

if($dataInicial == ""){
	echo 'A Data Inicial do Período é Obrigatória!';
	exit();
}
if($dataFinal == ""){
	echo 'A Data Final do Período é Obrigatória!';
	exit();
}





//VERIFICAR SE O REGISTRO JÁ EXISTE NO BANCO
if($antigo != $sigla){
	$query = $pdo->query("SELECT * FROM tbperiodo where SiglaPeriodo = '$sigla' ");
	$res3 = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res3);
	if($total_reg > 0){
		echo 'O Período Letivo já está Cadastrado!';
		exit();
	}
}


$query = $pdo->query("SELECT IdPeriodo FROM tbperiodo order by IdPeriodo desc limit 1  ");
$res2 = $query->fetchAll(PDO::FETCH_ASSOC);

$id_periodo_anterior = $res2[0]['IdPeriodo'];


if($id == ""){
	$res = $pdo->prepare("INSERT INTO tbperiodo SET NomePeriodo = :NomePeriodo, DataInicial = :DataInicial, DataFinal = :DataFinal, DiasLetivos = :DiasLetivos, SemanasLetivas = :SemanasLetivas, AnoConclusao = :AnoConclusao, SiglaPeriodo = :SiglaPeriodo");



	



}else{
	$res = $pdo->prepare("UPDATE tbperiodo SET NomePeriodo = :NomePeriodo, DataInicial = :DataInicial, DataFinal = :DataFinal, DiasLetivos = :DiasLetivos, SemanasLetivas = :SemanasLetivas, AnoConclusao = :AnoConclusao, SiglaPeriodo = :SiglaPeriodo WHERE IdPeriodo = '$id'");

	
	
}

$res->bindValue(":NomePeriodo", $periodo);
$res->bindValue(":DataInicial", $dataInicial);
$res->bindValue(":DataFinal", $dataFinal);
$res->bindValue(":DataFinal", $dataFinal);
$res->bindValue(":DiasLetivos", $dias_letivos);
$res->bindValue(":SemanasLetivas", $semanas_letivas);
$res->bindValue(":AnoConclusao", $ano_conclusao);
$res->bindValue(":SiglaPeriodo", $sigla);


$res->execute();

$id_ultimo = $pdo->lastInsertId();



$pdo->query("UPDATE tbperiodo SET IdProximoPeriodo = '$id_ultimo' WHERE IdPeriodo = '$id_periodo_anterior'");

if($id == ""){

	$query = $pdo->query("SELECT * from tbserie where StSerieUtilizaAvaliacaoNota = 1 ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);


	for ($i=0; $i < count($res); $i++) { 	
		foreach ($res[$i] as $key => $value) {
		}
		$id_serie = $res[$i]['IdSerie'];
		$informada = null;
		$id_composicao = null;
		$id_formulaNota = null;
		$id_formulaAprovacao = null;
		$id_formulaFalta = null;

		$query2 = $pdo->query("SELECT * from tbfases_ano order by NumeroFase asc");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		for ($j=0; $j < count($res2); $j++) { 
			foreach ($res2[$j] as $key => $value) {
			}

			$nome_fase = @$res2[$j]['NomeFase'];
			$sigla_fase = @$res2[$j]['CabecBoletim'];
			$informada = @$res2[$j]['FaseInformada'];
			$numeroFase = @$res2[$j]['NumeroFase'];
			$id_composicao = @$res2[$j]['IdFormulaComposicaoNota'];
			$id_formulaNota = @$res2[$j]['IdFormulaNota'];
			$id_formulaAprovacao = @$res2[$j]['IdFormulaAprovacao'];
			$id_formulaFalta = @$res2[$j]['IdFormulaFalta'];

			$pdo->query("INSERT INTO tbfasenota SET IdPeriodo = '$id_ultimo', IdSerie = '$id_serie', NumeroFase = '$numeroFase', NomeFase = '$nome_fase', CabecBoletim = '$sigla_fase', StFaseInformada = '$informada', IdFormulaComposicaoNota = '$id_composicao', IdFormulaNota = '$id_formulaNota', IdFormulaAprovacao = '$id_formulaAprovacao', IdFormulaFalta = '$id_formulaFalta'");

		}



	}
}




echo 'Salvo com Sucesso!!';

?>