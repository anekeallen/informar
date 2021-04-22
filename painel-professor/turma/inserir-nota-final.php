<?php  
require_once("../../conexao.php"); 

$turma = $_POST['turma_final'];
$periodo = $_POST['periodo_final'];
$disciplina = $_POST['disciplina_final'];
$aluno = $_POST['aluno_final'];
$prova_final = $_POST['nota_final'];
$numero_fase = $_POST['fase_final'];



if ($prova_final == "") {
	echo "Insira uma nota válida!";
	exit();
}

if($prova_final > $maximo_nota_prova_final){
	echo 'A nota não pode ser maior que ' . $maximo_nota_prova_final. '!';
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

$media_final = (($media_parcial*2) + $prova_final) / 3 ;


//Pegar id da fase 7 para atualizar a prova final
$query = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$periodo' and IdSerie = '$serie' and NumeroFase = 7");
$res7 = $query->fetchAll(PDO::FETCH_ASSOC);

$id_fase7 = $res7[0]['IdFaseNota'];

//Pegar id da fase 8 para atualizar a media final
$query = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$periodo' and IdSerie = '$serie' and NumeroFase = 8");
$res8 = $query->fetchAll(PDO::FETCH_ASSOC);

$id_fase8 = $res8[0]['IdFaseNota'];


$pdo->query("UPDATE tbfasenotaaluno SET  NotaFase = '$prova_final' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno' and IdFaseNota = '$id_fase7'");

$pdo->query("UPDATE tbfasenotaaluno SET  NotaFase = '$media_final' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno' and IdFaseNota = '$id_fase8'");



	

if ($media_final >= $media_aprovacao_prova_final) {

	


	$pdo->query("UPDATE tbsituacaoalunodisciplina SET SituacaoAtual = 'Aprovado Prova Final', IdFaseNotaAtual = '$id_fase8' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno'");
	
}else{



	$pdo->query("UPDATE tbsituacaoalunodisciplina SET SituacaoAtual = 'Reprovado Prova Final', IdFaseNotaAtual = '$id_fase7' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno'");
}



echo "Salvo com Sucesso!";


// Pensar na forma de atualizar a sistuacao na turma
$query = $pdo->query("SELECT * FROM tbsituacaoalunodisciplina where IdTurma = '$turma' and IdAluno = '$aluno' and (SituacaoAtual='Cursando' or SituacaoAtual like 'Recuperação%')");
$res2 = $query->fetchAll(PDO::FETCH_ASSOC);
$total_disciplinas_cursando = count($res2);

if ($total_disciplinas_cursando == 0) {
	require('atualizar-situacao-turma.php');
}

