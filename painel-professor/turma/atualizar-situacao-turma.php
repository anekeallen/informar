<?php 

$query = $pdo->query("SELECT * FROM tbsituacaoalunodisciplina where IdTurma = '$turma' and IdAluno = '$aluno'");
$res2 = $query->fetchAll(PDO::FETCH_ASSOC);
$total_disciplinas = count($res2);

$query = $pdo->query("SELECT * FROM tbsituacaoalunodisciplina where IdTurma = '$turma' and IdAluno = '$aluno' and ((SituacaoAtual='Aprovado') or (SituacaoAtual='Aprovado ')");
$res2 = $query->fetchAll(PDO::FETCH_ASSOC);
$total_disciplinas = count($res2);




 ?>