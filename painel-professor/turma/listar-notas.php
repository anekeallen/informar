<?php 
require_once("../../conexao.php"); 

$turma = @$_POST['turma'];
$periodo = @$_POST['periodo'];
$aluno = @$_POST['aluno'];
$disciplina = @$_POST['disciplina'];
$numerofase = @$_POST['numerofase'];

$query = $pdo->query("SELECT * FROM tbturma where IdTurma = '$turma'");
$res1 = $query->fetchAll(PDO::FETCH_ASSOC);
$id_serie = $res1[0]['IdSerie'];


$query = $pdo->query("SELECT * FROM tbfasenota where IdPeriodo = '$periodo' and IdSerie = '$id_serie' and NumeroFase = '$numerofase' ");
$res2 = $query->fetchAll(PDO::FETCH_ASSOC);
$id_fase_nota = @$res2[0]['IdFaseNota'];

$query = $pdo->query("SELECT * FROM tbfasenotaaluno where IdTurma = '$turma' and IdAluno = '$aluno' and IdDisciplina = '$disciplina' and IdFaseNota = '$id_fase_nota'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);


$nota1 = @$res[0]['Nota01'];
$nota2 = @$res[0]['Nota02'];
$nota3 = @$res[0]['Nota03'];

$nota_maxima1F = number_format($nota_maxima1, 2, ',', '.');
$nota_maxima2F = number_format($nota_maxima2, 2, ',', '.');
$nota_maxima3F = number_format($nota_maxima3, 2, ',', '.');

$nota1F = number_format($nota1, 2, ',', '.');
$nota2F = number_format($nota2, 2, ',', '.');
$nota3F = number_format($nota3, 2, ',', '.');


	//$id_nota = $res[0]['id'];

$total_nota_fase = $nota1 + $nota2 + $nota3;

$total_nota_faseF = number_format($total_nota_fase, 2, ',', '.');

?>



<script type="text/javascript">

	//listarDadosNotas();
	var total_notas = "<?=$total_nota_faseF?>";
	var nota1 = "<?=$nota1?>";
	var nota2 = "<?=$nota2?>";
	var nota3 = "<?=$nota3?>";
	
	document.getElementById('nota1').value = nota1;
	document.getElementById('nota2').value = nota2;
	document.getElementById('nota3').value = nota3;
	$("#total_notas").text(total_notas);



</script>