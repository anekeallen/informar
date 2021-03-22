<?php 
require_once("../../conexao.php"); 

$id = $_POST['id'];


$pdo->query("DELETE FROM tbfases_ano WHERE NumeroFase = '$id'");


echo 'Excluído com Sucesso!!';

?>