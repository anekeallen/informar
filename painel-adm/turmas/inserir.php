<?php 
require_once("../../conexao.php"); 

$turma = $_POST['turma-cat'];
$descricao = $_POST['descricao-cat'];

$antigo = $_POST['antigo'];

$id = $_POST['txtid2'];

if($turma == ""){
	echo 'A Turma é Obrigatória!';
	exit();
}



//VERIFICAR SE O REGISTRO JÁ EXISTE NO BANCO
if($antigo != $turma){
	$query = $pdo->query("SELECT * FROM turmas where turma = '$turma' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'A Turma já está Cadastrada!';
		exit();
	}
}




if($id == ""){
	$res = $pdo->prepare("INSERT INTO turmas SET turma = :turma, descricao = :descricao");	


}else{
	$res = $pdo->prepare("UPDATE turmas SET turma = :turma, descricao = :descricao WHERE id = '$id'");

	
	
}

$res->bindValue(":turma", $turma);
$res->bindValue(":descricao", $descricao);





$res->execute();


echo 'Salvo com Sucesso!!';

?>