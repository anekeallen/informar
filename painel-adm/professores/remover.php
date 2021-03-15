<?php 

require_once("../../conexao.php"); 

$id = $_POST['id'];

$pdo->query("DELETE FROM tbprofessordisciplina WHERE IdProfessor = '$id'");

echo "Removido com Sucesso!!";
 ?>