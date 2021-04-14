<?php 
require_once("../../conexao.php"); 

@session_start();
$cpf_usuario = @$_SESSION['cpf_usuario'];



$query = $pdo->query("SELECT * FROM tbaluno where RegistroNascimentoNumero = '$cpf_usuario' order by IdAluno asc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_aluno = $res[0]['IdAluno'];

$turma = @$_POST['turma'];
$periodo = @$_POST['periodo'];
$disciplina = @$_POST['disciplina'];
$numerofase = @$_POST['numerofase'];

echo " <small>
<table class='table table-hover '>
<thead class='table-primary'>
<tr class='text-dark'>
<th scope='col'>Aula</th>
<th scope='col'>Nome</th>
<th scope='col'>Data</th>
<th scope='col'>Chamada</th>



</tr>
</thead>
<tbody>";

$query = $pdo->query("SELECT * FROM aulas where turma = '$turma' and periodo = '$periodo' and id_disciplina = '$disciplina' and NumeroFase = '$numerofase' order by id asc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i=0; $i < count($res); $i++) { 
	foreach ($res[$i] as $key => $value) {
	}

	$nome = $res[$i]['nome'];
	$descricao = $res[$i]['descricao'];
	$arquivo = $res[$i]['arquivo'];
	$id_aula = $res[$i]['id'];
  $data = $res[$i]['data'];

  $dataF = implode('/', array_reverse(explode('-', $data)));



  $query2 = $pdo->query("SELECT * FROM chamadas where turma = '$turma' and aluno = '$id_aluno' and aula = '$id_aula' ");
  $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
  $presenca = @$res2[0]['presenca'];
  $classe_chamada = 'text-danger';
  

  if($presenca == 'P'){
    $frequencia = "Presente";
    $classe_chamada = 'text-success';
  }else if($presenca == ""){
    $frequencia = "Professor não realizou a chamada!";
    $classe_chamada = 'text-warning';
    
  }else{
    $frequencia = "Faltou";
    $classe_chamada = 'text-danger';
  }

  echo "<tr class='table-light'>
    <td>". ($i+1)."</td>
    <td>".$nome."</td>
    <td>".$dataF."</td>
    <td class='".$classe_chamada."'>".$frequencia."</td>
    
  

  </tr>";




}
?>

