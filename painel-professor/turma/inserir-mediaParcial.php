<?php  
require_once("../../conexao.php");

$turma1 = $_POST['turma'];
$periodo1 = $_POST['periodo'];
$disciplina1 = $_POST['disciplina'];
$aluno1 = $_POST['aluno'];
$serie1 = $_POST['serie'];

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



//Verificar o id da fase nota do NumeroFase = 4
	$query = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$periodo' and IdSerie = '$serie' and NumeroFase = 4");
	$res4 = $query->fetchAll(PDO::FETCH_ASSOC);

	$id_fase4 = $res4[0]['IdFaseNota'];


	$query5 = $pdo->query("SELECT * FROM tbfasenotaaluno where IdTurma = '$turma' and IdAluno = '$aluno' and IdDisciplina = '$disciplina' and IdFaseNota = '$id_fase4'");
	$res5 = $query5->fetchAll(PDO::FETCH_ASSOC);

	if (count($res5) == 0) {
		$pdo->query("INSERT INTO tbfasenotaaluno SET IdTurma = '$turma', IdDisciplina = '$disciplina', IdAluno = '$aluno', IdFaseNota = '$id_fase4', Nota01 = '$notaFase[0]', Nota02 = '$notaFase[1]', Nota03 = '$notaFase[2]', NotaFase = '$mediaParcialF'");
	}else{

		$pdo->query("UPDATE tbfasenotaaluno SET Nota01 = '$notaFase[0]', Nota02 = '$notaFase[1]', Nota03 = '$notaFase[2]', NotaFase = '$mediaParcialF' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno' and IdFaseNota = '$id_fase4'");

	}


	
}



?>