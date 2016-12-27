<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\EstudiantesMatricula;
use app\models\Estudiantes;
use app\models\Fichamedica;
use app\models\Fichapsicologica;
use app\models\GruposEstudiantes;
use app\models\Forms\FormSearchEstudiantes;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use app\models\Grupos;
use app\models\Usuarios;
use app\models\Acudientes;
use yii\data\ActiveDataProvider;

class MatriculaController extends Controller{
    
    public function beforeAction($action){
        if (Yii::$app->user->isGuest)
        {
            $this->redirect(['usuarios/login']);
        }
        return true;
    }
    
    public function actionIndex(){
        return $this->redirect(Url::toRoute(['matricula/busqueda']));
    }
    
    public function actionBusqueda(){
        
        $form = new FormSearchEstudiantes;
        
        $grupos = ArrayHelper::map(Grupos::find()->all(),'id_grupo','nombre');
        
        $aniomatricula = Yii::$app->cache->get('parametros')['aniomatricula']['valor'];
        $table = Estudiantes::find()
                ->leftJoin('grupos_estudiantes','estudiantes.id_estudiante = grupos_estudiantes.id_estudiante and grupos_estudiantes.anio = "'.$aniomatricula.'"')
                ->where('grupos_estudiantes.id_estudiante is null')
                ->andWhere('activo = 1')
                ->with('inscripcion','gruposEstudiantes');
        
        if ($form->load(Yii::$app->request->get())){
            $table->andWhere("nombres like '%".$form->nombre."%' or apellidos like '%".Html::encode($form->nombre)."%'");
        }
        
        $count = clone $table;
        $pages = new Pagination([
            "pageSize" => 10,
            "totalCount" => $count->count(),
        ]);
        $model = $table->OrderBy('apellidos')
                ->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        
        return $this->render('busqueda', ['form'=>$form , 'model'=>$model , 'pages'=>$pages, 'grupos'=>$grupos]);
    }
    
    public function actionMatricular($id,$id_grupo){
        $form = EstudiantesMatricula::find()->where(['id_estudiante'=>$id])->one();
        if($form == null)
        {
            Yii::$app->session->setFlash('error',  'No se encontró el estudiante.');  
            return $this->redirect(Url::toRoute(['matricula/index']));
        }
        $form->proximo_grupo = $id_grupo;
        if ($form->load(Yii::$app->request->post())){
            $transaction = Yii::$app->db->beginTransaction();
            
            $estudiante = Estudiantes::find()->where(['id_estudiante'=>$form->id_estudiante])->one();
            $estudiante->nombres = strtoupper($form->nombres);
            $estudiante->apellidos = strtoupper($form->apellidos);
            $estudiante->sexo = $form->sexo;
            $estudiante->fecha_nacimiento = $form->ciudad_nacimiento;
            $anio = Yii::$app->cache->get('parametros')['aniomatricula']['valor'];
            
            $estudiante_grupo = GruposEstudiantes::find()->where(['id_estudiante'=>$form->id_estudiante,'id_grupo'=>$form->proximo_grupo,'anio'=>$anio])->one();
            if($estudiante_grupo==null)
            {
                $estudiante_grupo = new GruposEstudiantes;
                $estudiante_grupo->anio = $anio;
                $estudiante_grupo->id_estudiante = $form->id_estudiante;
                $estudiante_grupo->id_grupo = $form->proximo_grupo;
                $estudiante_grupo->estado = 'A';
            }
            if($estudiante->save() && $estudiante_grupo->save()){
                Yii::$app->session->setFlash('mensaje',  'Estudiante Matriculado correctamente');  
                $transaction->commit();
                return $this->redirect(Url::toRoute(['matricula/ficha-medica', 'id'=>$id]));
            }
            else{
                Yii::$app->session->setFlash('error',  'No se pudo matricular el estudiante.');  
                $transaction->rollBack();
            }
        }
        $grupos = ArrayHelper::map(Grupos::find()->all(),'id_grupo','nombre');
        return $this->render('datos_basicos', ['form'=>$form,'grupos'=>$grupos]);    
    }
    
    public function actionAcudientes($id){
        $query = Usuarios::find()
                ->with('acudiente','acudiente.parentescoEntitie')
                ->innerJoin('acudientes','acudientes.id_acudiente = usuarios.id_usuario and acudientes.id_estudiante = '.$id);
       
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        
        return $this->render('acudientes',['acudientes'=>$dataProvider, 'id'=>$id]);
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
                return $this->redirect(Url::toRoute(['matricula/ficha-psicologica', 'id'=>$id]));
            }
            else
            {
                Yii::$app->session->setFlash('error',  'No se pudo actualizar Ficha médica.');  
            }
        }
        
        return $this->render('ficha_medica' , ['model'=>$model,'estudiante'=>$estudiante]);
    }
    
    public function actionFichaPsicologica($id) {
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
                return $this->redirect(['matricula/acudientes', 'id'=>$id]);
            }
            else
            {
                Yii::$app->session->setFlash('error',  'No se pudo actualizar Ficha psicológica.');  
            }
        }
        return $this->render('ficha_psicologica' , ['model'=>$model,'estudiante'=>$estudiante]);
    }
    
    public function actionNuevoAcudiente($id){
        $form = new \app\models\Forms\FormNuevoAcudiente();
        
        $request = \Yii::$app->getRequest();
        
        if ($request->isPost && $form->load($request->post())) {
            
            $registroexitoso = AcudientesController::registrarAcudiente($form);
            
            if($registroexitoso){
                Yii::$app->session->setFlash('mensaje','Acudiente Registrado');
                return $this->redirect(['matricula/acudientes','id'=>$id]);
            }
            else{
                $form->getErrors();
            }
        }
        
        $form->id_estudiante = $id;
        
        return $this->render('nuevo-acudiente',['model'=>$form]);
    }
}
