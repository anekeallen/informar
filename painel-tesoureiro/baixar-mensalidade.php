<?php 

$query_r = $pdo->query("SELECT * FROM pgto_matriculas where id = '" . $id_pgto . "' ");
$res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
$valor_mat = $res_r[0]['valor'];
$id_mat = $res_r[0]['matricula'];
$pago = $res_r[0]['pago'];

$query = $pdo->query("SELECT * FROM matriculas where id = '$id_mat' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_aluno = $res[0]['aluno'];


$query = $pdo->query("SELECT * FROM tbaluno where IdAluno = '$id_aluno' ");
$res_alu = $query->fetchAll(PDO::FETCH_ASSOC);
$id_responsavel = $res_alu[0]['IdResponsavel'];

$query = $pdo->query("SELECT * FROM tbresponsavel where IdResponsavel = '$id_responsavel' ");
$res_res = $query->fetchAll(PDO::FETCH_ASSOC);

$cpfcnpj = $res_res[0]['CPFCNPJ'];

if($pago != 'Sim'){

	$pdo->query("UPDATE pgto_matriculas SET pago = 'Sim' WHERE id = '$id_pgto'");

	$pdo->query("INSERT movimentacoes SET tipo = 'Entrada', descricao = 'Pagamento Mensalidade', valor = '$valor_mat', funcionario = '$cpf_usuario', data = curDate(), mensalidade = 'Sim', cpf_responsavel = '$cpfcnpj' ");

}


?>