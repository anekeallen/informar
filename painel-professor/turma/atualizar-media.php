<?php  
require_once("../../config.php");

date_default_timezone_set('America/Sao_Paulo');

try {
	$pdo1 = new PDO("mysql:dbname=$banco;host=$servidor;charset=utf8", "$usuario", "$senha");
	
} catch (Exception $e) {
	echo "Erro ao conectar com o banco de dados! " . $e;
}

$turma = $_POST['turma'];
$disciplina = $_POST['iddisciplina'];
$aluno = $_POST['idaluno'];
$periodo = $_POST['periodo'];

$query = $pdo1->query("SELECT * FROM tbturma where IdTurma = '$turma'");
$res01 = $query->fetchAll(PDO::FETCH_ASSOC);
$id_serie = $res01[0]['IdSerie'];

//Verificar se ja existem 3 fases cadastradas com notas e fazer a média
//$query = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$periodo' and IdSerie = '$id_serie' and (NumeroFase = 1 or NumeroFase = 2 or NumeroFase = 3)");
//$res1 = $query->fetchAll(PDO::FETCH_ASSOC);

$notaFase = array();


$query2 = $pdo1->query("SELECT * FROM tbfasenotaaluno where IdTurma = '$turma' and IdAluno = '$aluno' and IdDisciplina = '$disciplina' order by id asc LIMIT 3");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$contador_de_fases = 0;
for ($i=0; $i < count($res2); $i++) { 
	foreach ($res2[$i] as $key => $value) {
	}

	$notaFase[] = $res2[$i]['NotaFase'];
	$contador_de_fases = $contador_de_fases + 1;
	
}

if ($contador_de_fases == 3) {
	

	$mediaParcial=0;
	for ($i=0; $i < count($notaFase); $i++) {

		$mediaParcial = $mediaParcial + $notaFase[$i];
	}

	$mediaParcial = $mediaParcial / 3 ;

	$mediaParcialF = number_format($mediaParcial, 2, '.', '');

}

$query = $pdo1->query("SELECT * FROM tbfasenota where IdPeriodo = '$periodo' and IdSerie = '$id_serie' and NumeroFase = 4");
$res5 = $query->fetchAll(PDO::FETCH_ASSOC);

$id_fase4 = $res5[0]['IdFaseNota'];


$query5 = $pdo1->query("SELECT * FROM tbfasenotaaluno where IdTurma = '$turma' and IdAluno = '$aluno' and IdDisciplina = '$disciplina' and IdFaseNota = '$id_fase4'");
$res5 = $query5->fetchAll(PDO::FETCH_ASSOC);

if (count($res5) == 0) {

}else{


	$pdo1->query("UPDATE tbfasenotaaluno SET Nota01 = '$notaFase[0]', Nota02 = '$notaFase[1]', Nota03 = '$notaFase[2]', NotaFase = '$mediaParcialF' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno' and IdFaseNota = '$id_fase4'");


}


if (isset($mediaParcialF)) {

	if ($mediaParcialF >= $media_aprovacao) {

		$pdo1->query("UPDATE tbsituacaoalunodisciplina SET SituacaoAtual = 'Aprovado' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno'");


		//Verificar o id da fase nota do NumeroFase = 6 e NumeroFase = 8
		$query = $pdo1->query("SELECT * FROM tbfasenota where IdPeriodo = '$periodo' and IdSerie = '$id_serie' and (NumeroFase = 6 or NumeroFase = 8)");
		$res55 = $query->fetchAll(PDO::FETCH_ASSOC);
		for ($i=0; $i < count($res55); $i++) { 
			foreach ($res55[$i] as $key => $value) {
			}

			$id_fase_aprovacao = $res55[$i]['IdFaseNota'];

			$query2 = $pdo1->query("SELECT * FROM tbfasenotaaluno where IdTurma = '$turma' and IdAluno = '$aluno' and IdDisciplina = '$disciplina' and IdFaseNota = '$id_fase_aprovacao'");
			$res = $query2->fetchAll(PDO::FETCH_ASSOC);

			if ((count($res) == 0) and ($id_fase_aprovacao != 0) and $id_fase_aprovacao != null) {

				$pdo1->query("INSERT INTO tbfasenotaaluno SET IdTurma = '$turma', IdDisciplina = '$disciplina', IdAluno = '$aluno', IdFaseNota = '$id_fase_aprovacao', NotaFase = '$mediaParcialF'");

			}else{

				$pdo1->query("UPDATE tbfasenotaaluno SET NotaFase = '$mediaParcialF' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno' and IdFaseNota = '$id_fase_aprovacao'");

			}


			$pdo1->query("UPDATE tbsituacaoalunodisciplina SET IdFaseNotaAtual = '$id_fase_aprovacao' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno'");

		}



	}else if($mediaParcialF < $media_reprovacao){

		$pdo1->query("UPDATE tbsituacaoalunodisciplina SET SituacaoAtual = 'Reprovado' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno'");

		//Verificar o id da fase nota do NumeroFase = 6 e NumeroFase = 8
		$query = $pdo1->query("SELECT * FROM tbfasenota where IdPeriodo = '$periodo' and IdSerie = '$id_serie' and (NumeroFase = 6 or NumeroFase = 8)");
		$res55 = $query->fetchAll(PDO::FETCH_ASSOC);
		for ($i=0; $i < count($res55); $i++) { 
			foreach ($res55[$i] as $key => $value) {
			}

			$id_fase_reprovado = $res55[$i]['IdFaseNota'];

			$query2 = $pdo1->query("SELECT * FROM tbfasenotaaluno where IdTurma = '$turma' and IdAluno = '$aluno' and IdDisciplina = '$disciplina' and IdFaseNota = '$id_fase_reprovado'");
			$res = $query2->fetchAll(PDO::FETCH_ASSOC);

			if ((count($res) == 0) and ($id_fase_reprovado != 0) and $id_fase_reprovado != null) {

				$pdo1->query("INSERT INTO tbfasenotaaluno SET IdTurma = '$turma', IdDisciplina = '$disciplina', IdAluno = '$aluno', IdFaseNota = '$id_fase_reprovado', NotaFase = '$mediaParcialF'");

			}else{

				$pdo1->query("UPDATE tbfasenotaaluno SET NotaFase = '$mediaParcialF' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno' and IdFaseNota = '$id_fase_reprovado'");

			}


			$pdo1->query("UPDATE tbsituacaoalunodisciplina SET IdFaseNotaAtual = '$id_fase_reprovado' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno'");

		}
	}else{


		//Verificar o id da fase nota do NumeroFase = 5
		$query = $pdo1->query("SELECT * FROM tbfasenota where IdPeriodo = '$periodo' and IdSerie = '$id_serie' and (NumeroFase = 5 or NumeroFase = 6 or NumeroFase = 7 or NumeroFase = 8)");
		$res55 = $query->fetchAll(PDO::FETCH_ASSOC);

		for ($i=0; $i < count($res55); $i++) { 
			foreach ($res55[$i] as $key => $value) {
			}

			$id_fases = $res55[$i]['IdFaseNota'];
			$id_fase5 = $res55[0]['IdFaseNota'];

			$query11 = $pdo1->query("SELECT * FROM tbfasenotaaluno where IdTurma = '$turma' and IdAluno = '$aluno' and IdDisciplina = '$disciplina' and IdFaseNota = '$id_fases'");
			$res = $query11->fetchAll(PDO::FETCH_ASSOC);

			if ((count($res) == 0) and ($id_fases != 0) and ($id_fases != null)) {

				$pdo1->query("INSERT INTO tbfasenotaaluno SET IdTurma = '$turma', IdDisciplina = '$disciplina', IdAluno = '$aluno', IdFaseNota = '$id_fases'");

			}

			$pdo1->query("UPDATE tbsituacaoalunodisciplina SET SituacaoAtual = 'Recuperação Anual', IdFaseNotaAtual = '$id_fase5' where IdTurma = '$turma' and IdDisciplina = '$disciplina' and IdAluno = '$aluno'");


		}

	}

}



?>