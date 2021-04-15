<?php 
require_once("../../conexao.php"); 

$turma = @$_POST['turma'];
$periodo = @$_POST['periodo'];
$fase = @$_POST['fase'];
$id_disciplina = @$_POST['id_disciplina'];


$query = $pdo->query("SELECT * FROM aulas where turma = '$turma' and periodo = '$periodo' and NumeroFase = '$fase' and id_disciplina = '$id_disciplina' order by id asc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

if (count($res) == 0) {
	echo "<span class='text-danger'>Não existem aulas cadastradas. Insira uma aula!</span>";

	exit();
}

echo " <small>
<table class='table  table-hover'>
<thead>
<tr class='table-info text-dark'>
<th scope='col'>Aula</th>
<th scope='col'>Nome</th>
<th scope='col'>Data</th>
<th scope='col'>Arquivo</th>
<th scope='col'>Ações</th>




</tr>
</thead>
<tbody>";

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

	

	echo "<tr>
    <td>".($i+1)."</td>
    <td>".$nome."</td>
    <td>".$dataF."</td>
    <td>";

    if($arquivo != ""){
		echo '<span class="ml-1" ><a href="../img/arquivos-aula/'.$arquivo.'" target="_blank" class="text-primary"> Ver Arquivo </a> <br></span>';
	} 

	echo "



    </td>

    <td class=''><a onclick='deletarAula(".$id_aula.")' href='#' title='Deletar Aula'><i class='far fa-trash-alt ml-2 text-danger'></i></a> <a onclick='upload(".$id_aula.")' href='#' title='Enviar Arquivo'><i class='far fa-file ml-2 text-primary'></i></a>

    </td>

   

  </tr>";


}
?>

