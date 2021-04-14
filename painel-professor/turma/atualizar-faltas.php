<?php  
  
//Pega idfasenota para add o id certo da fase da nota, assim sabendo se eh 1ºtrimestre, 2º ou 3º...
$query = $pdo->query("SELECT * FROM tbturma where IdTurma = '$id_turma_chamada'");
$res01 = $query->fetchAll(PDO::FETCH_ASSOC);
$id_serie = $res01[0]['IdSerie'];

$query = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$id_periodo_chamada' and NumeroFase = '$numerofase_chamada' and IdSerie = '$id_serie'");
$res1 = $query->fetchAll(PDO::FETCH_ASSOC);

$idfasenota = $res1[0]['IdFaseNota'];

  // Salvar aulas do trimestre
$total_faltas = 0;

$query = $pdo->query("SELECT * FROM aulas where turma = '$id_turma_chamada' and periodo = '$id_periodo_chamada' and NumeroFase = '$numerofase_chamada' and id_disciplina = '$disciplina_chamada'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$total_aulas = count($res);

$pdo->query("UPDATE tbfasenotaaluno SET  QuantAulasDadas = '$total_aulas' where IdTurma = '$id_turma_chamada' and IdDisciplina = '$disciplina_chamada' and IdFaseNota = '$idfasenota'");


for ($i=0; $i < count($res); $i++) { 
  foreach ($res[$i] as $key => $value) {
  }
  $id_aula = $res[$i]['id'];

  $query1 = $pdo->query("SELECT * FROM chamadas where turma = '$id_turma_chamada' and periodo = '$id_periodo_chamada' and NumeroFase = '$numerofase_chamada' and aluno = '$id_aluno_chamada' and presenca = 'F' and aula = '$id_aula'");
  $res1 = $query1->fetchAll(PDO::FETCH_ASSOC);

  $total_faltas = $total_faltas + count($res1);
  

}
  //salvar faltas dos trimestres FALTA DEFINIR O ERRO DAS FALTAS  

$pdo->query("UPDATE tbfasenotaaluno SET  Faltas = '$total_faltas' where IdTurma = '$id_turma_chamada' and IdDisciplina = '$disciplina_chamada' and IdFaseNota = '$idfasenota' and IdAluno = '$id_aluno_chamada'");



?>