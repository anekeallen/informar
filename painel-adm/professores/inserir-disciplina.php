<?php  

require_once("../../conexao.php"); 

$id_professor = @$_POST['id_professor'];


//if(!isset($_POST['id_disci'])){
	//echo "Selecione alguma Disciplina!";
	//exit();
//}


$pdo->query("DELETE FROM tbprofessordisciplina WHERE IdProfessor = '$id_professor'");

if(isset($_POST['id_disci'])){
foreach (@$_POST['id_disci'] as $key => $value) {
	$id_disciplina = @$_POST['id_disci'][$key];

	$query = $pdo->query("SELECT * FROM tbprofessordisciplina where IdProfessor = '$id_professor' and IdDisciplina = '$id_disciplina' ");
	$res2 = $query->fetchAll(PDO::FETCH_ASSOC);

	if (@count($res2)>0) {
		continue;

	}else{

		$res = $pdo->prepare("INSERT INTO tbprofessordisciplina SET IdProfessor = :id_professor, IdDisciplina = :id_disciplina");

	}
	

	$res->bindValue(":id_professor", $id_professor);
	$res->bindValue(":id_disciplina", $id_disciplina);
	
	$res->execute();


}}



echo 'Salvo com Sucesso!!';






?>