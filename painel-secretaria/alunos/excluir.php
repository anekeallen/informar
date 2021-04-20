<?php 
require_once("../../conexao.php"); 

$id = $_POST['id'];

$query = $pdo->query("SELECT * FROM tbaluno where IdAluno = '$id' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_responsavel = $res[0]['IdResponsavel'];
$cpf = $res[0]['CPF'];


$pdo->query("DELETE FROM tbaluno WHERE IdAluno = '$id'");

$pdo->query("DELETE FROM usuarios WHERE cpf = '$cpf'");

echo 'Excluído com Sucesso!!';

?>