<?php 
require_once("../../conexao.php"); 

$turma = @$_POST['turma'];
$periodo = @$_POST['periodo'];
$aluno = @$_POST['aluno'];
$disciplina = @$_POST['iddisciplina'];
$numerofase = @$_POST['numerofase'];

$query = $pdo->query("SELECT * FROM tbturma where IdTurma = '$turma'");
$res1 = $query->fetchAll(PDO::FETCH_ASSOC);
$id_serie = $res1[0]['IdSerie'];


$query = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$periodo' and IdSerie = '$id_serie' and NumeroFase = '$numerofase' ");
$res2 = $query->fetchAll(PDO::FETCH_ASSOC);
$id_fase_nota = @$res2[0]['IdFaseNota'];



$query = $pdo->query("SELECT * FROM tbfasenotaaluno where IdTurma = '$turma' and IdAluno = '$aluno' and IdDisciplina = '$disciplina' and IdFaseNota = '$id_fase_nota'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);


$nota_rec = @$res[0]['NotaFase'];



$nota_recF = number_format($nota_rec, 2, ',', '.');





?>



<script type="text/javascript">

	//listarDadosNotas();
	
	var nota_rec = "<?=$nota_rec?>";
	var total_nota_rec = "<?=$nota_recF?>";
	
	
	document.getElementById('nota_rec').value = nota_rec;
	
	$("#total_notas_rec").text(total_nota_rec);



</script>