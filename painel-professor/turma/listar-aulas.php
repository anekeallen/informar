<?php 
require_once("../../conexao.php"); 

$turma = @$_POST['turma'];
$periodo = @$_POST['periodo'];
$fase = @$_POST['fase'];
$id_disciplina = @$_POST['id_disciplina'];


$query = $pdo->query("SELECT * FROM aulas where turma = '$turma' and periodo = '$periodo' and NumeroFase = '$fase' and id_disciplina = '$id_disciplina' order by id asc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i=0; $i < count($res); $i++) { 
	foreach ($res[$i] as $key => $value) {
	}

	$nome = $res[$i]['nome'];
	$descricao = $res[$i]['descricao'];
	//$disciplina = $res[$i]['id_disciplina'];
	$data = $res[$i]['data'];
	$arquivo = $res[$i]['arquivo'];
	$id_aula = $res[$i]['id'];

	$dataF = implode('/', array_reverse(explode('-', $data)));

	$query1 = $pdo->query("SELECT * FROM tbdisciplina where IdDisciplina = '$id_disciplina'");
	$res1 = $query1->fetchAll(PDO::FETCH_ASSOC);
	$nome_disc = $res1[0]['NomeDisciplina'];

	echo 'Aula '. ($i+1) . ' - '.$nome_disc.' - '. $nome .' - '.$dataF.' <a onclick="deletarAula('.$id_aula.')" href="#" title="deletar aula"><i class="far fa-trash-alt ml-2 text-danger"></i></a> <a onclick="upload('.$id_aula.')" href="#" title="Carregar Arquivo"><i class="far fa-file ml-2 text-primary"></i></a>';

	if($arquivo != ""){
		echo '<span class="ml-1" ><a href="../img/arquivos-aula/'.$arquivo.'" target="_blank" class="text-primary"> Ver Arquivo </a> <br></span>';
	}else{ 
		echo '<br>';
	}

}
?>

