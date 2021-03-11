<?php 
require_once("../conexao.php"); 
//require_once("../config.php"); 
$id_ano = $_GET['id_ano'];
$id_serie = $_GET['id_serie'];

$query = $pdo->query("SELECT * FROM tbgradecurricular where IdSerie = '$id_serie' and IdPeriodo = '$id_ano'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);


//$con = mysqli_connect($servidor,$usuario,$senha,$banco);

//if (!$con) {
  //die('Não conectou com o banco: ' . mysqli_error($con));

//}

//mysqli_select_db($con,"ajax_demo");
//$sql="SELECT * FROM tbgradecurricular where IdSerie = '$id_serie' and IdPeriodo = '$id_ano'";
//$result = mysqli_query($con,$sql);
for ($i=0; $i < count($res); $i++) { 
	foreach ($res[$i] as $key => $value) {
	}

	echo $res[$i]['IdDisciplina']." ";
}


//while($row = mysqli_fetch_array($result)) {


 // echo  $row['IdDisciplina'];

//}



	?>