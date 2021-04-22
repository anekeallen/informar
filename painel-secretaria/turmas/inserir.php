<?php 
require_once("../../conexao.php"); 



$id_periodo = $_POST['ano'];
$id_serie = $_POST['serie'];
$nome_turma = $_POST['nome-turma'];
$sigla_turma = $_POST['sigla'];
$turno = $_POST['turno'];
$vagas = $_POST['vagas'];
//$codigo = $_POST['CodigoAgrupamento'];
$id_sala = $_POST['sala'];

$data_final = $_POST['data_final'];
$data_inicio = $_POST['data_inicio'];


$id = $_POST['txtid2'];
$antigo = $_POST['antigo'];




if($id_serie == ""){
	echo 'A Série é Obrigatória!';
	exit();
}
if($id_periodo == ""){
	echo 'O ano é Obrigatório!';
	exit();
}
if($sigla_turma == ""){
	echo 'A Sigla da turma é Obrigatória!';
	exit();
}
if($turno == ""){
	echo 'O turno é Obrigatório!';
	exit();
}

$id_sala = isset($_REQUEST['sala'])? intval($_REQUEST['sala']): 0;

if($data_inicio == ""){
	$data_inicio = null;
}
if($data_final == ""){
	$data_final = null;
}



if ($id == "") {
	$res = $pdo->prepare("INSERT INTO tbturma SET IdPeriodo = :periodo, IdSala = :sala, IdSerie =:serie, DataInicial = :data_inicio, DataFinal = :data_final, NomeTurma =:nometurma, SiglaTurma =:sigla, TurnoPrincipal = :turno, TotalVagas = :total");


	
} else{

	$res = $pdo->prepare("UPDATE tbturma SET IdPeriodo = :periodo, IdSala = :sala, IdSerie =:serie, DataInicial = :data_inicio, DataFinal = :data_final, NomeTurma =:nometurma, SiglaTurma =:sigla, TurnoPrincipal = :turno, TotalVagas = :total where IdTurma = '$id'");

}


$res->bindValue(":periodo", $id_periodo);
$res->bindValue(":sala", $id_sala);
$res->bindValue(":serie", $id_serie);
$res->bindValue(":data_inicio", $data_inicio);
$res->bindValue(":data_final", $data_final);
$res->bindValue(":nometurma", $nome_turma);
$res->bindValue(":sigla", $sigla_turma);
$res->bindValue(":turno", $turno);
$res->bindValue(":total", $vagas);



$res->execute();



echo 'Salvo com Sucesso!!';

?>