<?php 
require_once("../../conexao.php"); 

$id = $_POST['idaula'];

$query = $pdo->query("SELECT * FROM aulas where id = '$id' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$turma = @$res[0]['turma'];
$periodo = @$res[0]['periodo'];
$fase = @$res[0]['NumeroFase'];
$disciplina = @$res[0]['id_disciplina'];




$pdo->query("DELETE FROM aulas WHERE id = '$id'");
$pdo->query("DELETE FROM chamadas WHERE aula = '$id'");

$query = $pdo->query("SELECT * FROM aulas where turma = '$turma' and periodo = '$periodo' and NumeroFase = '$fase' and id_disciplina = '$disciplina' order by id asc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$total_aulas = count($res);

$query_2 = $pdo->query("SELECT * FROM tbturma where IdTurma = '$turma' ");
$res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
$serie = $res_2[0]['IdSerie'];


$query = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$periodo' and IdSerie = '$serie' and NumeroFase = '$fase'");
$res4 = $query->fetchAll(PDO::FETCH_ASSOC);
$id_fase = $res4[0]['IdFaseNota'];

$pdo->query("UPDATE tbfasenotaaluno SET  QuantAulasDadas = '$total_aulas' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdFaseNota = '$id_fase'");

//atualizar total de aulas da fase final
$query = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$periodo' and IdSerie = '$serie' and NumeroFase = 8");
$res4 = $query->fetchAll(PDO::FETCH_ASSOC);
$id_fase_final = $res4[0]['IdFaseNota'];

$query = $pdo->query("SELECT * FROM tbfasenotaaluno where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdFaseNota = '$id_fase_final'");

$res_final = $query->fetchAll(PDO::FETCH_ASSOC);

if (count($res_final) > 0) {
	//Atualizar total de aulas na fase da media final
	$query = $pdo->query("SELECT * FROM aulas where turma = '$turma' and periodo = '$periodo'   and id_disciplina = '$disciplina' order by id asc ");
	$res2 = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_aulas_geral = count($res2);

	$pdo->query("UPDATE tbfasenotaaluno SET  QuantAulasDadas = '$total_aulas_geral' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdFaseNota = '$id_fase_final'");
}

echo 'Excluído com Sucesso!';

?>