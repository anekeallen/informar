<?php 
require_once("../../conexao.php"); 

$sala = $_POST['sala-cat'];
$descricao = $_POST['descricao-cat'];

$antigo = $_POST['antigo'];

$id = $_POST['txtid2'];

if($sala == ""){
	echo 'A Sala é Obrigatória!';
	exit();
}



//VERIFICAR SE O REGISTRO JÁ EXISTE NO BANCO
if($antigo != $sala){
	$query = $pdo->query("SELECT * FROM salas where sala = '$sala' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'A Sala já está Cadastrada!';
		exit();
	}
}




if($id == ""){
	$res = $pdo->prepare("INSERT INTO salas SET sala = :sala, descricao = :descricao");	


}else{
	$res = $pdo->prepare("UPDATE salas SET sala = :sala, descricao = :descricao WHERE id = '$id'");

	
	
}

$res->bindValue(":sala", $sala);
$res->bindValue(":descricao", $descricao);





$res->execute();


echo 'Salvo com Sucesso!!';

?>