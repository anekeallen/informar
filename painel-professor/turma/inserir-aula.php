<?php 
require_once("../../conexao.php"); 

$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$disciplina = $_POST['disc-cat'];
$id_professor = $_POST['professor'];
$data = $_POST['data_aula'];
$turma = $_POST['turma'];
$periodo = $_POST['periodo'];
$fase = $_POST['fase'];


if($nome == ""){
	echo 'O nome é Obrigatório!';
	exit();
}


$res = $pdo->prepare("INSERT INTO aulas SET turma = :turma, nome = :nome, descricao = :descricao, periodo = :periodo, data = :data, id_disciplina = :id_disciplina, id_professor = :id_professor, NumeroFase = :fase");	



$res->bindValue(":nome", $nome);
$res->bindValue(":descricao", $descricao);
$res->bindValue(":turma", $turma);
$res->bindValue(":periodo", $periodo);
$res->bindValue(":data", $data);
$res->bindValue(":id_disciplina", $disciplina);
$res->bindValue(":id_professor", $id_professor);
$res->bindValue(":fase", $fase);

$res->execute();

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









echo 'Salvo com Sucesso!';

?>