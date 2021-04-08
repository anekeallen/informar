<?php 
require_once("../../conexao.php"); 

$id = $_POST['id'];

$query = $pdo->query("SELECT * FROM tbprofessor where IdProfessor = '$id' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$cpf_usu = $res[0]['CPF'];

$query_id = $pdo->query("SELECT * FROM usuarios where cpf = '$cpf_usu' ");
$res_id = $query_id->fetchAll(PDO::FETCH_ASSOC);
$id_usu = $res_id[0]['id'];


$pdo->query("DELETE FROM tbprofessor WHERE IdProfessor = '$id'");
$pdo->query("DELETE FROM usuarios WHERE id = '$id_usu'");
$pdo->query("DELETE FROM tbprofessordisciplina WHERE IdProfessor = '$id'");

echo 'Excluído com Sucesso!!';

?>