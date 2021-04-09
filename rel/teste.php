<?php 

use kartik\mpdf\Pdf;
// Privacy statement output demo
 function actionViewPrivacy() {
    Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
    $pdf = new Pdf([
        'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
        'destination' => Pdf::DEST_BROWSER,
        'content' => $this->renderPartial('privacy'),
        'options' => [
            // any mpdf options you wish to set
        ],
        'methods' => [
            'SetTitle' => 'Privacy Policy - Krajee.com-Krajee.com',
            'SetSubject' => 'Generating PDF files via yii2-mpdf extension has never been easy',
            'SetHeader' => ['Krajee Privacy Policy||Generated On: ' . date("r")],
            'SetFooter' => ['|Page {PAGENO}|'],
            'SetAuthor' => 'Kartik Visweswaran',
            'SetCreator' => 'Kartik Visweswaran',
            'SetKeywords' => 'Krajee, Yii2, Export, PDF, MPDF, Output, Privacy, Policy, yii2-mpdf',
        ]
    ]);
    return $pdf->render();
}



 ?>