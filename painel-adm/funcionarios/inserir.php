<?php 
require_once("../../conexao.php"); 

$nome = $_POST['nome-cat'];
$telefone = $_POST['telefone-cat'];
$cpf = $_POST['cpf-cat'];
$email = $_POST['email-cat'];
$endereco = $_POST['endereco-cat'];
$cargo = $_POST['cargo-cat'];

$antigo = $_POST['antigo'];
$antigo2 = $_POST['antigo2'];
$id = $_POST['txtid2'];

if($nome == ""){
	echo 'O Nome é Obrigatório!';
	exit();
}

if($email == ""){
	echo 'O Email é Obrigatório!';
	exit();
}

if($cpf == ""){
	echo 'O CPF é Obrigatório!';
	exit();
}

//VERIFICAR SE O REGISTRO JÁ EXISTE NO BANCO
if($antigo != $cpf){
	$query = $pdo->query("SELECT * FROM funcionarios where cpf = '$cpf' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'O CPF já está Cadastrado!';
		exit();
	}
}


//VERIFICAR SE O REGISTRO COM MESMO EMAIL JÁ EXISTE NO BANCO
if($antigo2 != $email){
	$query = $pdo->query("SELECT * FROM funcionarios where email = '$email' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'O Email já está Cadastrado!';
		exit();
	}
}


if($id == ""){
	$res = $pdo->prepare("INSERT INTO funcionarios SET nome = :nome, cpf = :cpf, email = :email, endereco = :endereco, telefone = :telefone, cargo = :cargo");	


}else{
	$res = $pdo->prepare("UPDATE funcionarios SET nome = :nome, cpf = :cpf, email = :email, endereco = :endereco, telefone = :telefone, cargo = :cargo  WHERE id = '$id'");

	
	
}

$res->bindValue(":nome", $nome);
$res->bindValue(":cpf", $cpf);
$res->bindValue(":telefone", $telefone);
$res->bindValue(":email", $email);
$res->bindValue(":cargo", $cargo);
$res->bindValue(":endereco", $endereco);




$res->execute();


echo 'Salvo com Sucesso!!';

?>