<?php 
require_once("../../conexao.php"); 


$serie = $_POST['serie-cat'];
$id_prox_serie = @$_POST['proxima_serie-cat'];
$id_curso = $_POST['curso-cat'];
$codigo_serie = @$_POST['codigo-cat'];
$servico = @$_POST['servico-cat'];

$antigo = $_POST['antigo'];

$id = $_POST['txtid2'];

if($serie == ""){
	echo 'A Série é Obrigatória!';
	exit();
}



//VERIFICAR SE O REGISTRO JÁ EXISTE NO BANCO
if($antigo != $serie){
	$query = $pdo->query("SELECT * FROM tbserie where NomeSerie = '$serie' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'A série já está Cadastrada!';
		exit();
	}
}




if($id == ""){
	$res = $pdo->prepare("INSERT INTO tbserie SET NomeSerie = :NomeSerie, IdProximaSerie = :IdProximaSerie, IdCurso = :IdCurso, CodigoSerie = :CodigoSerie, IdServicoMensalidade = :idservico");	


}else{
	$res = $pdo->prepare("UPDATE tbserie SET NomeSerie = :NomeSerie, IdProximaSerie = :IdProximaSerie, IdCurso = :IdCurso, CodigoSerie = :CodigoSerie, IdServicoMensalidade = :idservico WHERE IdSerie = '$id'");

	
	
}

$res->bindValue(":IdProximaSerie", $id_prox_serie);
$res->bindValue(":IdCurso", $id_curso);
$res->bindValue(":CodigoSerie", $codigo_serie);
$res->bindValue(":NomeSerie", $serie);
$res->bindValue(":idservico", $servico);





$res->execute();


echo 'Salvo com Sucesso!!';

?>