<?php 
require_once("../../conexao.php"); 

$id = $_POST['id'];
$id_serie = $_POST['id_serie'];


$pdo->query("DELETE FROM tbgradecurricular WHERE IdPeriodo = '$id' and IdSerie = '$id_serie'");


echo 'Excluído com Sucesso!!';

?>