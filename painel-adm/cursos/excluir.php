<?php 
require_once("../../conexao.php"); 

$id = $_POST['id'];


$pdo->query("DELETE FROM tbcurso WHERE IdCurso = '$id'");


echo 'Excluído com Sucesso!!';

?>