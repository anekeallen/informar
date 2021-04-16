<?php 
require_once("../../conexao.php"); 

$id = $_POST['id'];

//VERIFICAR SE TEM ALUNOS NA TURMA PARA RESTRINGIR EXCLUSÃO
$query = $pdo->query("SELECT * FROM tbalunoturma where IdTurma = '$id' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res)>0){
	echo "Essa turma possui alunos matriculados, para excluir a turma precisa retirar as matriculas dos alunos, porém todas as notas dos alunos serão perdidas";
	exit();
}



$pdo->query("DELETE FROM tbturmaprofessor WHERE IdTurma = '$id'");

$pdo->query("DELETE FROM tbturma WHERE IdTurma = '$id'");

$pdo->query("DELETE FROM aulas WHERE turma = '$id'");

$pdo->query("DELETE FROM chamadas WHERE turma = '$id'");

$pdo->query("DELETE FROM tbfasenotaaluno where IdTurma = '$id' ");


echo 'Excluído com Sucesso!!';

?>