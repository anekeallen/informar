<?php 
require_once("../../conexao.php"); 

$nome = $_POST['nome-cat'];
$sigla = $_POST['sigla-cat'];


$antigo = $_POST['antigo'];

$id = $_POST['txtid2'];

if($nome == ""){
	echo 'O Nome da Disciplina é Obrigatório!';
	exit();
}



//VERIFICAR SE O REGISTRO JÁ EXISTE NO BANCO
if($antigo != $nome){
	$query = $pdo->query("SELECT * FROM tbdisciplina where NomeDisciplina = '$nome' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'A Disciplina já está Cadastrada!';
		exit();
	}
}




if($id == ""){
	$res = $pdo->prepare("INSERT INTO tbdisciplina SET NomeDisciplina = :nome, SiglaDisciplina = :sigla");	


}else{
	$res = $pdo->prepare("UPDATE tbdisciplina SET NomeDisciplina = :nome, SiglaDisciplina = :sigla WHERE IdDisciplina = '$id'");

	
	
}

$res->bindValue(":nome", $nome);
$res->bindValue(":sigla", $sigla);





$res->execute();


echo 'Salvo com Sucesso!!';

?>