<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Estudiantes;
use app\models\Forms\FormFoto;
use app\models\Fichamedica;
use app\models\Fichapsicologica;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use app\controllers\UsuariosController;
use yii\web\Response;
use yii\helpers\Url;


class AcudienteController extends Controller{
        
    public function beforeAction($action){
        
        $this->layout = 'acudiente';
        
        if (Yii::$app->user->isGuest)
        {
            $this->redirect(['usuarios/login']);
        }
        $estudiante = Yii::$app->session->get('estudiante_acudiente');
        
        if($action->actionMethod !== 'actionSeleccionar' && (is_null($estudiante) || $estudiante ==''))
        {
            $this->redirect(['acudiente/seleccionar']);
            return false;
        }
        return true;
    }
    
    public function actionIndex(){
        $estudiante = Yii::$app->session->get('estudiante_acudiente');
        
        if(is_null($estudiante) || $estudiante ==''){
            return $this->redirect(['acudiente/seleccionar']);
        }
        else{
            return $this->redirect(['acudiente/estudiante']);
        }
    }
    
    public function actionEstudiante(){
        $id_estudiante = Yii::$app->session->get('estudiante_acudiente');
        
        $estudiante = Estudiantes::find()
                ->with('grupoActual', 'fichaMedica')
                ->where(['activo'=>1, 'id_estudiante'=>$id_estudiante])
                ->one();
        $logros = EstudiantesController::buscarLogrosEstudiante($id_estudiante);
        $horarios = GruposController::buscarHorarios($estudiante->grupoActual->id_grupo);
        $horas = GruposController::buscarHorasHorario();
        $cronograma = CronogramasController::buscarCronogramaGrupo($estudiante->grupoActual->id_grupo);
        return $this->render('estudiante',['estudiante'=>$estudiante,'logros'=>$logros,'horarios'=>$horarios, 'horas'=>$horas,'cronograma'=>$cronograma]);
    }
    
    public function actionSeleccionar($id_estudiante = null){
        $id_usuario = Yii::$app->user->identity->id_usuario;
        if($id_estudiante !== null)
        {
            $estudiante = Estudiantes::find()
                ->innerJoin('acudientes','acudientes.id_estudiante = estudiantes.id_estudiante'
                        . ' and acudientes.id_acudiente = '.$id_usuario
                        . ' and acudientes.id_estudiante = '.$id_estudiante)
                    ->where(['activo'=>1])
                ->one();
            if($estudiante !== null)
            {
               Yii::$app->session->set('estudiante_acudiente',$id_estudiante);
               return $this->redirect(['acudiente/estudiante']);
            }
        }
        
        $estudiantes = Estudiantes::find()
                ->with('grupoActual')
                ->innerJoin('acudientes','acudientes.id_estudiante = estudiantes.id_estudiante and acudientes.id_acudiente = '.$id_usuario)
                ->where(['activo'=>1])
                ->all();
        
        if(count($estudiantes)===0){
            Yii::$app->session->setFlash('mensaje','No tiene permiso para acceder.');
            return $this->redirect(['usuarios/logout']);
        }
        
        if(count($estudiantes)===1){
            Yii::$app->session->set('estudiante_acudiente',$estudiantes[0]->id_estudiante);
            return $this->redirect(['acudiente/estudiante']);
        }
        
        return $this->render('seleccion',['estudiantes'=>$estudiantes]);
    }
    
    public function actionFoto(){
        $model = new FormFoto();

        $id = Yii::$app->session->get('estudiante_acudiente');
        
        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $fileName= $model->upload();
            if ($fileName !== false) {
                \Yii::$app->db->createCommand("UPDATE estudiantes SET foto=:foto WHERE id_estudiante=:id")
                ->bindValue(':foto', $fileName)
                ->bindValue(':id', $id)
                ->execute();
                Yii::$app->session->setFlash('mensaje','Se guardó la imagen correctamente');
            }
        }
        $estudiante = Estudiantes::find()->where(['id_estudiante'=>$id])->one();
        return $this->render('foto', ['model' => $model, 'estudiante'=>$estudiante]);
    }
    
    public function actionDatosBasicos() {
        $id = Yii::$app->session->get('estudiante_acudiente');
        $estudiante = Estudiantes::find()->where(['id_estudiante'=>$id])->one();
        
        if($estudiante->load(Yii::$app->request->post())){
            if($estudiante->save()){
                Yii::$app->session->setFlash('mensaje','Estudiante modificado correctamente');
            }
            else{
                Yii::$app->session->setFlash('error','Ocurrió un problema al intentar modificar el estudiante');
            }
            return $this->redirect(['acudiente/estudiante']);
        }
        
        return $this->render('//estudiantes/editar',['formestudiante'=>$estudiante]);
    }
    
    public function actionFichaMedica($id) {
        $estudiante = Estudiantes::find()->where(['id_estudiante'=>$id])->one();
        if($estudiante == null)
        {
            throw new \yii\web\NotFoundHttpException('No se encontró el estudiante indicado');
        }
        $model = Fichamedica::find()->where(['id_estudiante'=>$id])->one();
        if($model === null)
        {
            $model = new Fichamedica;
            $model->id_estudiante = $id;
        }
        if ($model->load(Yii::$app->request->post())){
            if($model->save())
            {
                Yii::$app->session->setFlash('mensaje',  'Ficha médica actualizada.');  
                return $this->redirect(Url::toRoute(['acudiente/estudiante']));
            }
            else
            {
                Yii::$app->session->setFlash('error',  'No se pudo actualizar Ficha médica.');  
            }
        }
        
        return $this->render('//matricula/ficha_medica' , ['model'=>$model,'estudiante'=>$estudiante]);
    }
    
    function actionFichaPsicologica($id) {
        $estudiante = Estudiantes::find()->where(['id_estudiante'=>$id])->one();
        if($estudiante == null)
        {
            throw new \yii\web\NotFoundHttpException('No se encontró el estudiante indicado');
        }
        $model = Fichapsicologica::find()->where(['id_estudiante'=>$id])->one();
        if($model === null)
        {
            $model = new Fichapsicologica;
            $model->id_estudiante = $id;
        }
        if ($model->load(Yii::$app->request->post()) ){
            if($model->save())
            {
                Yii::$app->session->setFlash('mensaje',  'Ficha psicológica actualizada.');  
                return $this->redirect(Url::toRoute(['acudiente/estudiante']));
            }
            else
            {
                Yii::$app->session->setFlash('error',  'No se pudo actualizar Ficha psicológica.');  
            }
        }
        
        return $this->render('//matricula/ficha_psicologica' , ['model'=>$model,'estudiante'=>$estudiante]);
    }
}