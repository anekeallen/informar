<?php 

require_once("../../conexao.php"); 

$id = $_POST['id_periodoRenovar'];

$id_antigo = $_POST['id_periodoRenovar_antigo'];

if ($id == $id_antigo) {
	echo "Para renovar a grade curricular, primeiro cadastre o novo ano letivo!";
	exit();
}

$query = $pdo->query("SELECT * FROM tbgradecurricular where IdPeriodo = '$id_antigo'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i=0; $i < count($res); $i++) { 
	foreach ($res[$i] as $key => $value) {
	}

	$id_serie = $res[$i]['IdSerie'];
	$id_disciplina = $res[$i]['IdDisciplina'];


	$pdo->query("INSERT INTO tbgradecurricular SET IdSerie = '$id_serie', IdDisciplina = '$id_disciplina', IdPeriodo = '$id'");




}

echo 'Renovado com Sucesso!!';


	?>