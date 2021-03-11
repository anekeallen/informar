<?php 
require_once("../../conexao.php"); 


if (isset($_POST['id_disci'])) {
	

	foreach (@$_POST['id_disci'] as $key => $value) {
		$id_disciplina = @$_POST['id_disci'][$key];
		echo "$id_disciplina";

		


	}
	
}










?>