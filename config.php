<?php  

$nome_escola = "Centro Educacional Informar";
$url = "http://devallen.com.br/";
$endereco_escola = "Av. Moema Tinoco da Cunha Lima, 1861 - Pajuçara, Natal/RN";
$telefone_escola = "(84) 3663-2516";
$cep_escola = "59133-090";
$email_escola = "ceinformar@yahoo.com.br";
$email_adm = "anekeapj@gmail.com";
$rodape_relatorios = "Desenvolvido por DevAllen";
$cnpj_escola = '03.178.155/0001-00';
$cidade_escola = 'Natal / RN'; 


//Variaveis do Banco de dados Local
$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'informar';

/*$servidor = 'localhost';
$usuario = 'devall47_aneke';
$senha = 'AAmm031323';
$banco = 'devall47_informar'; */


//VARIAVEIS GLOBAIS
$pgto_boleto = 'Sim'; //DEIXAR 'Sim' para pagamentos com boleto, para deixar a possibilidade do Tesoureiro Carregar arquivos


$media_porcentagem_presenca = 70; //70% define que a média limite para presença é de 70%;

$media_pontos_minimo_aprovacao = 60; //O aluno vai precisar de no minimo 60 pontos para aprovação no curso

$maximo_pontos_disciplina = 100; //Maximo de pontos possiveis para distribuir em cada disciplina


$carga_horaria_cert = 250; //carga horaria em horas

//Possivel editar configurações

$config_editavel = "Não";

//Composição de notas Informar

$nota_maxima1 = 1.00;
$nota_maxima2 = 3.00;
$nota_maxima3 = 6.00;

$maximo_nota = $nota_maxima1 + $nota_maxima2 + $nota_maxima3; //Nota maxima por fase

$maximo_nota_rec = 10.00; //Maximo de nota da rec
$maximo_nota_prova_final = 10.00; //Maximo da nota prova final

$media_aprovacao = 7.0; //Media de aprovacao
$media_reprovacao = 2.5; // limite da media para reprovacao

$media_aprovacao_rec = 7.0; //Media para aprovacao na rec
$media_aprovacao_prova_final = 5.0; //Media para aprovacao na Prova Final

//Define o total de disciplinas que pode ser reprovado para a progressão parcial

$total_disciplina_progressao = 1;

$carga_horaria_F1 = 800;
$carga_horaria_F2 = 1000;

$dias_letivos = 200;



