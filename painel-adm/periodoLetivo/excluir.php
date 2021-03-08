<?php 
require_once("../../conexao.php"); 

$id = $_POST['id'];


$pdo->query("DELETE FROM tbperiodo WHERE IdPeriodo = '$id'");


echo 'Excluído com Sucesso!!';

?>