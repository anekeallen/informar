<?php 
require_once("../../conexao.php"); 

$id = $_POST['id'];


$pdo->query("DELETE FROM tbserie WHERE IdSerie = '$id'");


echo 'Excluído com Sucesso!!';

?>