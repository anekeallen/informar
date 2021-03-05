<?php  

$nome_escola = "Informar - Centro Educacional";
$url = "http://localhost/informar/";
$endereco_escola = "Av. Moema Tinoco da Cunha Lima, 1861 - Pajuçara, Natal - RN, 59133-090";
$telefone_escola = "(84)3663-2516";
$email_adm = "anekeapj@gmail.com";
$rodape_relatorios = "Desenvolvido por DevAllen";
$cnpj_escola = '26.100.560/0000-50';
$cidade_escola = 'Natal/RN'; 

//Variaveis do Banco de dados
$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'informar';


//VARIAVEIS GLOBAIS
$pgto_boleto = 'Sim'; //DEIXAR 'Sim' para pagamentos com boleto, para deixar a possibilidade do Tesoureiro Carregar arquivos


$media_porcentagem_presenca = 70; //70% define que a média limite para presença é de 70%;

$media_pontos_minimo_aprovacao = 60; //O aluno vai precisar de no minimo 60 pontos para aprovação no curso

$maximo_pontos_disciplina = 100; //Maximo de pontos possiveis para distribuir em cada disciplina


$carga_horaria_cert = 250; //carga horaria em horas

?>