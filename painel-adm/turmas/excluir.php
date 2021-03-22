<?php 
require_once("../../conexao.php"); 

$id = $_POST['id'];

//VERIFICAR SE TEM ALUNOS NA TURMA PARA RESTRINGIR EXCLUSÃO
$query = $pdo->query("SELECT * FROM tbalunoturma where IdTurma = '$id' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res)>0){
	echo "Essa turma possui alunos matriculados, para excluir a turma precisa retirar as matriculas dos alunos, mas todos os dados dos alunos serão perdidos";
	exit();
}


$pdo->query("DELETE FROM tbturmaprofessor WHERE IdTurma = '$id'");

$pdo->query("DELETE FROM tbturma WHERE IdTurma = '$id'");


echo 'Excluído com Sucesso!!';

?>