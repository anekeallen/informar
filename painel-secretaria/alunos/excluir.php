<?php 
require_once("../../conexao.php"); 

$id = $_POST['id'];

$query = $pdo->query("SELECT * FROM tbaluno where IdAluno = '$id' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_responsavel = $res[0]['IdResponsavel'];


$pdo->query("DELETE FROM tbaluno WHERE IdAluno = '$id'");
$pdo->query("DELETE FROM tbresponsavel WHERE IdResponsavel = '$id_responsavel'");

echo 'Excluído com Sucesso!!';

?>