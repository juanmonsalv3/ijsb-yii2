<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Parametros;
use app\models\Horarios;
use mPDF;
use kartik\mpdf\Pdf;
use app\classes\Security;

class PruebasController extends Controller
{
    public function actionPrueba1(){
        return $this->renderPartial('header');
    }
    public function actionPrueba2(){
        Yii::$app->session->set('variable','variableeeeeee');
    }
    
    public function actionRestartParametros(){
        
        $data = Parametros::find()->asArray()->indexBy('codigo_parametro')->all();

        Yii::$app->cache->set('parametros', $data);  
        
        var_dump($data);
    }
    
    public function actionCreatepdf(){
        $mpdf=new mPDF();
        $mpdf->mPDF('utf-8','A4','','','15','15','40','18');
        $mpdf->SetHTMLHeader($this->renderPartial('header'));
        $mpdf->WriteHTML($this->renderPartial('pdf'));
        $mpdf->AddPage();
        $mpdf->WriteHTML($this->renderPartial('pdf'));
        $mpdf->Output();
        exit;
                //return $this->renderPartial('mpdf');
    }
    
    public function actionSamplePdf() {
        $mpdf = new mPDF;
        $mpdf->WriteHTML('Hallo World');
        
        $mpdf->Output();
        exit;
    }
    public function actionForceDownloadPdf(){
        $mpdf=new mPDF();
        $mpdf->WriteHTML($this->renderPartial('mpdf'));
        $mpdf->Output('MyPDF.pdf', 'D');
        exit;
    }

    public function actionTestEncryption(){
        $encrypt = Security::getInstance()->encrypt('juancho');
        $decrypt = Security::getInstance()->decrypt($encrypt);


        echo $encrypt. " " .$decrypt;

        return $this->render('estudiantes');
    }

    public function actionTestdata(){
        $request = Yii::$app->request;
        print_r($request->get());
    }
}