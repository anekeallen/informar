<?php 
require_once("../../conexao.php"); 

$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$disciplina = $_POST['disc-cat'];
$id_professor = $_POST['professor'];
$data = $_POST['data_aula'];
$turma = $_POST['turma'];
$periodo = $_POST['periodo'];
$fase = $_POST['fase'];


if($nome == ""){
	echo 'O nome é Obrigatório!';
	exit();
}


$res = $pdo->prepare("INSERT INTO aulas SET turma = :turma, nome = :nome, descricao = :descricao, periodo = :periodo, data = :data, id_disciplina = :id_disciplina, id_professor = :id_professor, NumeroFase = :fase");	

	
$res->bindValue(":nome", $nome);
$res->bindValue(":descricao", $descricao);
$res->bindValue(":turma", $turma);
$res->bindValue(":periodo", $periodo);
$res->bindValue(":data", $data);
$res->bindValue(":id_disciplina", $disciplina);
$res->bindValue(":id_professor", $id_professor);
$res->bindValue(":fase", $fase);

$res->execute();


echo 'Salvo com Sucesso!';

?>