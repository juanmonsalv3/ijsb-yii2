<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use app\models\Forms\SearchCronogramas;
use app\models\Grupos;
use app\models\CronogramaActividades;
use app\models\ActividadesGrupos;

class CronogramasController extends Controller
{
    public function actionIndex() {
        $form = new SearchCronogramas;
        
        $anio = Yii::$app->cache->get('parametros')['anioencurso']['valor'];
        
        $actividadesQuery = CronogramaActividades::find()->with('grupos')->where('year(fecha) = '.$anio);
        if($form->load(Yii::$app->request->get()))
        {
            if($form->id_grupo != null)
            {
                $actividadesQuery
                        ->innerJoin('actividades_grupos','cronograma_actividades.id_actividad = actividades_grupos.id_actividad '
                                . 'and actividades_grupos.id_grupo = '.$form->id_grupo);
            }
        }
        $actividadesEntities = $actividadesQuery->orderBy('fecha ASC')->all();
        
        
        
        $actividades = array();
        
        foreach($actividadesEntities as $entitie)
        {
            $grupos = '';
            foreach($entitie->grupos as $grupo){
                $grupos .= $grupo->id_grupo.';';
            }
            
            $actividades[(int)date("m",strtotime($entitie->fecha))][] = array('id_actividad'=>$entitie->id_actividad,'fecha'=>$entitie->fecha, 'descripcion'=>$entitie->descripcion, 'grupos'=>$grupos);
            
        }
        $grupos = ArrayHelper::map(Grupos::find()->all(), 'id_grupo', 'nombre');
        return $this->render('index',['form'=>$form,'actividades'=>$actividades,'grupos'=>$grupos]);
    }
    
    public function actionAgregarActividad($id_actividad, $fecha, $descripcion, $grupos){
        
        $actividad = new CronogramaActividades;
        if($id_actividad !=0)
        {
            $actividad = CronogramaActividades::find()->where(['id_actividad'=>$id_actividad])->one();
        }
        $actividad->fecha = $fecha;
        $actividad->descripcion = $descripcion;
        
        $arrayGrupos = explode(";",$grupos);
        
        $actividad->save();
        
        ActividadesGrupos::deleteAll(['id_actividad'=>$actividad->id_actividad]);
        
        foreach ($arrayGrupos as $grupo) {
            $actividadGrupo = new ActividadesGrupos;
            $actividadGrupo->id_grupo = $grupo;
            $actividadGrupo->id_actividad = $actividad->id_actividad;
            
            $actividadGrupo->save();
        }
        
        Yii::$app->session->setFlash('mensaje',  'Actividad Registrada.'); 
    }
    
    public function actionBorrarActividad($id_actividad) {
        ActividadesGrupos::deleteAll(['id_actividad'=>$id_actividad]);
        CronogramaActividades::deleteAll(['id_actividad'=>$id_actividad]);
        Yii::$app->session->setFlash('mensaje',  'Actividad Eliminada.'); 
    }
    
    public static function buscarCronogramaGrupo($id_grupo){
        $anio = Yii::$app->cache->get('parametros')['anioencurso']['valor'];
        $cronogramas = \app\models\CronogramaActividades::find()
                ->innerJoin('actividades_grupos'
                        , 'actividades_grupos.id_actividad = cronograma_actividades.id_actividad'
                        . ' and year(fecha) = '.$anio
                        . ' and fecha > curdate()'
                        . ' and actividades_grupos.id_grupo = '.$id_grupo)
                ->orderBy('fecha ASC')
                ->all();
        
        $actividades = array();
        
        foreach($cronogramas as $entitie)
        {
            $grupos = '';
            foreach($entitie->grupos as $grupo){
                $grupos .= $grupo->id_grupo.';';
            }
            
            $actividades[(int)date("m",strtotime($entitie->fecha))][] = array('id_actividad'=>$entitie->id_actividad,'fecha'=>$entitie->fecha, 'descripcion'=>$entitie->descripcion, 'grupos'=>$grupos);
            
        }
        return $actividades;
    }
}