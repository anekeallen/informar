<?php 
require_once("../../conexao.php"); 

$id = $_POST['id'];

$query = $pdo->query("SELECT * FROM tbaluno where IdResponsavel = '$id' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res)!=0){
	echo "Existem alunos relacionados a esse responsável, exclua primeiro os alunos!";
	exit();
}


$pdo->query("DELETE FROM tbresponsavel WHERE IdResponsavel = '$id'");


echo 'Excluído com Sucesso!!';

?>