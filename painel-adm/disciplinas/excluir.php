<?php 
require_once("../../conexao.php"); 

$id = $_POST['id'];


$pdo->query("DELETE FROM tbdisciplina WHERE IdDisciplina = '$id'");


echo 'Excluído com Sucesso!!';

?>