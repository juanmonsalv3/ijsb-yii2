<?php

namespace app\controllers;

use Yii;
use app\models\Inscripciones;
use app\models\Estudiantes;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Forms\FormSearchInscripciones;
use yii\data\Pagination;

/**
 * InscripcionesController implements the CRUD actions for Inscripciones model.
 */
class InscripcionesController extends Controller
{
    public function beforeAction($action){
        if (Yii::$app->user->isGuest)
        {
            $this->redirect(['usuarios/login']);
        }
        return true;
    }
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    
    public function actionRechazar($id){
        $inscripcion = Inscripciones::find()->where(['id_solicitud'=>$id])->one();
        $estudiante = Estudiantes::find()->where(['id_inscripcion'=>$id])->one();
        if($estudiante == null){
            self::crearEstudianteInscrito($inscripcion);
            $estudiante = Estudiantes::find()->where(['id_inscripcion'=>$id])->one();
        }
        $estudiante->activo = 0;
        $inscripcion->estado_solicitud = 0;
        $transaction = Yii::$app->db->beginTransaction();
        if($inscripcion->save() && $estudiante->save()){
            $transaction->commit();
            Yii::$app->session->setFlash('mensaje',  'Se marcó la solicitud como rechazada.');
        }
        else {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error',  'No se pudo marcar la solicitud como rechazada.');  
        }
        
        return $this->redirect(Url::toRoute(['inscripciones/view', 'id'=>$id]));
    }
    
    public function actionAprobar($id){
        $inscripcion = Inscripciones::find()->where(['id_solicitud'=>$id])->one();
        $estudiante = Estudiantes::find()->where(['id_inscripcion'=>$id])->one();
        if($estudiante == null){
            self::crearEstudianteInscrito($inscripcion);
            $estudiante = Estudiantes::find()->where(['id_inscripcion'=>$id])->one();
        }
        $estudiante->activo = 1;
        $inscripcion->estado_solicitud = 1;
        $transaction = Yii::$app->db->beginTransaction();
        if($inscripcion->save() && $estudiante->save()){
            $transaction->commit();
            Yii::$app->session->setFlash('mensaje',  'Se marcó la solicitud como aprobada.');
        }
        else {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error',  'No se pudo marcar la solicitud como aprobada.');  
        }
        
        return $this->redirect(Url::toRoute(['inscripciones/view', 'id'=>$id]));
    }
    
    
    /**
     * Lists all Inscripciones models.
     * @return mixed
     */    
    public function actionIndex(){
        $form = new FormSearchInscripciones;
        $form->mes=6;
        $table = new Inscripciones;
        
        if ($form->load(Yii::$app->request->get())){
            $whereestado='';
            if($form->estado == '0'){
                $whereestado = "estado_solicitud = 0";
            }
            else if($form->estado =='1'){
                $whereestado = "estado_solicitud = 1";
            }
            $wheregrupo =((int)$form->id_grupo)>0 ? 'id_grupo = '.Html::encode($form->id_grupo) : '';
            
            $table = Inscripciones::find()->with('grupo')
                                            ->where('fecha_registro > date_sub(CURDATE(), INTERVAL :meses MONTH)')
                                            ->andWhere($whereestado)
                                            ->andWhere($wheregrupo)
                                            ->addParams([':meses' => (int)Html::encode($form->mes),])
                                            ->orderBy(['fecha_registro'=>'ASC']);
        }
        else{
            $table = Inscripciones::find()->with('grupo')
                                            ->where('fecha_registro > date_sub(CURDATE(), INTERVAL :meses MONTH)')
                                            ->addParams([':meses' => (int)Html::encode($form->mes),])
                                            ->orderBy(['fecha_registro'=>'ASC']);
        }
        $count = clone $table;
        $pages = new Pagination(["pageSize" => 10,"totalCount" => $count->count()]);
        $model = $table->offset($pages->offset)->limit($pages->limit)->all();
        
        return $this->render('index',['form'=>$form, "model" => $model,"pages" => $pages]);
    }
    
    public function actionView($id){
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionNueva(){
        $inscripcionesActivas = Yii::$app->cache->get('parametros')['inscripcionesactivas']['valor'];
        
        if($inscripcionesActivas != 1){
            Yii::$app->session->setFlash('mensaje',  'El período de inscripciones se encuentra inactivo.');  
            return $this->redirect(['inscripciones/index']);
        }
        
        $model = new Inscripciones();

        if ($model->load(Yii::$app->request->post())) {
            $model->fecha_registro = \date("Y-m-d");
            $model->estado_solicitud = 1;
            
            if(!self::guardarInscripcion($model)){
                Yii::$app->session->setFlash('error',  'No se pudo guardar la solicitud.');  
                return $this->render('create', ['model' => $model]);
            }  
            Yii::$app->session->setFlash('mensaje',  'Solicitud guardada correctamente.');
            return $this->redirect(['view', 'id' => $model->id_solicitud]);
        }
        return $this->render('create', ['model' => $model]);
    }
    
    private static function guardarInscripcion($model){
        $transaction = Yii::$app->db->beginTransaction();
        if($model->save()){
            if(self::crearEstudianteInscrito($model)){
                $transaction->commit();  
                return true;
            }             
        }
        $transaction->rollBack();
        return false;
    }
    
    private static function crearEstudianteInscrito($model){
        $estudiante = new Estudiantes;

        $estudiante->nombres = $model->nombres;
        $estudiante->apellidos = $model->apellidos;
        $estudiante->fecha_nacimiento = $model->fecha_nacimiento;
        $estudiante->ciudad_nacimiento = $model->ciudad_nacimiento;
        $estudiante->id_inscripcion = $model->id_solicitud;
        $estudiante->activo = $model->estado_solicitud;
        $estudiante->sexo = $model->sexo;
        if($estudiante->save()){
            return true;
        }
        return false;
    }

    /**
     * Finds the Inscripciones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Inscripciones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Inscripciones::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
