<?php 
require_once("../../conexao.php"); 

$nome = $_POST['nome-cat'];
$telefone = $_POST['telefone-cat'];
$cpf = $_POST['cpf-cat'];
$email = $_POST['email-cat'];
$registro = $_POST['registro-cat'];
$data = $_POST['data-cat'];
$sexo = $_POST['sexo-cat'];
$mae = $_POST['mae-cat'];
$pai = $_POST['pai-cat'];
$rg = $_POST['rg-cat'];
$cartorio = $_POST['cartorio-cat'];
$livro = $_POST['livro-cat'];
$folha = $_POST['folha-cat'];
$dataRegistro = $_POST['dataRegistro-cat'];
$nacionalidade = $_POST['nacionalidade-cat'];
$naturalidade = $_POST['naturalidade-cat'];
$naturalidadeUF = $_POST['UF-cat']; 
$cpf_responsavel = $_POST['cpf_responsavel-cat']; 
//$foto = $_POST['imagem'];




$antigo = $_POST['antigo'];
$antigo1 = $_POST['antigo1'];

$id = $_POST['txtid2'];

//Recuperar A DATA PARA VERIFICAR SE O ALUNO É MENOR DE IDADE

$data_18 = date("Y-m-d",strtotime(date("Y-m-d")."-18 year"));
if ($cpf_responsavel == "") {
	if ($data > $data_18) {
		echo "O Aluno é menor de Idade, Preencha o CPF do Responsável!";
		exit();
	}
	
}


if($nome == ""){
	echo 'O Nome é Obrigatório!';
	exit();
}
if($registro == ""){
	echo 'O Registro é Obrigatório!';
	exit();
}
if($email == ""){
	echo 'O Email é Obrigatório!';
	exit();
}

if($mae == ""){
	echo 'O Campo é Obrigatório!';
	exit();
}
if($data == ""){
	echo 'A Data é Obrigatória!';
	exit();
}



//VERIFICAR SE O REGISTRO JÁ EXISTE NO BANCO
if($antigo != $registro){
	$query = $pdo->query("SELECT * FROM tbaluno where RegistroNascimentoNumero = '$registro' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'O Registro já está Cadastrado!';
		exit();
	}
}

//VERIFICAR SE O Email JÁ EXISTE NO BANCO
if($antigo1 != $email){
	$query = $pdo->query("SELECT * FROM tbaluno where Email = '$email' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'O Email já está Cadastrado!';
		exit();
	}
}

//VERIFICAR SE O RESPONSAVEL ESTA CADASTRADO

if($cpf_responsavel != ""){
	$query = $pdo->query("SELECT * FROM tbresponsavel where CPFCNPJ = '$cpf_responsavel' ");
	$res_respo = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg_respo = @count($res_respo);
	if($total_reg_respo == 0){
		echo 'O CPF do Responsável não foi encontrado, faça o cadastro do responsável!!';
		exit();
	}else{

		$id_responsavel = $res_respo[0]['IdResponsavel'];
		$id_endereco = $res_respo[0]['IdEndereco'];

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

//VERIFICAR O ID DO ENDEREÇO PELO CPF DO RESPONSAVEL

$query = $pdo->query("SELECT * FROM usuarios where cpf = '$registro' ");
$res_usu = $query->fetchAll(PDO::FETCH_ASSOC);




if($id == ""){
	$res = $pdo->prepare("INSERT INTO tbaluno SET NomeAluno = :nome, CPF = :cpf, Email = :email,  Celular = :telefone, Sexo = :sexo, foto = '$imagem', NomeMae = :mae , NomePai = :pai, DataNascimento = :data, RG = :rg, RegistroNascimentoData = :registroData, RegistroNascimentoCartorio = :registroCartorio, RegistroNascimentoFolha =:registroFolha, RegistroNascimentoLivro = :registroLivro, RegistroNascimentoNumero = :registroNumero, NaturalidadeUF = :naturalidadeUF, NaturalidadeCidade = :naturalidadeCidade, Nacionalidade = :nacionalidade, dataCadastro = curDate(), IdResponsavel = '$id_responsavel', IdEndereco = '$id_endereco'");
	$res2 = $pdo->prepare("INSERT INTO usuarios SET nome = :nome, cpf = :cpf, email =:email, senha = :senha, nivel = :nivel");
	$res2->bindValue(":senha", "123");
	$res2->bindValue(":nivel", "aluno");



}else{
	if ($imagem == "sem-foto.jpg") {
		$res = $pdo->prepare("UPDATE tbaluno SET NomeAluno = :nome, CPF = :cpf, Email = :email,  Celular = :telefone, Sexo = :sexo, NomeMae = :mae , NomePai = :pai, DataNascimento = :data, RG = :rg, RegistroNascimentoData = :registroData, RegistroNascimentoCartorio =:registroCartorio, RegistroNascimentoFolha = :registroFolha, RegistroNascimentoLivro = :registroLivro, RegistroNascimentoNumero = :registroNumero, NaturalidadeUF = :naturalidadeUF, NaturalidadeCidade = :naturalidadeCidade, Nacionalidade = :nacionalidade WHERE IdAluno = '$id'");

		if(@count($res_usu) == 0){
			$res2 = $pdo->prepare("INSERT INTO usuarios SET nome = :nome, cpf = :cpf, email =:email, senha = :senha, nivel = :nivel");
			$res2->bindValue(":senha", "123");
			$res2->bindValue(":nivel", "aluno");


		}else {
			$res2 = $pdo->prepare("UPDATE usuarios SET nome = :nome, cpf = :cpf, email =:email, senha = :senha where cpf = '$registro'");
			$res2->bindValue(":senha", "123");


		}



		
		

	}else{
		$res = $pdo->prepare("UPDATE tbaluno SET NomeAluno = :nome, CPF = :cpf, Email = :email,  Celular = :telefone, Sexo = :sexo, foto = '$imagem', NomeMae = :mae , NomePai = :pai, DataNascimento = :data, RG = :rg, RegistroNascimentoData = :registroData, RegistroNascimentoCartorio = :registroCartorio, RegistroNascimentoFolha =:registroFolha, RegistroNascimentoLivro = :registroLivro, RegistroNascimentoNumero = :registroNumero, NaturalidadeUF = :naturalidadeUF, NaturalidadeCidade = :naturalidadeCidade, Nacionalidade = :nacionalidade WHERE IdAluno = '$id'");

		if(@count($res_usu) == 0){
			$res2 = $pdo->prepare("INSERT INTO usuarios SET nome = :nome, cpf = :cpf, email =:email, senha = :senha, nivel = :nivel");
			$res2->bindValue(":senha", "123");
			$res2->bindValue(":nivel", "aluno");


		}else {
			$res2 = $pdo->prepare("UPDATE usuarios SET nome = :nome, cpf = :cpf, email =:email, senha = :senha where cpf = '$registro'");
			$res2->bindValue(":senha", "123");


		}
		


	}
	
	
	
}

$res->bindValue(":nome", $nome);
$res->bindValue(":cpf", $cpf);
$res->bindValue(":telefone", $telefone);
$res->bindValue(":email", $email);
$res->bindValue(":mae", $mae);
$res->bindValue(":pai", $pai);
$res->bindValue(":data", $data);
$res->bindValue(":rg", $rg);
$res->bindValue(":registroData", $dataRegistro);
$res->bindValue(":registroCartorio", $cartorio);
$res->bindValue(":registroFolha", $folha);
$res->bindValue(":registroLivro", $livro);
$res->bindValue(":registroNumero", $registro);
$res->bindValue(":naturalidadeUF", $naturalidadeUF);
$res->bindValue(":naturalidadeCidade", $naturalidade);
$res->bindValue(":nacionalidade", $nacionalidade);
$res->bindValue(":sexo", $sexo);

$res2->bindValue(":nome", $nome);
$res2->bindValue(":cpf", $registro);
$res2->bindValue(":email", $email);



$res->execute();
$res2->execute();


echo 'Salvo com Sucesso!!';

?>