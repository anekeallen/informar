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

//VERIFICAR SE O REGISTRO JÁ EXISTE NO BANCO
if($antigo != $sigla_turma){
	$query = $pdo->query("SELECT * FROM tbturma where SiglaTurma = '$sigla_turma' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'A turma já está Cadastrada!';
		exit();
	}
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