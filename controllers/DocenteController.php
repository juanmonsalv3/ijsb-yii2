<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Indicadores;
use app\models\Grupos;
use app\models\GruposEstudiantes;


class DocenteController extends Controller
{
    public function beforeAction($action) {
        $this->layout = 'docente';
        
        if (Yii::$app->user->isGuest)
        {
            $this->redirect(['usuarios/login']);
        }
        $grupo = Yii::$app->session->get('grupo_docente');
        if($action->actionMethod !== 'actionGrupos' && (is_null($grupo) || $grupo ==''))
        {
            $this->redirect(['docente/grupos']);
            return false;
        }
        return true;
    }
    
    public function actionIndex(){
        $grupo = Yii::$app->session->get('grupo_docente');
        if(is_null($grupo) || $grupo ==''){
            return $this->redirect(['docente/grupos']);
        }
        else{
            return $this->redirect(['docente/grupo']);
        }
    }
    
    public function actionGrupos($id = null){
        
        if($id !== null)
        {
            $existe = Grupos::find()->where(['id_grupo'=>$id])->exists();
            if($existe){
                Yii::$app->session->set('grupo_docente',$id);
                return $this->redirect(['docente/index']);
            }
        }        
        
        $id_profesor = Yii::$app->user->identity->id_usuario;
        $grupos = \app\models\ProfesoresGrupos::find()
                ->with('grupo')
                ->where(['id_usuario'=>$id_profesor])
                ->all();
        
        Yii::$app->session->set('varios_grupos',false);
        if(count($grupos)===0){
            Yii::$app->session->setFlash('mensaje','No tiene permiso para acceder.');
            return $this->redirect(['usuarios/logout']);
        }
        if(count($grupos)==1){
            Yii::$app->session->set('grupo_docente',$grupos[0]->id_grupo);
            return $this->redirect(['docente/index']);
        }
        Yii::$app->session->set('varios_grupos',true);
        return $this->render('grupos',['grupos'=>$grupos]);
    }
    
    public function actionGrupo() {
        $id_grupo = Yii::$app->session->get('grupo_docente');
        $grupo = Grupos::find()
                ->where(['id_grupo'=>$id_grupo])
                ->with('estudiantes')
                ->one();
        $horarios = GruposController::buscarHorarios($id_grupo);
        $horas = GruposController::buscarHorasHorario();
        $cronogram = CronogramasController::buscarCronogramaGrupo($id_grupo);
        $periodo = Yii::$app->cache->get('parametros')['periodoencurso']['valor'];
        $indicadores = IndicadoresController::buscarIndicadoresPorGrupo($id_grupo,$periodo);
        return $this->render('grupo',['grupo'=>$grupo, 'horarios'=>$horarios, 'horas'=>$horas, 'cronograma'=>$cronogram, 'indicadores'=>$indicadores]);
    }
    
    public function actionEstudiante($id) {
        $estudiante = \app\models\Estudiantes::find()
                ->with('grupoActual','fichaPsicologica','fichaMedica','acudientes')
                ->where(['id_estudiante'=>$id, 'activo'=>1])
                ->one();
        
        $logros = EstudiantesController::buscarLogrosEstudiante($id);
        return $this->render('estudiante',['estudiante'=>$estudiante,'logros'=>$logros]);
    }
    
    
    
    public function actionLogrosPartial($periodo, $id_estudiante){
        $logros = EstudiantesController::buscarLogrosEstudiante($id_estudiante,$periodo);
        
        return $this->renderAjax('//partials/logrosestudiante_view',['logros'=>$logros]);
    }
    
    public function actionLogros($id_estudiante, $periodo=null){
        
        if($periodo == null){
            $periodo = Yii::$app->cache->get('parametros')['periodoencurso']['valor'];
        }
        $anio = Yii::$app->cache->get('parametros')['anioencurso']['valor'];
        $estudiante_grupo = GruposEstudiantes::find()->with('estudiante')->where(['id_estudiante'=>$id_estudiante, 'anio'=>$anio])->one();
        $indicadores = EstudiantesController::buscarLogrosIndicadores($id_estudiante,$periodo);
        return $this->render('logros',['indicadores'=>$indicadores,'estudiantegrupo'=>$estudiante_grupo,'periodo'=>$periodo]);
    }
}