<?php 

require_once("../conexao.php"); 
@session_start();


$id = $_GET['id'];


$html2 = file_get_contents($url."rel/ficha_individual_html.php?id=$id");
echo $html2;


?>