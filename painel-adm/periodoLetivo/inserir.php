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
	



echo 'Salvo com Sucesso!!';

?>