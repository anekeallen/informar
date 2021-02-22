<?php 
require_once("../../conexao.php"); 

$nome = $_POST['nome-cat'];
$telefone = $_POST['telefone-cat'];
$cpf = $_POST['cpf-cat'];
$email = $_POST['email-cat'];

$data = $_POST['data-cat'];
$id_profissao = $_POST['profissao-cat'];
$local_trabalho = $_POST['local_trabalho-cat'];
$telefone_trabalho = $_POST['telefone_trab-cat'];

$sexo = $_POST['sexo-cat'];
$rg = $_POST['rg-cat'];
$nacionalidade = $_POST['nacionalidade-cat'];
$naturalidade = $_POST['naturalidade-cat'];
$naturalidadeUF = $_POST['UF-cat']; 
//$foto = $_POST['imagem']

$logradouro = $_POST['logradouro-cat'];
$complemento = $_POST['complemento-cat'];
$bairro = $_POST['bairro-cat'];
$cidade = $_POST['cidade-cat'];
$uf_endereco = $_POST['uf_endereco-cat'];
$cep = $_POST['cep-cat'];
$telefone_fixo = $_POST['telefone_res-cat'];





$id_endereco = $_POST['id_endereco'];
$antigo = $_POST['antigo'];

$id = $_POST['txtid2'];

if($nome == ""){
	echo 'O Nome é Obrigatório!';
	exit();
}

if($cpf == ""){
	echo 'O CPF é Obrigatório!';
	exit();
}



//VERIFICAR SE O REGISTRO JÁ EXISTE NO BANCO
if($antigo != $cpf){
	$query = $pdo->query("SELECT * FROM tbresponsavel where IdResponsavel = '$id' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'O Responsável já está Cadastrado!';
		exit();
	}
}



//SCRIPT PARA SUBIR FOTO NO BANCO
$nome_img = preg_replace('/[ -]+/' , '-' , @$_FILES['imagem']['name']);
$caminho = '../../img/alunos/' .$nome_img;
if (@$_FILES['imagem']['name'] == ""){
	$imagem = "sem-foto.jpg";
}else{
	$imagem = $nome_img;
}

$imagem_temp = @$_FILES['imagem']['tmp_name']; 
$ext = pathinfo($imagem, PATHINFO_EXTENSION);   
if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif'){ 
	move_uploaded_file($imagem_temp, $caminho);
}else{
	echo 'Extensão de Imagem não permitida!';
	exit();
}

if ($id_endereco == "") {
	$res2 = $pdo->prepare("INSERT INTO tbendereco SET Logradouro = :logradouro, Bairro = :bairro, Complemento =:complemento, Cidade = :cidade, UF = :uf_endereco, CEP =:cep, Fone =:fone, Inet_DataAlteracao = curDate()");

	$res2->bindValue(":logradouro", "$logradouro");
	$res2->bindValue(":bairro", "$bairro");
	$res2->bindValue(":complemento", "$complemento");
	$res2->bindValue(":cidade", "$cidade");
	$res2->bindValue(":uf_endereco", "$uf_endereco");
	$res2->bindValue(":cep", "$cep");
	$res2->bindValue(":fone", "$telefone_fixo");
	$res2->execute();

	$id_endereco = $pdo->lastInsertId();

	
	
} else{

	$res2 = $pdo->prepare("UPDATE tbendereco SET Logradouro = :logradouro, Bairro = :bairro, Complemento =:complemento, Cidade = :cidade, UF = :uf_endereco, CEP =:cep, Fone =:fone, Inet_DataAlteracao = curDate() where IdEndereco = '$id_endereco'");

	$res2->bindValue(":logradouro", "$logradouro");
	$res2->bindValue(":bairro", "$bairro");
	$res2->bindValue(":complemento", "$complemento");
	$res2->bindValue(":cidade", "$cidade");
	$res2->bindValue(":uf_endereco", "$uf_endereco");
	$res2->bindValue(":cep", "$cep");
	$res2->bindValue(":fone", "$telefone_fixo");
	$res2->execute();

}




if($id == ""){
	

	$res = $pdo->prepare("INSERT INTO tbresponsavel SET NomeResponsavel = :nome, CPFCNPJ = :cpf, Email = :email, Celular = :telefone, Sexo = :sexo, DataNascimento = :data, RG = :rg, NaturalidadeUF = :naturalidadeUF, NaturalidadeCidade = :naturalidadeCidade, Nacionalidade = :nacionalidade, dataCadastro = curDate(), IdProfissao = :idprofissao, LocalTrabalho =:localtrabalho, IdEndereco = '$id_endereco', FoneTrabalho =:fonetrabalho");
	

}else{

	$res = $pdo->prepare("UPDATE tbresponsavel SET NomeResponsavel = :nome, CPFCNPJ = :cpf, Email = :email,  Celular = :telefone, Sexo = :sexo, DataNascimento = :data, RG = :rg, NaturalidadeUF = :naturalidadeUF, NaturalidadeCidade = :naturalidadeCidade, Nacionalidade = :nacionalidade, IdProfissao = :idprofissao, LocalTrabalho =:localtrabalho, FoneTrabalho =:fonetrabalho WHERE IdResponsavel = '$id'");	
	
}

$res->bindValue(":nome", $nome);
$res->bindValue(":cpf", $cpf);
$res->bindValue(":telefone", $telefone);
$res->bindValue(":email", $email);
$res->bindValue(":data", $data);
$res->bindValue(":rg", $rg);
$res->bindValue(":naturalidadeUF", $naturalidadeUF);
$res->bindValue(":naturalidadeCidade", $naturalidade);
$res->bindValue(":nacionalidade", $nacionalidade);
$res->bindValue(":sexo", $sexo);
$res->bindValue(":idprofissao", $id_profissao);
$res->bindValue(":localtrabalho", $local_trabalho);
$res->bindValue(":fonetrabalho", $telefone_trabalho);


$res->execute();



echo 'Salvo com Sucesso!!';

?>