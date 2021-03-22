<?php 
require_once("../../conexao.php"); 

$nome = $_POST['nome-cat'];
$sigla = $_POST['sigla-cat'];
$informada = $_POST['informado-cat'];


//$antigo = $_POST['antigo'];

$id = $_POST['txtid2'];

if($nome == ""){
	echo 'O Nome da Fase é Obrigatório!';
	exit();
}

if($sigla == ""){
	echo 'A sigla da Fase é Obrigatória!';
	exit();
}






if($id == ""){
	$res = $pdo->prepare("INSERT INTO tbfases_ano SET NomeFase = :nome, CabecBoletim = :sigla, FaseInformada = :informada");	


}else{
	$res = $pdo->prepare("UPDATE tbdisciplina SET NomeFase = :nome, CabecBoletim = :sigla, FaseInformada = :informada WHERE NumeroFase = '$id'");

	
	
}

$res->bindValue(":nome", $nome);
$res->bindValue(":sigla", $sigla);
$res->bindValue(":informada", $informada);





$res->execute();


echo 'Salvo com Sucesso!!';

?>