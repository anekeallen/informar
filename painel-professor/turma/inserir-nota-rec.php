<?php  
require_once("../../conexao.php"); 

$turma = $_POST['turma_rec'];
$periodo = $_POST['periodo_rec'];
$disciplina = $_POST['disciplina_rec'];
$aluno = $_POST['aluno_rec'];
$nota = $_POST['nota_rec'];
$numero_fase = $_POST['fase_rec'];




if($nota > $maximo_nota_rec){
	echo 'A nota não pode ser maior que ' . $maximo_nota_rec. '!';
	exit();
}


// Faltando saber como funciona a rec anual para atualizar





?>