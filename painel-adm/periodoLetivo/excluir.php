<?php 
require_once("../../conexao.php"); 

$id = $_POST['id'];

$query = $pdo->query("SELECT * from tbturma where IdPeriodo = '$id' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

if (@count($res)!= 0) {
	echo "Não é possível excluir períodos letivos com turmas cadastradas nesse período!";
	exit();
}

$pdo->query("DELETE FROM tbfasenota WHERE IdPeriodo = '$id'");

$pdo->query("DELETE FROM tbperiodo WHERE IdPeriodo = '$id'");

$pdo->query("DELETE FROM tbgradecurricular WHERE IdPeriodo = '$id'");



echo 'Excluído com Sucesso!!';

?>