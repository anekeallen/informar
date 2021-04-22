<?php 



$query = $pdo->query("SELECT * FROM tbturma where IdTurma = '$turma'");
$res1 = $query->fetchAll(PDO::FETCH_ASSOC);
$id_serie = $res1[0]['IdSerie'];
$id_periodo = $res1[0]['IdPeriodo'];



$query_resp = $pdo->query("SELECT * FROM tbserie where IdSerie = '$id_serie' ");
$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);                    
$codigo_serie = $res_resp[0]['CodigoSerie'];
$id_curso = $res_resp[0]['IdCurso'];

$query_r3 = $pdo->query("SELECT * FROM tbcurso where IdCurso = '".$id_curso."' ");
$res_r3 = $query_r3->fetchAll(PDO::FETCH_ASSOC);

$nome_curso = $res_r3[0]['NomeCurso'];


$query_resp = $pdo->query("SELECT * FROM tbperiodo where IdPeriodo = '$id_periodo' ");
$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC); 
$ano = $res_resp[0]['AnoConclusao'];
$dias_letivos = $res_resp[0]['DiasLetivos'];

$query = $pdo->query("SELECT * FROM tbalunoturma where IdTurma = '$turma' and IdAluno = '$aluno'");
$res1 = $query->fetchAll(PDO::FETCH_ASSOC);

$id_situacao = $res1[0]['IdSituacaoAlunoTurma'];

$query = $pdo->query("SELECT * FROM tbsituacaoalunoturma where IdSituacaoAlunoTurma = '$id_situacao'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$situacao_turma = $res[0]['SituacaoAlunoTurma'];

//Verificar se ja existe cadastro do historico da turma, caso nao, dar um insert!

$query = $pdo->query("SELECT * FROM tbhistorico where AnoConclusao = '$ano' and CodigoSerie = '$codigo_serie' and IdAluno = '$aluno'");

$res = $query->fetchAll(PDO::FETCH_ASSOC); 

if (count($res) == 0) {
	$pdo->query("INSERT INTO tbhistorico SET IdAluno = '$aluno', CodigoSerie = '$codigo_serie', AnoConclusao = '$ano', ResultadoFinal = '$situacao_turma', DiasLetivos = '$dias_letivos'");

}else{
	$pdo->query("UPDATE tbhistorico SET ResultadoFinal = '$situacao_turma' where CodigoSerie = '$codigo_serie' and IdAluno = '$aluno'");
}

$query5 = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$id_periodo' and IdSerie = '$id_serie' and NumeroFase = 8");
$res5 = $query5->fetchAll(PDO::FETCH_ASSOC);
$id_fase = $res5[0]['IdFaseNota'];


//Atualizar o historico de notas

$query = $pdo->query("SELECT * FROM tbgradecurricular where IdSerie = '$id_serie' and IdPeriodo = '$id_periodo'");
$res22 = $query->fetchAll(PDO::FETCH_ASSOC);



for ($i=0; $i < count($res22); $i++) { 
	foreach ($res22[$i] as $key => $value) {
	}

	
	$id_disciplina = $res22[$i]['IdDisciplina'];

	$query_r = $pdo->query("SELECT * FROM tbdisciplina where IdDisciplina = '$id_disciplina'");
	$res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);


	if ($nome_curso == 'Ensino Fundamental') {
		$carga_horaria_disciplina = $res_r[0]['CH_Fundamental1'];
	}else{
		$carga_horaria_disciplina = $res_r[0]['CH_Fundamental2'];
	}

	$query12 = $pdo->query("SELECT * FROM tbsituacaoalunodisciplina where IdTurma = '$turma' and IdAluno = '$aluno' and IdDisciplina = '$id_disciplina'");
	$res33 = $query12->fetchAll(PDO::FETCH_ASSOC);

	$situacao_disc = $res33[0]['SituacaoAtual'];

	$query3 = $pdo->query("SELECT * FROM tbhistoriconotas where CodigoSerie = '$codigo_serie' and IdAluno = '$aluno' and IdDisciplina = '$id_disciplina' and AnoConclusao = '$ano'");
	$res_ver = $query3->fetchAll(PDO::FETCH_ASSOC);

	

	
	$query2 = $pdo->query("SELECT * FROM tbfasenotaaluno where IdTurma = '$turma' and IdAluno = '$aluno' and IdDisciplina = '$id_disciplina' and IdFaseNota = '$id_fase'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);


	$notafinal = $res2[0]['NotaFase'];
	$quantFaltas = $res2[0]['Faltas'];

	if (empty($res_ver)) {

		

		$pdo->query("INSERT INTO tbhistoriconotas SET CodigoSerie = '$codigo_serie', IdAluno = '$aluno', IdDisciplina = '$id_disciplina', NotaFinal = '$notafinal', CargaHorariaAnual = '$carga_horaria_disciplina', QuantidadeFaltasAnual = '$quantFaltas', ResultadoFinal = '$situacao_disc' , AnoConclusao = '$ano'");


		
	}else{

		$pdo->query("UPDATE tbhistoriconotas SET NotaFinal = '$notafinal', CargaHorariaAnual = '$carga_horaria_disciplina', QuantidadeFaltasAnual = '$quantFaltas', ResultadoFinal = '$situacao_disc'  where CodigoSerie = '$codigo_serie' and IdAluno = '$aluno' and IdDisciplina = '$id_disciplina' and AnoConclusao = '$ano'");

		
	}

	


}



