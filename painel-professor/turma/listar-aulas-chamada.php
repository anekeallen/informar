<?php 
require_once("../../conexao.php"); 

$turma = @$_POST['turma'];
$periodo = @$_POST['periodo'];
$fase = @$_POST['fase'];
$disciplina = @$_POST['id_disciplina'];


$query = $pdo->query("SELECT * FROM aulas where turma = '$turma' and periodo = '$periodo' and NumeroFase = '$fase' and id_disciplina = '$disciplina' order by id asc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

if (count($res) == 0) {
	echo "<span class='text-danger'>Não existem aulas cadastradas para realizar a chamada. Insira uma aula!</span>";

	exit();
}

echo " <small>
<table class='table table-bordered'>
<thead>
<tr>
<th scope='col'>Aula</th>
<th scope='col'>Nome</th>
<th scope='col'>Data</th>
<th scope='col'>Chamada</th>



</tr>
</thead>
<tbody>";

for ($i=0; $i < count($res); $i++) { 
	foreach ($res[$i] as $key => $value) {
	}

	$nome = $res[$i]['nome'];
	$descricao = $res[$i]['descricao'];
	$arquivo = $res[$i]['arquivo'];
	$id_aula = $res[$i]['id'];
	$data = $res[$i]['data'];


	$data_venc = implode('/', array_reverse(explode('-', $data)));


	 $query2 = $pdo->query("SELECT * FROM chamadas where aula = '$id_aula' ");
     $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
     

	

	echo "<tr>
    <td>".($i+1)."</td>
    <td>".$nome."</td>
    <td>".$data_venc."</td>
    <td class=''><a href='index.php?pag=turma&funcao=fazerchamada&id=". $turma ."&id_periodo=".$periodo ."&id_aula=". $id_aula ."&id_disciplina=". $disciplina ."&numero_fase=". $fase ."' title='Fazer Chamada'><i class='far fa-calendar ml-2 text-info'></i></a>";

	
	if(@count($res2) > 0){
		echo '<i title="Chamada Realizada" class="fas fa-check ml-2 text-success"></i><br>';
	}   	

	echo '
    </td>
    
  

  </tr>';

}
	?>

