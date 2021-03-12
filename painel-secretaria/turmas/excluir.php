<?php 
require_once("../../conexao.php"); 

$id = $_POST['id'];

//VERIFICAR SE TEM ALUNOS NA TURMA PARA RESTRINGIR EXCLUSÃO
$query = $pdo->query("SELECT * FROM matriculas where turma = '$id' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res)>0){
	echo "Essa turma possui alunos matriculados, remova os alunos para excluir a turma!";
	exit();
}


$pdo->query("DELETE FROM tbturma WHERE Idturma = '$id'");


echo 'Excluído com Sucesso!!';

?>