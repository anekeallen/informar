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
//$foto = $_POST['imagem'];




$antigo = $_POST['antigo'];

$id = $_POST['txtid2'];

if($nome == ""){
	echo 'O Nome é Obrigatório!';
	exit();
}

if($mae == ""){
	echo 'O Campo é Obrigatório!';
	exit();
}
if($registro == ""){
	echo 'O Campo é Obrigatório!';
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



if($id == ""){
	$res = $pdo->prepare("INSERT INTO tbaluno SET NomeAluno = :nome, CPF = :cpf, Email = :email,  Celular = :telefone, Sexo = :sexo, foto = '$imagem', NomeMae = :mae , NomePai = :pai, DataNascimento = :data, RG = :rg, RegistroNascimentoData = :registroData, RegistroNascimentoCartorio = :registroCartorio, RegistroNascimentoFolha =:registroFolha, RegistroNascimentoLivro = :registroLivro, RegistroNascimentoNumero = :registroNumero, NaturalidadeUF = :naturalidadeUF, NaturalidadeCidade = :naturalidadeCidade, Nacionalidade = :nacionalidade");	


}else{
	if ($imagem == "sem-foto.jpg") {
		$res = $pdo->prepare("UPDATE tbaluno SET NomeAluno = :nome, CPF = :cpf, Email = :email,  Celular = :telefone, Sexo = :sexo, NomeMae = :mae , NomePai = :pai, DataNascimento = :data, RG = :rg, RegistroNascimentoData = :registroData, RegistroNascimentoCartorio =:registroCartorio, RegistroNascimentoFolha = :registroFolha, RegistroNascimentoLivro = :registroLivro, RegistroNascimentoNumero = :registroNumero, NaturalidadeUF = :naturalidadeUF, 	NaturalidadeCidade = :naturalidadeCidade, Nacionalidade = :nacionalidade WHERE IdAluno = '$id'");

	}else{
		$res = $pdo->prepare("UPDATE tbaluno SET NomeAluno = :nome, CPF = :cpf, Email = :email,  Celular = :telefone, Sexo = :sexo, foto = '$imagem', NomeMae = :mae , NomePai = :pai, DataNascimento = :data, RG = :rg, RegistroNascimentoData = :registroData, RegistroNascimentoCartorio = :registroCartorio, RegistroNascimentoFolha =:registroFolha, RegistroNascimentoLivro = :registroLivro, RegistroNascimentoNumero = :registroNumero, NaturalidadeUF = :naturalidadeUF, NaturalidadeCidade = :naturalidadeCidade, Nacionalidade = :nacionalidade WHERE IdAluno = '$id'");


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

$res->execute();


echo 'Salvo com Sucesso!!';

?>