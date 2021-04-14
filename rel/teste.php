<?php
date_default_timezone_set('America/Sao_Paulo');
require_once('../vendor/autoload.php');
$mpdf = new \Mpdf\Mpdf();


// Define the Header/Footer before writing anything so they appear on the first page

$mpdf->SetHTMLFooter('
<hr>
');

$mpdf->WriteHTML('Hello World');

$mpdf->Output("fichaindividual.pdf", "I");