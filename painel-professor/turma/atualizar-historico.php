<?php 

include_once ('../../config.php');


$query = $pdo->query("SELECT * FROM tbturma where IdTurma = '$turma'");
$res1 = $query->fetchAll(PDO::FETCH_ASSOC);
$id_serie = $res1[0]['IdSerie'];
$id_periodo = $res1[0]['IdPeriodo'];

$query_resp = $pdo->query("SELECT * FROM tbserie where IdSerie = '$id_serie' ");
$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);                    
$codigo_serie = $res_resp[0]['CodigoSerie'];


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

//Atualizar o historico de notas

$query = $pdo->query("SELECT * FROM tbgradecurricular where IdSerie = '$id_serie' and IdPeriodo = '$id_periodo'");
$res2 = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i=0; $i < count($res2); $i++) { 
	foreach ($res2[$i] as $key => $value) {
	}
	$id_disciplina = $res2[$i]['IdDisciplina'];

	

	$res = $pdo->prepare("INSERT INTO tbgradecurricular SET IdSerie = :idserie, IdDisciplina = :id_disciplina, IdPeriodo = :idperiodo");

	$res->bindValue(":idserie", $id_serie);
	$res->bindValue(":id_disciplina", $id_disciplina);
	$res->bindValue(":idperiodo", $id_ano);





	$res->execute();


}





