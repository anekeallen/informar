<?php 
require_once("../../conexao.php"); 



$id_serie = $_POST['serie'];
$id_ano = $_POST['ano_letivo'];


if(!isset($_POST['id_disci'])){
	echo "Selecione alguma Disciplina!";
	exit();
}

foreach (@$_POST['id_disci'] as $key => $value) {
	$id_disciplina1 = @$_POST['id_disci'][$key];

$query = $pdo->query("SELECT * FROM tbgradecurricular where IdSerie = '$id_serie' and IdPeriodo = '$id_ano' and IdDisciplina = '$id_disciplina1' ");
$res2 = $query->fetchAll(PDO::FETCH_ASSOC);

if (@count($res2)>0) {
	echo "Disciplina já cadastrada na Grade Curricular dessa Série";
	exit();
	
}
}



foreach (@$_POST['id_disci'] as $key => $value) {
	$id_disciplina = @$_POST['id_disci'][$key];

	$res = $pdo->prepare("INSERT INTO tbgradecurricular SET IdSerie = :idserie, IdDisciplina = :id_disciplina, IdPeriodo = :idperiodo");

	$res->bindValue(":idserie", $id_serie);
	$res->bindValue(":id_disciplina", $id_disciplina);
	$res->bindValue(":idperiodo", $id_ano);





	$res->execute();


}
echo 'Salvo com Sucesso!!';








?>