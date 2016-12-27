<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Html;
use app\models\Grupos;
use app\models\Usuarios;
use app\models\ProfesoresGrupos;
use app\models\Asignaturas;
use app\models\GruposAsignaturas;
use app\models\Horarios;

class GruposController extends Controller
{
    public function beforeAction($action){
        if (Yii::$app->user->isGuest)
        {
            $this->redirect(['usuarios/login']);
        }
        return true;
    }
    
    public function actionIndex()
    {
        $grupos = Grupos::find()->orderBy('id_grupo')->all();
        return $this->render("index",["grupos"=>$grupos]);
    }
    
    public function actionGrupo($id_grupo)
    {
        $grupo = Grupos::find()
                ->with(['estudiantes','asignaturas','profesores'])
                ->where(['id_grupo' => $id_grupo])->one();
        
        $horarios = GruposController::buscarHorarios($id_grupo);
        $horas = GruposController::buscarHorasHorario();
        $cronograma = CronogramasController::buscarCronogramaGrupo($id_grupo);
        $periodo = Yii::$app->cache->get('parametros')['periodoencurso']['valor'];
        $indicadores = IndicadoresController::buscarIndicadoresPorGrupo($id_grupo,$periodo);
        return $this->render("grupo",["grupo"=>$grupo,'horario'=>$horarios, 'horas'=>$horas, 'cronograma'=>$cronograma, 'indicadores'=>$indicadores]);
    }
    
    public function actionProfesores($id_grupo){
        if(!Yii::$app->request->isAjax){
            throw new \yii\web\NotFoundHttpException();
        }
        $profesores = Usuarios::find()->where(['activo'=>1,'id_perfil'=>4])->all();
        $profesor_grupo = ProfesoresGrupos::find()
                ->where(['id_grupo'=>$id_grupo])->orderBy('anio DESC')->one();
        return $this->renderAjax('profesores',['profesores'=>$profesores, 'profesor_grupo'=>$profesor_grupo]);
    }
    
    public function actionAsignarProfesor($id_grupo,$id_profesor){
        if(!Yii::$app->request->isAjax){
            throw new \yii\web\NotFoundHttpException();
        }
        $profesor_grupo = ProfesoresGrupos::find()
                ->where(['id_grupo'=>Html::encode($id_grupo),
                            'anio'=>Yii::$app->cache->get('parametros')['anioencurso']['valor']
                    ])->one();
        if($profesor_grupo==null)
        {
            $profesor_grupo = new ProfesoresGrupos();
            $profesor_grupo->anio = Yii::$app->cache->get('parametros')['anioencurso']['valor'];
            $profesor_grupo->id_grupo = $id_grupo;
        }
        $profesor_grupo->id_usuario = $id_profesor;
        if($profesor_grupo->save()){
            $items = ['status'=>true, 'msg'=>'Se asignó correctamente el profesor.', 'nombre'=> $profesor_grupo->usuario->nombrecompleto];
            return \yii\helpers\Json::encode($items);
        }
    }
    
    public function actionAsignaturas($id_grupo){
        if(!Yii::$app->request->isAjax){
            throw new \yii\web\NotFoundHttpException();
        }
        $asignaturas = Asignaturas::find()
                ->leftJoin('grupos_asignaturas', 'grupos_asignaturas.id_asignatura = asignaturas.id_asignatura and grupos_asignaturas.activo = 1 and grupos_asignaturas.id_grupo = '.$id_grupo)
                ->where('grupos_asignaturas.id_asignatura is null and grupos_asignaturas.id_grupo is null')
                ->all();
        return $this->renderAjax('asignaturas',['asignaturas'=>$asignaturas]);
    }
    
    public function actionAsignarAsignatura($id_grupo, $id_asignatura) {
        if(!Yii::$app->request->isAjax){
            throw new \yii\web\NotFoundHttpException();
        }
        $grupo_asignatura = GruposAsignaturas::find()->where(['id_grupo'=>$id_grupo,'id_asignatura'=>$id_asignatura])->one();
        if($grupo_asignatura == null){
            $grupo_asignatura = new GruposAsignaturas;
            $grupo_asignatura->id_grupo = $id_grupo;
            $grupo_asignatura->id_asignatura = $id_asignatura;
        }
        $grupo_asignatura->activo = 1;
        if($grupo_asignatura->save()){
            $grupo = Grupos::find()
                ->with(['estudiantes','asignaturas','profesores'])
                ->where(['id_grupo' => $id_grupo])->one();
            return $this->renderAjax('//partials/asignaturasgrupo_edit',['asignaturas'=>$grupo->asignaturas]);
        }
        else {
            throw new Exception;
        }
    }
    
    public function actionRemoverAsignatura($id_grupo, $id_asignatura){
        if(!Yii::$app->request->isAjax){
            throw new \yii\web\NotFoundHttpException();
        }
        $grupo_asignatura = GruposAsignaturas::find()->where(['id_grupo'=>$id_grupo,'id_asignatura'=>$id_asignatura])->one();
        if($grupo_asignatura == null){
            throw new \yii\web\NotFoundHttpException();
        }
        $grupo_asignatura->activo = 0;
        if($grupo_asignatura->save()){
            $grupo = Grupos::find()
                ->with(['estudiantes','asignaturas','profesores'])
                ->where(['id_grupo' => $id_grupo])->one();
            return $this->renderAjax('//partials/asignaturasgrupo_edit',['asignaturas'=>$grupo->asignaturas]);
        }
        else{
            throw new Exception;
        }
    }
    
    public function actionHorario($id_grupo){
        $grupo = Grupos::find()
                ->where(['id_grupo' => $id_grupo])
                ->one();
        
        $horario = GruposController::buscarHorarios($id_grupo);
        $horas = GruposController::buscarHorasHorario();
        $asignaturas = Asignaturas::find()
                ->innerJoin('grupos_asignaturas','grupos_asignaturas.id_asignatura = asignaturas.id_asignatura and grupos_asignaturas.id_grupo = '.$id_grupo)
                ->all();
        
        return $this->render('horario', ['grupo'=>$grupo,'horario'=>$horario,'asignaturas'=>$asignaturas, 'horas'=>$horas]);
    }


    public static function buscarHorarios($id_grupo){
        $horarios = Horarios::find()->where(['id_grupo'=>$id_grupo])->orderBy('dia_semana, hora_dia')->all();
        
        $horarios_array = array();
        foreach ($horarios as $horario) {
            if($horario->actividad !=null)
            {
                $horarios_array[$horario->hora_dia][$horario->dia_semana] = $horario->actividad;
            }
            elseif ($horario->asignatura !=null) 
            {
                $horarios_array[$horario->hora_dia][$horario->dia_semana] = $horario->asignatura->nombre;
            }
        }
        for($i=1; $i<9;$i++){
            if (!array_key_exists($i, $horarios_array)) {
                $horarios_array[$i] = array();
            }
            for($j=1; $j<6;$j++){
                if (!array_key_exists($j, $horarios_array[$i])) {
                    $horarios_array[$i][$j] = null;
                }
            }
        }
        for($i =1; $i<9 ;$i++){
            $horarios_array[$i][0]=$i;
        }
        return $horarios_array;
    }
    
    public static function buscarHorasHorario(){
        $horas = array();
        $horas[1] = '7.15 – 7.30';
        $horas[2] = '7.30 – 8.15';
        $horas[3] = '8.15 - 9.00';
        $horas[4] = '9.00 - 9.15';
        $horas[5] = '9.15 - 9.45';
        $horas[6] = '9.45 - 10.30';
        $horas[7] = '10.30 - 11.15';
        $horas[8] = '11.15 - 11.30';
        $horas[9] = '11.30 - 12.00';
        
        return $horas;
    }

    public function actionAsignarHorario($id_grupo,$dia,$hora,$asignatura,$actividad){
        $horario = Horarios::find()
                ->where([
                        'id_grupo'=>$id_grupo
                        ,'dia_semana'=>$dia
                        ,'hora_dia'=>$hora
                        ])
                ->one();
        
        if($horario == null)
        {
            $horario = new Horarios();
            $horario->id_grupo = $id_grupo;
            $horario->dia_semana = $dia;
            $horario->hora_dia = $hora;
        }
        if(!is_numeric($asignatura) || $asignatura<=0 )
        {
            $asignatura = null;
        }
        else {
            $actividad = null;
        }
        
        $horario->id_asignatura = $asignatura;
        $horario->actividad = $actividad;
        
        if($horario->save())
        {
            Yii::$app->session->setFlash('mensaje',  'Horario actualizado');
        }
        else
        {
            Yii::$app->session->setFlash('mensaje',  'No se pudo actualizar el horario');
        }
    }
}