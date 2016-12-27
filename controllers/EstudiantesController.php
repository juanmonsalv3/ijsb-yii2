<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Estudiantes;
use app\models\Forms\FormSearchEstudiantes;
use app\models\Forms\FormSearchIndicadores;
use app\models\Fichamedica;
use app\models\Fichapsicologica;
use app\models\GruposEstudiantes;
use app\models\Indicadores;
use app\models\IndicadoresEstudiantes;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use app\models\forms\FormFoto;
use yii\web\UploadedFile;

class EstudiantesController extends Controller {
   
    public function beforeAction($action){
        if (Yii::$app->user->isGuest)
        {
            $this->redirect(['usuarios/login']);
        }
        return true;
    }
    
    public function actionNuevo(){
        $form = new Estudiantes;
        
        if($form->load(Yii::$app->request->post()))
        {
            if($form->save())
            {
                Yii::$app->session->setFlash('mensaje',  'Estudiante registrado exitosamente.'); 
            }
            else
            {
                Yii::$app->session->setFlash('error',  'No se ha podido registrar el estudiante.'); 
                $form->getErrors();
            }
        }
        return $this->render('nuevo',['form'=>$form]);
    }
    
    public function actionIndex(){
        $form = new FormSearchEstudiantes;
        
        $anio = Yii::$app->cache->get('parametros')['anioencurso']['valor'];
        $query = Estudiantes::find()
                ->with('grupoActual')
                ->innerJoin('grupos_estudiantes','estudiantes.id_estudiante = grupos_estudiantes.id_estudiante and anio = '.$anio)
                ->where(['activo'=>1]);
        
        if($form->load(Yii::$app->request->get())){
            if($form->grupo != null){
                $query->andWhere(['id_grupo'=>$form->grupo]);
            }
            if($form->nombre != null){
                $query->andWhere("nombres like '%".$form->nombre."%' or apellidos like '%".$form->nombre."%'");
            }
        }
        $query->orderBy('apellidos');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10],
        ]);
        return $this->render('lista',['form'=>$form, 'dataProvider'=>$dataProvider] );
    }
    
    public function actionHistorial($id) {
        $estudiante = Estudiantes::find()->with('gruposEstudiantes.grupo')->where(['id_estudiante'=>$id])->one();
        
        if($estudiante== null){
             throw new \yii\web\NotFoundHttpException('No se encuentra el estudiante solicitado');
        }
        return $this->render('historial',['estudiante'=>$estudiante]);
    }
    
    public function actionIndicadores($id) {
        $formsearch = new FormSearchIndicadores;
        
        if(!$formsearch->load(Yii::$app->request->get())){
            $formsearch->periodo = Yii::$app->cache->get('parametros')['periodoencurso']['valor'];
            $formsearch->id_dimension = 1;
        }
        
        $estudiantegrupo = GruposEstudiantes::find()
                ->with('estudiante','grupo')
                ->where(['id_estudiante'=>Html::encode($id),'anio' =>Yii::$app->cache->get('parametros')['anioencurso']['valor']])->one();
        
        
        $indicadoresxasignar= Indicadores::find()
                ->with('dimension','grupo')
                ->leftJoin('indicadores_estudiantes', 'indicadores_estudiantes.id_indicador = indicadores.id_indicador and indicadores_estudiantes.id_estudiante_grupo = '.$estudiantegrupo->id_grupo_estudiante)
                ->where('indicadores_estudiantes.id_indicador_estudiante is null')
                ->andWhere('indicadores.id_grupo = '.$estudiantegrupo->id_grupo)
                ->andWhere('indicadores.id_dimension = '.$formsearch->id_dimension)
                ->andWhere('indicadores.periodo = '.$formsearch->periodo);
        
        $indicadoresasignados = IndicadoresEstudiantes::find()
                ->with('indicador')
                ->innerJoin('indicadores','indicadores_estudiantes.id_indicador = indicadores.id_indicador')
                ->where(['id_estudiante_grupo'=>$estudiantegrupo->id_grupo_estudiante])
                ->andWhere('indicadores.id_dimension = '.$formsearch->id_dimension)
                ->andWhere('indicadores.periodo = '.$formsearch->periodo);
       
        return $this->render('indicadores',
                ['formsearch'=>$formsearch,
                    'estudiantegrupo'=>$estudiantegrupo,
                    'indicadoresxasignar'=>$indicadoresxasignar,
                    'indicadoresasignados'=>$indicadoresasignados,
                ]);
    }
    
    public function actionLogros($id){
        $anio = Yii::$app->cache->get('parametros')['anioencurso']['valor'];
        $est_grp = GruposEstudiantes::find()->with('estudiante')->where(['id_estudiante'=>$id, 'anio'=>$anio])->one();
        if($est_grp === null)
        {
            throw new \yii\web\NotFoundHttpException('El estudiante indicado no se encuentra matriculado en el año en curso');
        }
        
        $connection = \Yii::$app->db;
        $formsearch = new FormSearchIndicadores;
        
        $formsearch->periodo = Yii::$app->cache->get('parametros')['periodoencurso']['valor'];
        $formsearch->id_dimension = 1;
        
        if (Yii::$app->request->isGet) {
            $formsearch->load(Yii::$app->request->get());
        }
        
        $query = 'SELECT i.id_indicador, descripcion, cumple '
                        . ' FROM (SELECT * FROM indicadores WHERE periodo = '.$formsearch->periodo.' and id_grupo = '.$est_grp->id_grupo.' and id_dimension = '.$formsearch->id_dimension.') AS i'
                        . ' LEFT JOIN indicadores_estudiantes ie on i.id_indicador = ie.id_indicador'
                        . ' AND ie.id_estudiante_grupo = '.$est_grp->id_grupo_estudiante.' or ie.id_estudiante_grupo is null';
        $query .= ' ORDER BY descripcion';
        
        $cmd = $connection->createCommand($query);
        $indicadores = $cmd->queryAll();
        
         return $this->render('logros',['formsearch'=>$formsearch,'indicadores'=>$indicadores, 'estudiantegrupo'=>$est_grp]);
    }
    
    public function actionIndicadorEstudiante($id_estudiante_grupo, $id_indicador, $cumple){
        if(!Yii::$app->request->isAjax){
            throw new \yii\web\NotFoundHttpException();
        }
        
        $indicadorestudiante = IndicadoresEstudiantes::find()
                ->where(['id_estudiante_grupo'=>$id_estudiante_grupo,'id_indicador'=>$id_indicador])
                ->one();
        if($cumple ==2){
            if($indicadorestudiante->delete())
            {
                $items = ['status'=>true, 'msg'=>'Indicador modificado.'];
                return \yii\helpers\Json::encode($items);
            }
            return;
        }
        
        if($indicadorestudiante == null){
            $indicadorestudiante = new IndicadoresEstudiantes;
            $indicadorestudiante->id_estudiante_grupo = $id_estudiante_grupo;
            $indicadorestudiante->id_indicador = $id_indicador;
            $indicadorestudiante->anio = Yii::$app->cache->get('parametros')['anioencurso']['valor'];
        }
        $indicadorestudiante->cumple = (int)$cumple;
        
        if($indicadorestudiante->save(false))
        {
            $items = ['status'=>true, 'msg'=>'Se asignó correctamente el indicador.'];
        }
        else{
            $items = ['status'=>false, 'msg'=>'No se pudo asignar el indicador.'];
        }
        return \yii\helpers\Json::encode($items);
    }
    
    public function actionAsignarIndicador($id_estudiante_grupo, $id_indicador, $cumple) {
        if(!Yii::$app->request->isAjax){
            throw new \yii\web\NotFoundHttpException();
        }
        
        $indicadorestudiante = IndicadoresEstudiantes::find()
                ->where(['id_estudiante_grupo'=>$id_estudiante_grupo,'id_indicador'=>$id_indicador])
                ->one();
        if($indicadorestudiante == null){
            $indicadorestudiante = new IndicadoresEstudiantes;
            $indicadorestudiante->id_estudiante_grupo = $id_estudiante_grupo;
            $indicadorestudiante->id_indicador = $id_indicador;
            $indicadorestudiante->anio = Yii::$app->cache->get('parametros')['anioencurso']['valor'];
        }
        $indicadorestudiante->cumple = (int)$cumple;
        
        if($indicadorestudiante->save(false))
        {
            $items = ['status'=>true, 'msg'=>'Se asignó correctamente el indicador.'];
            Yii::$app->session->setFlash('mensaje',  'Se asignó correctamente el indicador.'); 
        }
        else{
            $items = ['status'=>false, 'msg'=>'No se pudo asignar el indicador.'];
            Yii::$app->session->setFlash('error',  'No se pudo asignar el indicador al estudiante.'); 
        }
        return \yii\helpers\Json::encode($items);
    }
    
    public function actionModificarIndicador($id_indicador_estudiante, $cumple) {
        if(!Yii::$app->request->isAjax){
            throw new \yii\web\NotFoundHttpException();
        }
        
        $indicadorestudiante = IndicadoresEstudiantes::find()
                ->where(['id_indicador_estudiante'=>$id_indicador_estudiante])
                ->one();
            
        $indicadorestudiante->cumple = (int)$cumple;
        
        if($indicadorestudiante->save(false))
        {
            $items = ['status'=>true, 'msg'=>'Se asignó correctamente el indicador.'];
            Yii::$app->session->setFlash('mensaje',  'Se modificó correctamente el indicador.'); 
        }
        else{
            $items = ['status'=>false, 'msg'=>'No se pudo asignar el indicador.'];
            Yii::$app->session->setFlash('error',  'No se pudo modificar el indicador al estudiante.'); 
        }
        return \yii\helpers\Json::encode($items);
    }
    
    public function actionEstudiante($id){
        $estudiante = Estudiantes::find()
                ->with('grupoActual','fichaPsicologica','fichaMedica','acudientes')
                ->where(['id_estudiante'=>$id, 'activo'=>1])
                ->one();
        
        $logros = EstudiantesController::buscarLogrosEstudiante($id);
        return $this->render('estudiante',['estudiante'=>$estudiante,'logros'=>$logros]);
    }
    
    public function actionAcudientes($id){
        $estudiante = Estudiantes::find()
                ->with('grupoActual', 'idAcudientes','idAcudientes.acudiente','idAcudientes.parentescoEntitie')
                ->where(['id_estudiante'=>$id, 'activo'=>1])
                ->one();
        return $this->render('acudientes',['estudiante'=>$estudiante]);
    }
    
    public function actionNuevoAcudiente($id){
        $form = new \app\models\Forms\FormNuevoAcudiente();
        
        $request = \Yii::$app->getRequest();
        
        if ($request->isPost && $form->load($request->post())) {
            
            $registroexitoso = AcudientesController::registrarAcudiente($form);
            
            if($registroexitoso){
                Yii::$app->session->setFlash('mensaje','Acudiente Registrado');
                return $this->redirect(['estudiantes/acudientes','id'=>$id]);
            }
            else{
                $form->getErrors();
            }
        }
        
        $form->id_estudiante = $id;
        
        return $this->render('nuevo-acudiente',['model'=>$form]);
    }
    
    public function actionBorrar($id){
        $estudiante = Estudiantes::find()->where(['id_estudiante'=>$id])->one();
        
        if($estudiante== null){
             throw new \yii\web\NotFoundHttpException('No se encuentra el estudiante solicitado');
        }
        try{
            if($estudiante->delete()){
                Yii::$app->session->setFlash('mensaje',  'Se eliminó correctamente el estudiante indicado.'); 
            }
        }  catch (yii\db\IntegrityException $e){
            $estudiante->activo = 0;
            if($estudiante->save())
            {
                Yii::$app->session->setFlash('mensaje',  'Se eliminó correctamente el estudiante indicado.'); 
            }
            else
            {
                Yii::$app->session->setFlash('error',  'No se pudo borrar el estudiante indicado.'); 
            }
        }
        return $this->redirect(['estudiantes/']);
    }
    
    public function actionEditar($id){
        $formestudiante = Estudiantes::findOne($id);
        
        if($formestudiante == null){
            throw new \yii\web\NotFoundHttpException('No se encuentra el estudiante indicado');
        }
        
        if($formestudiante->load(Yii::$app->request->post()))
        {
            if($formestudiante->save())
            {
                Yii::$app->session->setFlash('mensaje',  'Datos modificados correctamente.'); 
                return $this->redirect(['estudiantes/estudiante','id'=>$id]);
            }
            else
            {
                Yii::$app->session->setFlash('error',  'No se pudo modificar el estudiante.'); 
            }
        }
        
        return $this->render('editar',['formestudiante'=>$formestudiante]);
    }
    
    public function actionFoto($id){
        $model = new FormFoto();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $fileName= $model->upload();
            if ($fileName !== false) {
                \Yii::$app->db->createCommand("UPDATE estudiantes SET foto=:foto WHERE id_estudiante=:id")
                ->bindValue(':foto', $fileName)
                ->bindValue(':id', $id)
                ->execute();
                return;
            }
        }
        return $this->render('foto', ['model' => $model]);
    }
    
    public static function buscarLogrosEstudiante($id_estudiante, $periodo= null, $anio = null){
        if($anio == null){
            $anio = Yii::$app->cache->get('parametros')['anioencurso']['valor'];
        }
        if($periodo == null){
            $periodo = Yii::$app->cache->get('parametros')['periodoencurso']['valor'];
        }
        $estudiante_grupo = GruposEstudiantes::find()->where(['id_estudiante'=>$id_estudiante, 'anio'=>$anio])->one();
        if($estudiante_grupo === null){
            return null;
        }
        $logros = IndicadoresEstudiantes::find()
                ->with('indicador')
                ->innerJoin('indicadores','indicadores_estudiantes.id_indicador = indicadores.id_indicador'
                        . ' and indicadores.id_grupo = '. $estudiante_grupo->id_grupo
                        . ' and indicadores.periodo = '.$periodo)
                ->where(['id_estudiante_grupo'=>$estudiante_grupo->id_grupo_estudiante])
                ->orderBy('indicadores.id_dimension')
                ->all()
                ;
        return $logros;
    }
    
    public static function buscarLogrosIndicadores($id_estudiante, $periodo = null){
        $anio = Yii::$app->cache->get('parametros')['anioencurso']['valor'];
        $est_grp = GruposEstudiantes::find()->with('estudiante')->where(['id_estudiante'=>$id_estudiante, 'anio'=>$anio])->one();
        if($est_grp === null)
        {
            throw new \yii\web\NotFoundHttpException('El estudiante indicado no se encuentra matriculado en el año en curso');
        }
        
        $connection = \Yii::$app->db;
        
        if($periodo == null){
            $periodo = Yii::$app->cache->get('parametros')['periodoencurso']['valor'];
        }
        
        $query = 'SELECT i.id_indicador, i.descripcion, cumple, d.nombre as dimension '
                        . ' FROM (SELECT * FROM indicadores WHERE periodo = '.$periodo.' and id_grupo = '.$est_grp->id_grupo.' ) AS i'
                        . ' LEFT JOIN indicadores_estudiantes ie on i.id_indicador = ie.id_indicador'
                        . ' AND (ie.id_estudiante_grupo = '.$est_grp->id_grupo_estudiante.' or ie.id_estudiante_grupo is null)'
                        . ' LEFT JOIN dimensiones d on i.id_dimension = d.id_dimension';
        $query .= ' ORDER BY d.nombre, descripcion';
        
        
        
        $cmd = $connection->createCommand($query);
        $indicadores = $cmd->queryAll();
        
         return $indicadores;
    }
    
    public function actionLogrosPartial($periodo, $id_estudiante){
        $logros = EstudiantesController::buscarLogrosEstudiante($id_estudiante,$periodo);
        
        return $this->renderAjax('//partials/logrosestudiante_view',['logros'=>$logros]);
    }
    
    public function actionFichaMedica($id){
        $estudiante = Estudiantes::find()->where(['id_estudiante'=>$id])->one();
        if($estudiante == null){
            throw new \yii\web\NotFoundHttpException('No se encontró el estudiante indicado');
        }
        $model = Fichamedica::find()->where(['id_estudiante'=>$id])->one();
        if($model === null){
            $model = new Fichamedica;
            $model->id_estudiante = $id;
        }
        if ($model->load(Yii::$app->request->post())){
            if($model->save()){
                Yii::$app->session->setFlash('mensaje',  'Ficha médica actualizada.');  
                return $this->redirect(['estudiantes/estudiante', 'id'=>$id]);
            }
            else{
                Yii::$app->session->setFlash('error',  'No se pudo actualizar Ficha médica.');  
            }
        }
        
        return $this->render('ficha-medica' , ['model'=>$model,'estudiante'=>$estudiante]);
    }
    
    public function actionFichaPsicologica($id) {
        $estudiante = Estudiantes::find()->where(['id_estudiante'=>$id])->one();
        if($estudiante == null){
            throw new \yii\web\NotFoundHttpException('No se encontró el estudiante indicado');
        }
        $model = Fichapsicologica::find()->where(['id_estudiante'=>$id])->one();
        if($model === null){
            $model = new Fichapsicologica;
            $model->id_estudiante = $id;
        }
        if ($model->load(Yii::$app->request->post()) ){
            if($model->save()){
                Yii::$app->session->setFlash('mensaje',  'Ficha psicológica actualizada.');  
                return $this->redirect(['estudiantes/estudiante', 'id'=>$id]);
            }
            else{
                Yii::$app->session->setFlash('error',  'No se pudo actualizar Ficha psicológica.');  
            }
        }
        return $this->render('ficha-psicologica' , ['model'=>$model,'estudiante'=>$estudiante]);
    }
}
