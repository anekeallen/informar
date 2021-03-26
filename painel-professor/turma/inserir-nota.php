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


//Verificar o id da fase nota do NumeroFase = 5
$query = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$periodo' and IdSerie = '$serie' and NumeroFase = 5");
$res55 = $query->fetchAll(PDO::FETCH_ASSOC);

$id_fase5 = $res55[0]['IdFaseNota'];



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

//Atualizar situação do aluno na disciplina
$query6 = $pdo->query("SELECT * FROM tbsituacaoalunodisciplina where IdTurma = '$turma' and IdAluno = '$aluno' and IdDisciplina = '$disciplina'");
$res6 = $query6->fetchAll(PDO::FETCH_ASSOC);
$id_fase_atual = $res6[0]['IdFaseNotaAtual'];

if (($id_fase_atual != $idfasenota) ) {
	$pdo->query("UPDATE tbsituacaoalunodisciplina SET IdFaseNotaAtual = '$idfasenota' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno'"); 
}







/*
//Verificar se ja existem 3 fases cadastradas com notas e fazer a média
$query = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$periodo' and IdSerie = '$serie' and (NumeroFase = 1 or NumeroFase = 2 or NumeroFase = 3)");
$res1 = $query->fetchAll(PDO::FETCH_ASSOC);
$contadorFases = 0;
$notaFase = array();
for ($i=0; $i < count($res1); $i++) { 
	foreach ($res1[$i] as $key => $value) {
	}

	$id_fase = $res1[$i]['IdFaseNota'];

	$query2 = $pdo->query("SELECT * FROM tbfasenotaaluno where IdTurma = '$turma' and IdAluno = '$aluno' and IdDisciplina = '$disciplina' and IdFaseNota = '$id_fase'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

	if (count($res2) != 0) {
		$notaFase[] = $res2[0]['NotaFase'];
		$contadorFases = $contadorFases + 1;
	}


}


if ($contadorFases == 3) {

	$mediaParcial=0;
	for ($i=0; $i < count($notaFase); $i++) {

		$mediaParcial = $mediaParcial + $notaFase[$i];
	}

	$mediaParcial = $mediaParcial / 3 ;

	$mediaParcialF = number_format($mediaParcial, 2, '.', '');




	$query5 = $pdo->query("SELECT * FROM tbfasenotaaluno where IdTurma = '$turma' and IdAluno = '$aluno' and IdDisciplina = '$disciplina' and IdFaseNota = '$id_fase4'");
	$res5 = $query5->fetchAll(PDO::FETCH_ASSOC);

	if (count($res5) == 0) {
		
	}else{

		
		$pdo->query("UPDATE tbfasenotaaluno SET Nota01 = '$notaFase[0]', Nota02 = '$notaFase[1]', Nota03 = '$notaFase[2]', NotaFase = '$mediaParcialF' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno' and IdFaseNota = '$id_fase4'");

		echo "!";


	}

	

	
}

$query6 = $pdo->query("SELECT * FROM tbsituacaoalunodisciplina where IdTurma = '$turma' and IdAluno = '$aluno' and IdDisciplina = '$disciplina'");
$res6 = $query6->fetchAll(PDO::FETCH_ASSOC);
$id_fase_atual = $res6[0]['IdFaseNotaAtual'];

if (($id_fase_atual != $id_fase) ) {
	$pdo->query("UPDATE tbsituacaoalunodisciplina SET IdFaseNotaAtual = '$idfasenota' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno'"); 
}

if (isset($mediaParcialF)) {
	# code...


	if ($mediaParcialF >= $media_aprovacao) {

		$pdo->query("UPDATE tbsituacaoalunodisciplina SET SituacaoAtual = 'Aprovado' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno'"); 

	}else if($mediaParcialF < $media_reprovacao){

		$pdo->query("UPDATE tbsituacaoalunodisciplina SET SituacaoAtual = 'Reprovado' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno'"); 
	}else{
		$pdo->query("UPDATE tbsituacaoalunodisciplina SET SituacaoAtual = 'Recuperação Anual' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno'");
	}


} */


?>

