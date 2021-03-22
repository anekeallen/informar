<?php 

require_once("../../conexao.php"); 

$id_turma = $_POST['id-turma'];


foreach (@$_POST['id_disc'] as $key => $value) {
	$id_disciplina = @$_POST['id_disc'][$key];
	
	$id_professor = @$_POST['id_profe'][$key];

	$query = $pdo->query("SELECT * FROM tbturmaprofessor where IdTurma = '$id_turma' and IdDisciplina = '$id_disciplina' ");
	$res2 = $query->fetchAll(PDO::FETCH_ASSOC);

	if (@count($res2)>0) {
		

		$pdo->query("UPDATE tbturmaprofessor SET IdProfessor = '$id_professor' where IdDisciplina = '$id_disciplina' and IdTurma = '$id_turma'");

		

		
		
	}else{






		$res = $pdo->prepare("INSERT INTO tbturmaprofessor SET IdTurma = :idturma, IdDisciplina = :id_disciplina, IdProfessor = :id_professor");

		$res->bindValue(":idturma", $id_turma);
		$res->bindValue(":id_disciplina", $id_disciplina);
		$res->bindValue(":id_professor", $id_professor);





		$res->execute();
	}

}


echo 'Salvo com Sucesso!!';

?>