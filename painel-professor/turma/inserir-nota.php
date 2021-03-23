<?php 
require_once("../../conexao.php"); 


$turma = $_POST['turma'];
$periodo = $_POST['periodo'];
$disciplina = $_POST['disciplina'];
$aluno = $_POST['aluno'];
$nota1 = $_POST['nota1'];
$nota2 = $_POST['nota2'];
$nota3 = $_POST['nota3'];
$serie = $_POST['serie'];

$numero_fase = $_POST['fase'];







if($nota1 > $nota_maxima1){
	echo 'A nota não pode ser maior que ' . $nota_maxima1. '!';
	exit();
}
if($nota2 > $nota_maxima2){
	echo 'A nota não pode ser maior que ' . $nota_maxima2. '!';
	exit();
}
if($nota3 > $nota_maxima3){
	echo 'A nota não pode ser maior que ' . $nota_maxima3. '!';
	exit();
}


$query = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$periodo' and NumeroFase = '$numero_fase' and IdSerie = '$serie'");
$res1 = $query->fetchAll(PDO::FETCH_ASSOC);

$idfasenota = $res1[0]['IdFaseNota'];


$query = $pdo->query("SELECT * FROM tbfasenotaaluno where IdTurma = '$turma' and IdAluno = '$aluno' and IdDisciplina = '$disciplina' and IdFaseNota = '$idfasenota'");
$res2 = $query->fetchAll(PDO::FETCH_ASSOC);

if (@count($res2) != 0) {
	$res = $pdo->prepare("UPDATE tbfasenotaaluno SET Nota01 = :nota01, Nota02 = :nota02, Nota03 = :nota03 where IdTurma = :turma and IdDisciplina = :disciplina and IdAluno = :aluno and IdFaseNota = :fasenota");

}else{

	$res = $pdo->prepare("INSERT INTO tbfasenotaaluno SET IdTurma = :turma, IdDisciplina = :disciplina, IdAluno = :aluno, IdFaseNota = :fasenota, Nota01 = :nota01, Nota02 = :nota02, Nota03 = :nota03");


}

$res->bindValue(":nota01", $nota1);
$res->bindValue(":nota02", $nota2);
$res->bindValue(":nota03", $nota3);
$res->bindValue(":disciplina", $disciplina);
$res->bindValue(":turma", $turma);
$res->bindValue(":fasenota", $idfasenota);
$res->bindValue(":aluno", $aluno);


$res->execute();


echo 'Salvo com Sucesso!';

?>