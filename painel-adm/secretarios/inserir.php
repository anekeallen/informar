<?php 
require_once("../../conexao.php"); 

$nome = $_POST['nome-cat'];
$telefone = $_POST['telefone-cat'];
$cpf = $_POST['cpf-cat'];
$email = $_POST['email-cat'];
$endereco = $_POST['endereco-cat'];

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
	$query = $pdo->query("SELECT * FROM secretarios where cpf = '$cpf' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);

	$query = $pdo->query("SELECT * FROM usuarios where cpf = '$cpf' ");
	$res3 = $query->fetchAll(PDO::FETCH_ASSOC);

	$total_reg2 = @count($res3);

	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'O CPF já está Cadastrado!';
		exit();
	}

	if($total_reg2 > 0){
		echo 'O CPF já cadastrado para algum usuário!';
		exit();
	}
}


//VERIFICAR SE O REGISTRO COM MESMO EMAIL JÁ EXISTE NO BANCO
if($antigo2 != $email){
	$query = $pdo->query("SELECT * FROM secretarios where email = '$email' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);

	$query = $pdo->query("SELECT * FROM usuarios where email = '$email' ");
	$res3 = $query->fetchAll(PDO::FETCH_ASSOC);

	$total_reg = @count($res);

	$total_reg2 = @count($res3);

	if($total_reg > 0){
		echo 'O Email já está Cadastrado!';
		exit();
	}

	if($total_reg2 > 0){
		echo 'O Email já cadastrado para algum usuário!';
		exit();
	}
}


if($id == ""){
	$res = $pdo->prepare("INSERT INTO secretarios SET nome = :nome, cpf = :cpf, email = :email, endereco = :endereco, telefone = :telefone");	

	$res2 = $pdo->prepare("INSERT INTO usuarios SET nome = :nome, cpf = :cpf, email = :email, senha = :senha, nivel = :nivel");	
	$res2->bindValue(":senha", '123');
	$res2->bindValue(":nivel", 'secretaria');

}else{
	$res = $pdo->prepare("UPDATE secretarios SET nome = :nome, cpf = :cpf, email = :email, endereco = :endereco, telefone = :telefone WHERE id = '$id'");

	$res2 = $pdo->prepare("UPDATE usuarios SET nome = :nome, cpf = :cpf, email = :email WHERE cpf = '$antigo'");	
	
}

$res->bindValue(":nome", $nome);
$res->bindValue(":cpf", $cpf);
$res->bindValue(":telefone", $telefone);
$res->bindValue(":email", $email);
$res->bindValue(":endereco", $endereco);

$res2->bindValue(":nome", $nome);
$res2->bindValue(":cpf", $cpf);
$res2->bindValue(":email", $email);


$res->execute();
$res2->execute();

echo 'Salvo com Sucesso!!';

?>