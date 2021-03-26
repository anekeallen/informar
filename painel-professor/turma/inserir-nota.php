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
	$res = $pdo->prepare("UPDATE tbfasenotaaluno SET Nota01 = :nota01, Nota02 = :nota02, Nota03 = :nota03 where IdTurma = :turma and IdDisciplina = :disciplina and IdAluno = :aluno and IdFaseNota = :fasenota");

}else{

	$res = $pdo->prepare("INSERT INTO tbfasenotaaluno SET IdTurma = :turma, IdDisciplina = :disciplina, IdAluno = :aluno, IdFaseNota = :fasenota, Nota01 = :nota01, Nota02 = :nota02, Nota03 = :nota03");

	if(($numero_fase == 3) and ($res6 != 0)){



		$res4 = $pdo->prepare("INSERT INTO tbfasenotaaluno SET IdTurma = :turma, IdDisciplina = :disciplina, IdAluno = :aluno, IdFaseNota = :fasenota4");

		$res4->bindValue(":disciplina", $disciplina);
		$res4->bindValue(":turma", $turma);
		$res4->bindValue(":fasenota4", $id_fase4);
		$res4->bindValue(":aluno", $aluno);

		$res4->execute();


	}


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

	if ($id_fase_atual != $id_fase) {
		$pdo->query("UPDATE tbsituacaoalunodisciplina SET IdFaseNotaAtual = '$idfasenota' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno'"); 
	}


/*$content = http_build_query(array(
'disciplina' => $disciplina,
'turma' => $turma,
'aluno' => $aluno,
'serie' => $serie,


));


$context = stream_context_create(array(
'http' => array(
'method' => 'POST',
'content' => $content,
)
));

$result = file_get_contents('http://localhost/informar/painel-professor/turma/inserir-mediaParcial.php', null, $context);

header("Location: inserir-mediaParcial.php");*/

?>