<?php 
require_once("../../conexao.php"); 

$curso = $_POST['curso-cat'];
$descricao = $_POST['descricao-cat'];
$portaria = $_POST['portaria-cat'];

$horario_M = $_POST['matutino-cat'];
$horario_T = $_POST['vespertino-cat'];
$cargahoraria = $_POST['cargahoraria-cat'];

$antigo = $_POST['antigo'];

$id = $_POST['txtid2'];

if($curso == ""){
	echo 'A curso é Obrigatório!';
	exit();
}





//VERIFICAR SE O REGISTRO JÁ EXISTE NO BANCO
if($antigo != $curso){
	$query = $pdo->query("SELECT * FROM tbcurso where NomeCurso = '$curso' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'A curso já está Cadastrada!';
		exit();
	}
}




if($id == ""){
	$res = $pdo->prepare("INSERT INTO tbcurso SET NomeCurso = :curso, descricao = :descricao, PortariaAutorizacao = :portaria, horarioManha = :matutino, horarioTarde = :vespertino, CargaHorariaAnual = :cargahoraria");	


}else{
	$res = $pdo->prepare("UPDATE tbcurso SET NomeCurso = :curso, descricao = :descricao, PortariaAutorizacao = :portaria, horarioManha = :matutino, horarioTarde = :vespertino, CargaHorariaAnual = :cargahoraria WHERE IdCurso = '$id'");

	
	
}

$res->bindValue(":curso", $curso);
$res->bindValue(":descricao", $descricao);
$res->bindValue(":portaria", $portaria);
$res->bindValue(":matutino", $horario_M);
$res->bindValue(":vespertino", $horario_T);
$res->bindValue(":cargahoraria", $cargahoraria);





$res->execute();


echo 'Salvo com Sucesso!!';

?>