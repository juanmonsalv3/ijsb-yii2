<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Estudiantes;
use app\models\VwEstudiantesIndicadores;
use app\models\GruposEstudiantes;
use mPDF;

class InformesController extends Controller{

    public function actionPrueba($id){
        $estudiante = self::consultarEstudiante($id);
        return $this->renderPartial('boletin',['estudiante'=>$estudiante]);
    }

    public function actionBoletin($id, $periodo=1){
        $mpdf=new mPDF();
        $mpdf->mPDF('utf-8', array(216,355),'','','10','10','37','16');
        $mpdf->SetTitle('Boletin');
        $mpdf->SetHTMLHeader($this->renderPartial('header'));
        $mpdf->SetHTMLFooter($this->renderPartial('footer'));

        $estudiante = self::consultarEstudiante($id);

        $anio = Yii::$app->cache->get('parametros')['anioencurso']['valor'];

        $indicadores = VwEstudiantesIndicadores::find()
                ->where(['id_estudiante'=>$id, 'anio'=>$anio, 'id_periodo'=>$periodo,'id_grupo'=>$estudiante->grupoActual->id_grupo])
                ->orderBy('dimension')
                ->all();
        $periodo = self::periodoToRoman($periodo);
        $mpdf->WriteHTML($this->renderPartial('boletin',['estudiante'=>$estudiante, 'periodo'=>$periodo, 'indicadores'=>$indicadores]));
        //$mpdf->AddPage();
        $mpdf->Output();
        exit;
    }

    public function consultarEstudiante($id)
    {
        $estudiante = Estudiantes::find()
                ->with('grupoActual')
                ->where(['id_estudiante'=>$id,'activo'=>1])->one();
        return $estudiante;
    }
    public function periodoToRoman($periodo) {
        $ret = 'I';
        switch ($periodo)
        {
            case 1:
                $ret = 'I';
                break;
            case 2:
                $ret = 'II';
                break;
            case 3:
                $ret = 'III';
                break;
            case 4:
                $ret = 'IV';
                break;
        }
        return $ret;
    }
}
