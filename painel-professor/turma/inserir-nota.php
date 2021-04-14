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


//Verificar o id da fase nota do NumeroFase = 4
$query = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$periodo' and IdSerie = '$serie' and NumeroFase = 4");
$res5 = $query->fetchAll(PDO::FETCH_ASSOC);

$id_fase4 = $res5[0]['IdFaseNota'];

$query = $pdo->query("SELECT * FROM tbfasenotaaluno where IdTurma = '$turma' and IdAluno = '$aluno' and IdDisciplina = '$disciplina' and IdFaseNota = '$id_fase4'");

$res6 = $query->fetchAll(PDO::FETCH_ASSOC);

//Pega idfasenota para add o id certo da fase da nota, assim sabendo se eh 1ºtrimestre, 2º ou 3º...
$query = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$periodo' and NumeroFase = '$numero_fase' and IdSerie = '$serie'");
$res1 = $query->fetchAll(PDO::FETCH_ASSOC);

$idfasenota = $res1[0]['IdFaseNota'];


$query = $pdo->query("SELECT * FROM tbfasenotaaluno where IdTurma = '$turma' and IdAluno = '$aluno' and IdDisciplina = '$disciplina' and IdFaseNota = '$idfasenota'");
$res2 = $query->fetchAll(PDO::FETCH_ASSOC);

if (@count($res2) != 0) {
	$pdo->query("UPDATE tbfasenotaaluno SET Nota01 = '$nota1', Nota02 = '$nota2', Nota03 = '$nota3' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno' and IdFaseNota = '$idfasenota'");

	echo 'Atualizado com Sucesso!';

}else{

	$pdo->query("INSERT INTO tbfasenotaaluno SET IdTurma = '$turma', IdDisciplina = '$disciplina', IdAluno = '$aluno', IdFaseNota = '$idfasenota', Nota01 = '$nota1', Nota02 = '$nota2', Nota03 = '$nota3'");

	echo 'Salvo com Sucesso!';



	if(($numero_fase == 3) and ($res6 != 0)){


		$pdo->query("INSERT INTO tbfasenotaaluno SET IdTurma = '$turma', IdDisciplina = '$disciplina', IdAluno = '$aluno', IdFaseNota = '$id_fase4'");

		echo ' E Média Parcial Atualizada!';

	}



}

	// Salvar aulas do trimestre
$total_faltas = 0;

$query = $pdo->query("SELECT * FROM aulas where turma = '$turma' and periodo = '$periodo' and NumeroFase = '$numero_fase' and id_disciplina = '$disciplina'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$total_aulas = count($res);

$pdo->query("UPDATE tbfasenotaaluno SET  QuantAulasDadas = '$total_aulas' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdFaseNota = '$idfasenota'");


for ($i=0; $i < count($res); $i++) { 
	foreach ($res[$i] as $key => $value) {
	}
	$id_aula = $res[$i]['id'];

	$query1 = $pdo->query("SELECT * FROM chamadas where turma = '$turma' and periodo = '$periodo' and NumeroFase = '$numero_fase' and aluno = '$aluno' and presenca = 'F' and aula = '$id_aula'");
	$res1 = $query1->fetchAll(PDO::FETCH_ASSOC);

	$total_faltas = $total_faltas + count($res1);
	

}
	//salvar faltas dos trimestres FALTA DEFINIR O ERRO DAS FALTAS	


$pdo->query("UPDATE tbfasenotaaluno SET  Faltas = '$total_faltas' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdFaseNota = '$idfasenota' and IdAluno = '$aluno'");

//Atualizar situação do aluno na disciplina
$query6 = $pdo->query("SELECT * FROM tbsituacaoalunodisciplina where IdTurma = '$turma' and IdAluno = '$aluno' and IdDisciplina = '$disciplina'");
$res6 = $query6->fetchAll(PDO::FETCH_ASSOC);
$id_fase_atual = $res6[0]['IdFaseNotaAtual'];

if (($id_fase_atual != $idfasenota) ) {
	$pdo->query("UPDATE tbsituacaoalunodisciplina SET IdFaseNotaAtual = '$idfasenota' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno'"); 
}









?>

