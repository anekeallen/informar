<?php 

include_once ('../../config.php');

$query = $pdo->query("SELECT * FROM tbsituacaoalunodisciplina where IdTurma = '$turma' and IdAluno = '$aluno'");
$res2 = $query->fetchAll(PDO::FETCH_ASSOC);
$total_disciplinas = count($res2);

$query = $pdo->query("SELECT * FROM tbsituacaoalunodisciplina where IdTurma = '$turma' and IdAluno = '$aluno' and SituacaoAtual like 'Aprovado%'");
$res3 = $query->fetchAll(PDO::FETCH_ASSOC);
$total_disciplinas_aprovadas = count($res3);



if ($total_disciplinas == $total_disciplinas_aprovadas) {

	$query = $pdo->query("SELECT * FROM tbsituacaoalunoturma where SituacaoAlunoTurma = 'Aprovado'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);

	$id_situacao_turma = $res[0]['IdSituacaoAlunoTurma'];

	$pdo->query("UPDATE tbalunoturma SET IdSituacaoAlunoTurma = '$id_situacao_turma' where IdTurma = '$turma' and IdAluno = '$aluno'");
	
}else{

	$query = $pdo->query("SELECT * FROM tbsituacaoalunodisciplina where IdTurma = '$turma' and IdAluno = '$aluno' and SituacaoAtual like 'Reprovado%'");
	$res4 = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_disciplinas_reprovadas = count($res4);

	//Verifica o total de ddisciplinas que foram reprovadas e atualiza o status do aluno para progressao parcial
	if ($total_disciplinas_reprovadas > 0 and $total_disciplinas_reprovadas <= $total_disciplina_progressao ) {

		$query = $pdo->query("SELECT * FROM tbsituacaoalunoturma where SituacaoAlunoTurma = 'Progressão parcial'");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);

		$id_situacao_turma = $res[0]['IdSituacaoAlunoTurma'];

		$pdo->query("UPDATE tbalunoturma SET IdSituacaoAlunoTurma = '$id_situacao_turma' where IdTurma = '$turma' and IdAluno = '$aluno'");

	}else{ //Caso ele tenha reprovado em mais disciplinas que o permitido, ele é reprovado na turma

		$query = $pdo->query("SELECT * FROM tbsituacaoalunoturma where SituacaoAlunoTurma = 'Reprovado'");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);

		$id_situacao_turma = $res[0]['IdSituacaoAlunoTurma'];

		$pdo->query("UPDATE tbalunoturma SET IdSituacaoAlunoTurma = '$id_situacao_turma' where IdTurma = '$turma' and IdAluno = '$aluno'");


	}


}

require('atualizar-historico.php');

