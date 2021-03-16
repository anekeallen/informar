<?php 
require_once("../conexao.php"); 

$nome = $_POST['nome_usu'];
$cpf = $_POST['cpf_usu'];
$login = $_POST['login_usu'];
$senha = $_POST['senha_usu'];

$antigo = $_POST['antigo_usu'];
$id = $_POST['id_usu'];

if($nome == ""){
	echo 'O nome é obrigatório!';
	exit();
}

if($login == ""){
	echo 'O login é obrigatório!';
	exit();
}

if($senha == ""){
	echo 'A senha é obrigatória!';
	exit();
}



//VERIFICAR SE O REGISTRO JÁ EXISTE NO BANCO
if($antigo != $login){
	$query = $pdo->query("SELECT * FROM usuarios where email = '$login' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'O login já está cadastrado!';
		exit();
	}
}


$res2 = $pdo->prepare("UPDATE usuarios SET nome = :nome, cpf = :cpf, email = :login, senha = :senha WHERE id = '$id'");	
$res2->bindValue(":nome", $nome);
$res2->bindValue(":cpf", $cpf);
$res2->bindValue(":login", $login);
$res2->bindValue(":senha", $senha);
$res2->execute();

echo 'Salvo com Sucesso!!';

?>