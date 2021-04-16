<?php 
require_once("../../conexao.php"); 

$id_aluno = $_POST['aluno'];
$id_turma = $_POST['turma'];

$res = $pdo->query("DELETE FROM tbalunoturma WHERE IdAluno = '$id_aluno' and IdTurma = '$id_turma'");

$res = $pdo->query("DELETE FROM tbsituacaoalunodisciplina WHERE IdAluno = '$id_aluno' and IdTurma = '$id_turma'");


echo 'Excluído com Sucesso!!';

?>