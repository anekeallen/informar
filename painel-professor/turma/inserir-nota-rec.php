<?php  
require_once("../../conexao.php"); 

$turma = $_POST['turma_rec'];
$periodo = $_POST['periodo_rec'];
$disciplina = $_POST['disciplina_rec'];
$aluno = $_POST['aluno_rec'];
$nota_rec = $_POST['nota_rec'];
$numero_fase = $_POST['fase_rec'];





if($nota_rec > $maximo_nota_rec){
	echo 'A nota não pode ser maior que ' . $maximo_nota_rec. '!';
	exit();
}



$query_2 = $pdo->query("SELECT * FROM tbturma where IdTurma = '$turma' ");
$res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
$serie = $res_2[0]['IdSerie'];

$query = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$periodo' and IdSerie = '$serie' and NumeroFase = 4");
$res4 = $query->fetchAll(PDO::FETCH_ASSOC);

$id_fase4 = $res4[0]['IdFaseNota'];


$query5 = $pdo->query("SELECT * FROM tbfasenotaaluno where IdTurma = '$turma' and IdAluno = '$aluno' and IdDisciplina = '$disciplina' and IdFaseNota = '$id_fase4'");
$res5 = $query5->fetchAll(PDO::FETCH_ASSOC);

$media_parcial = $res5[0]['NotaFase'];

$media_anual = ($nota_rec + $media_parcial) / 2 ;


//Pegar id da fase 5 para atualizar a rec
$query = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$periodo' and IdSerie = '$serie' and NumeroFase = 5");
$res5 = $query->fetchAll(PDO::FETCH_ASSOC);

$id_fase5 = $res5[0]['IdFaseNota'];

//Pegar id da fase 5 para atualizar a media anual
$query = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$periodo' and IdSerie = '$serie' and NumeroFase = 6");
$res6 = $query->fetchAll(PDO::FETCH_ASSOC);

$id_fase6 = $res6[0]['IdFaseNota'];


$pdo->query("UPDATE tbfasenotaaluno SET  NotaFase = '$nota_rec' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno' and IdFaseNota = '$id_fase5'");

$pdo->query("UPDATE tbfasenotaaluno SET  NotaFase = '$media_anual' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno' and IdFaseNota = '$id_fase6'");



	

if ($media_anual >= $media_aprovacao_rec) {

	//Pegar id da fase 8 media final
	$query = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$periodo' and IdSerie = '$serie' and NumeroFase = 8");
	$res5 = $query->fetchAll(PDO::FETCH_ASSOC);

	$id_fase8 = $res5[0]['IdFaseNota'];



	$pdo->query("UPDATE tbfasenotaaluno SET  NotaFase = '$media_anual' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno' and IdFaseNota = '$id_fase8'");

	$pdo->query("UPDATE tbsituacaoalunodisciplina SET SituacaoAtual = 'Aprovado por REC', IdFaseNotaAtual = '$id_fase8' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno'");
	
}else{

	//Pegar id da fase 7 para recuperação final
	$query = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$periodo' and IdSerie = '$serie' and NumeroFase = 7");
	$res7 = $query->fetchAll(PDO::FETCH_ASSOC);

	$id_fase7 = $res7[0]['IdFaseNota'];

	$pdo->query("UPDATE tbsituacaoalunodisciplina SET SituacaoAtual = 'Recuperação Prova Final', IdFaseNotaAtual = '$id_fase7' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno'");
}



echo "Salvo com Sucesso!";


// Pensar na forma de atualizar a sistuacao na turma
$query = $pdo->query("SELECT * FROM tbsituacaoalunodisciplina where IdTurma = '$turma' and IdAluno = '$aluno' and ((SituacaoAtual ='Cursando') or (SituacaoAtual like 'Recuperação%'))");
$res2 = $query->fetchAll(PDO::FETCH_ASSOC);
$total_disciplinas_cursando = count($res2);

if ($total_disciplinas_cursando == 0) {
	require('atualizar-situacao-turma.php');
}





?>