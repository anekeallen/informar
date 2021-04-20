<?php 
require_once("../../conexao.php"); 

$nome = $_POST['nome-cat'];
$celular = $_POST['telefone-cat'];
$cpf = $_POST['cpf-cat'];
$email = $_POST['email-cat'];

$data = $_POST['data-cat'];

$sexo = $_POST['sexo-cat'];
$rg = $_POST['rg-cat'];
$rg_emissor = $_POST['rg_emissor-cat'];
$rg_data = $_POST['rg_data-cat'];
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
$telefone_fixo = $_POST['telefone_fixo-cat'];

$antigo = $_POST['antigo'];
$antigo2 = $_POST['antigo2'];
$id = $_POST['txtid2'];
$id_endereco = $_POST['id_endereco'];

$uf_endereco = isset($_REQUEST['uf_endereco-cat'])? strval($_REQUEST['uf_endereco-cat']): null;
$id_endereco = isset($_REQUEST['id_endereco'])? intval($_REQUEST['id_endereco']): 0;
$telefone_fixo = isset($_REQUEST['telefone_fixo-cat'])? strval($_REQUEST['telefone_fixo-cat']): null;
$rg = isset($_REQUEST['rg-cat'])? strval($_REQUEST['rg-cat']): null;
$rg_emissor = isset($_REQUEST['rg_emissor-cat'])? strval($_REQUEST['rg_emissor-cat']): null;
//$rg_data = isset($_REQUEST['rg_data-cat'])? strval($_REQUEST['rg_data-cat']): null;
$logradouro = isset($_REQUEST['logradouro-cat'])? strval($_REQUEST['logradouro-cat']): null;
$complemento = isset($_REQUEST['complemento-cat'])? strval($_REQUEST['complemento-cat']): null;
$bairro = isset($_REQUEST['bairro-cat'])? strval($_REQUEST['bairro-cat']): null;
$cidade = isset($_REQUEST['cidade-cat'])? strval($_REQUEST['cidade-cat']): null;
$cep = isset($_REQUEST['cep-cat'])? strval($_REQUEST['cep-cat']): null;



if($rg_data == ""){
	
	$rg_data = NULL;
}


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
	$query = $pdo->query("SELECT * FROM tbprofessor where CPF = '$cpf' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);

	$query = $pdo->query("SELECT * FROM usuarios where cpf = '$cpf' ");
	$res3 = $query->fetchAll(PDO::FETCH_ASSOC);

	$total_reg = @count($res);
	$total_reg2 = @count($res3);
	if($total_reg > 0){
		echo 'O CPF já está Cadastrado para um professor!';
		exit();
	}

	if($total_reg2 > 0){
		echo 'O CPF já cadastrado para algum usuário!';
		exit();
	}
}

if($antigo2 != $email){
	$query = $pdo->query("SELECT * FROM tbprofessor where Email = '$email' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);

	$query = $pdo->query("SELECT * FROM usuarios where email = '$email' ");
	$res3 = $query->fetchAll(PDO::FETCH_ASSOC);

	$total_reg = @count($res);
	$total_reg2 = @count($res3);
	if($total_reg > 0){
		echo 'O Email já cadastrado para um professor!';
		exit();
	}

	if($total_reg2 > 0){
		echo 'O Email já cadastrado para algum usuário!';
		exit();
	}
}


//VERIFICAR SE O REGISTRO COM MESMO EMAIL JÁ EXISTE NO BANCO
if($antigo2 != $email){
	$query = $pdo->query("SELECT * FROM tbprofessor where Email = '$email' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'O Email já está Cadastrado!';
		exit();
	}
}


//SCRIPT PARA SUBIR FOTO NO BANCO
$nome_img = preg_replace('/[ -]+/' , '-' , @$_FILES['imagem']['name']);
$caminho = '../../img/professores/' .$nome_img;
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

if ($id_endereco == 0) {
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

//VERIFICAR SE JA EXISTE USUARIO CADASTRADO

$query = $pdo->query("SELECT * FROM usuarios where cpf = '$cpf' ");
$res_usu = $query->fetchAll(PDO::FETCH_ASSOC);





if($id == ""){
	$res = $pdo->prepare("INSERT INTO tbprofessor SET NomeProfessor = :nome, CPF = :cpf, Email = :email, Celular = :celular, Fone = :telefone, Sexo = :sexo, DataNascimento = :data, RG = :rg, NaturalidadeUF = :naturalidadeUF, NaturalidadeCidade = :naturalidadeCidade, Nacionalidade = :nacionalidade, GpaDataHoraAlteracao = NOW(), RG_OrgaoEmissor = :RG_OrgaoEmissor, RG_DataEmissao =:RG_DataEmissao, IdEndereco = '$id_endereco', foto = '$imagem', IdPai = null, IdMae = null");

	$res2 = $pdo->prepare("INSERT INTO usuarios SET nome = :nome, cpf = :cpf, email = :email, senha = :senha, nivel = :nivel");	
	$res2->bindValue(":senha", '123');
	$res2->bindValue(":nivel", 'professor');

}else{
	if ($imagem == "sem-foto.jpg") {
		$res = $pdo->prepare("UPDATE tbprofessor SET NomeProfessor = :nome, CPF = :cpf, Email = :email, Celular = :celular, Fone = :telefone, Sexo = :sexo, DataNascimento = :data, RG = :rg, NaturalidadeUF = :naturalidadeUF, NaturalidadeCidade = :naturalidadeCidade, Nacionalidade = :nacionalidade, GpaDataHoraAlteracao = NOW(), RG_OrgaoEmissor = :RG_OrgaoEmissor, RG_DataEmissao =:RG_DataEmissao, IdEndereco = '$id_endereco' WHERE IdProfessor = '$id'");


		if(@count($res_usu) == 0){
			$res2 = $pdo->prepare("INSERT INTO usuarios SET nome = :nome, cpf = :cpf, email =:email, senha = :senha, nivel = :nivel");
			$res2->bindValue(":senha", "123");
			$res2->bindValue(":nivel", "professor");


		}else {
			$res2 = $pdo->prepare("UPDATE usuarios SET nome = :nome, cpf = :cpf, email =:email, senha = :senha where cpf = '$cpf'");
			$res2->bindValue(":senha", "123");


		}
	
	}else{
		$res = $pdo->prepare("UPDATE tbprofessor SET NomeProfessor = :nome, CPF = :cpf, Email = :email, Celular = :celular, Fone = :telefone, Sexo = :sexo, DataNascimento = :data, RG = :rg, NaturalidadeUF = :naturalidadeUF, NaturalidadeCidade = :naturalidadeCidade, Nacionalidade = :nacionalidade, GpaDataHoraAlteracao = NOW(), RG_OrgaoEmissor = :RG_OrgaoEmissor, RG_DataEmissao =:RG_DataEmissao, IdEndereco = '$id_endereco', foto = '$imagem' WHERE IdProfessor = '$id'");

		if(@count($res_usu) == 0){
			$res2 = $pdo->prepare("INSERT INTO usuarios SET nome = :nome, cpf = :cpf, email =:email, senha = :senha, nivel = :nivel");
			$res2->bindValue(":senha", "123");
			$res2->bindValue(":nivel", "professor");


		}else {
			$res2 = $pdo->prepare("UPDATE usuarios SET nome = :nome, cpf = :cpf, email =:email, senha = :senha where cpf = '$cpf'");
			$res2->bindValue(":senha", "123");


		}

	}
		
	
}

$res->bindValue(":nome", $nome);
$res->bindValue(":cpf", $cpf);
$res->bindValue(":celular", $celular);
$res->bindValue(":telefone", $telefone_fixo);
$res->bindValue(":email", $email);
$res->bindValue(":data", $data);
$res->bindValue(":rg", $rg);
$res->bindValue(":RG_OrgaoEmissor", $rg_emissor);
$res->bindValue(":RG_DataEmissao", $rg_data);
$res->bindValue(":naturalidadeUF", $naturalidadeUF);
$res->bindValue(":naturalidadeCidade", $naturalidade);
$res->bindValue(":nacionalidade", $nacionalidade);
$res->bindValue(":sexo", $sexo);

$res2->bindValue(":nome", $nome);
$res2->bindValue(":cpf", $cpf);
$res2->bindValue(":email", $email);

$res->execute();
$res2->execute();

echo 'Salvo com Sucesso!!';

?>