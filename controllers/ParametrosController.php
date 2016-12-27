<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Parametros;
use yii\helpers\ArrayHelper;
use app\models\GruposEstudiantes;

class ParametrosController extends Controller {
   
    public function beforeAction($action){
        if (Yii::$app->user->isGuest)
        {
            $this->redirect(['usuarios/login']);
        }
        if(in_array(!Yii::$app->user->identity->id_perfil, [1,2])){
            $this->redirect(['site/']);
        }
        return true;
    }
    
    public function actionIndex(){
        $entities = Parametros::find()->where(['editable' => '1'])->all();
        
        $array = ArrayHelper::toArray($entities);
        
        $parametros = array();
        
        foreach ($array as $row) {
            if(!isset($parametros[$row["codigo_parametro"]])) {
                
                $parametros[$row["codigo_parametro"]] = $row;
            }
        }
        return $this->render('index',['parametros'=>$parametros]);
    }
    
    public function actionModificarParametro($codigo, $valor) {
        if(!Yii::$app->request->isAjax){
            throw new \yii\web\NotFoundHttpException('Petición inválida');
        }
        $parametro = Parametros::find()->where(['codigo_parametro'=>$codigo])->one();
        
        if($parametro == null)
        {
            throw new \yii\web\NotFoundHttpException('El parámetro indicado no existe');   
        }
        if($valor ==='false')
        {
            $valor = false;
        }
        if($valor ==='true')
        {
            $valor = true;
        }
        $parametro->valor = $valor; 
                
        if($parametro->save(false))
        {
            Yii::$app->session->setFlash('mensaje',  'Se modificó correctamente el parámetro'); 
        }
        else{
            Yii::$app->session->setFlash('error',  'No se pudo modificar el parámetro.'); 
        }
        
        $data = Parametros::find()->asArray()->indexBy('codigo_parametro')->all();

        Yii::$app->cache->set('parametros', $data);
    }
    
    public function actionCierre(){
        $anio = Yii::$app->cache->get('parametros')['anioencurso']['valor'];
        $grupos_estudiantes = GruposEstudiantes::find()
                ->with('estudiante','grupo')
                ->innerJoin('estudiantes','estudiantes.id_estudiante = grupos_estudiantes.id_estudiante '
                        . ' and estudiantes.activo=1 '
                        . ' and grupos_estudiantes.anio = '.$anio)
                ->orderBy('id_grupo, estudiantes.apellidos')
                ->all();
        return $this->render('cierre',['matriculados'=>$grupos_estudiantes]);
    }
    
    public function actionEstadoEstudiante($id_grupo_estudiante, $estado) {
        $grupoest = GruposEstudiantes::find()->where(['id_grupo_estudiante'=>$id_grupo_estudiante])->one();
        $grupoest->estado = $estado;
        
        $grupoest->save();
    }
    
    public function actionCerrar(){
        $anio = Yii::$app->cache->get('parametros')['anioencurso']['valor'];
        $connection = \Yii::$app->db;
        $query = "UPDATE grupos_estudiantes set estado = 'P' WHERE estado = 'A' and anio = '".$anio."'";
        $cmd = $connection->createCommand($query);
        $cmd->execute();
        
        $anio = (int)$anio +1;
        
                
        self::actualizarParametro('anioencurso', $anio);
        self::actualizarParametro('matriculasactivas', '1');
        self::actualizarParametro('inscripcionesactivas', '1');
        self::actualizarParametro('aniomatricula', $anio);
        self::actualizarParametrosCache();
        return $this->redirect('parametros/index');
    }
    
    public static function actualizarParametrosCache(){
        $data = Parametros::find()->asArray()->indexBy('codigo_parametro')->all();
        Yii::$app->cache->set('parametros', $data);
    }
    
    public static function actualizarParametro($codigo, $valor){
        $param = Parametros::find()->where(['codigo_parametro'=>$codigo])->one();
        $param->valor = (string)$valor;
        $param->save();
    }
    
}