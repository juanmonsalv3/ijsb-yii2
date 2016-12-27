<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\Html; 
use yii\data\Pagination;
use app\models\Dimensiones;
use app\models\Forms\FormDimensiones;
use app\models\Forms\FormSearchIndicadores;
use app\models\Indicadores;


class IndicadoresController extends Controller
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
        $model = new FormSearchIndicadores();
        $indicadores = Indicadores::find()
                ->with(['grupo','dimension','periodoo'])
                ->where('1=1');
        
        if ($model->load(Yii::$app->request->get())) { 
            if($model->id_grupo > 0 && $model->id_grupo != null )
            {
                $indicadores = $indicadores->andWhere(['id_grupo'=>$model->id_grupo]);
            }
            if($model->periodo > 0 && $model->periodo != null )
            {
                $indicadores = $indicadores->andWhere(['periodo' => $model->periodo]);
            }
            if($model->id_dimension > 0 && $model->id_dimension != null )
            {
                $indicadores = $indicadores->andWhere(['id_dimension' => $model->id_dimension]);
            }
        }
        $count = clone $indicadores;
        $pages = new Pagination([
            "pageSize" => 10,
            "totalCount" => $count->count(),
        ]);
        
        $indicadores = $indicadores->OrderBy('id_grupo, periodo, id_dimension')
                ->offset($pages->offset)
                ->limit($pages->limit)
                ->all();

        return $this->render('index', [
            'model' => $model,
            'indicadores' => $indicadores,
            'pages'=> $pages
        ]);
    }

    public function actionNuevo()
    {
        $model = new Indicadores();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $table = new Indicadores();
                $table->id_grupo = $model->id_grupo;
                $table->id_dimension = $model->id_dimension;
                $table->periodo = $model->periodo;
                $table->descripcion = $model->descripcion;
                $table->descripcion_cumple_masc = $model->descripcion_cumple_masc;
                $table->descripcion_cumple_fem = $model->descripcion_cumple_fem;
                $table->descripcion_nocumple_masc = $model->descripcion_nocumple_masc;
                $table->descripcion_nocumple_fem = $model->descripcion_nocumple_fem;
                
                if($table->insert())
                {
                    Yii::$app->session->setFlash('mensaje',  'Indicador registrado exitosamente.'); 
                    return $this->redirect(['indicadores/index']);
                }
            }
        }

        return $this->render('nuevo', [
            'model' => $model
        ]);
    }
    
    public function actionEditar($id)
    {
        $model = new Indicadores();
        $model->id_indicador = $id;
        if ($model->load(Yii::$app->request->post())) {
            $model->id_indicador = $id;
            $table = Indicadores::find()->where(['id_indicador'=>$model->id_indicador])->one();
            $table->id_grupo = $model->id_grupo;
            $table->id_dimension = $model->id_dimension;
            $table->periodo = $model->periodo;
            $table->descripcion = $model->descripcion;
            $table->descripcion_cumple_masc = $model->descripcion_cumple_masc;
            $table->descripcion_cumple_fem = $model->descripcion_cumple_fem;
            $table->descripcion_nocumple_masc = $model->descripcion_nocumple_masc;
            $table->descripcion_nocumple_fem = $model->descripcion_nocumple_fem;

            if($table->save())
            {
                Yii::$app->session->setFlash('mensaje',  'Indicador modificado exitosamente.'); 
                return $this->redirect(['indicadores/index']);
            }
        }
        $model = Indicadores::find()->where(['id_indicador'=>$id])->one();
        return $this->render('nuevo', ['model'=>$model]);
    }

    public function actionDimensiones()
    {
        $model = new FormDimensiones();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $table = new Dimensiones();
                $table->nombre = $model->nombre;
                $table->nombre_eng = $model->nombre_eng;
                if ($table->insert())
                {
                    $model->nombre = null;
                    $model->nombre_eng = null;
                }
            }
            else
            {
                $model->getErrors();
            }
        }
        $dimensiones = Dimensiones::find()->orderBy('id_dimension')->all();

        return $this->render('dimensiones', [
            'model' => $model,
            'dimensiones' => $dimensiones
        ]); 
    }
    
    public function actionIndicadoresPartial($id_grupo,$periodo){
        $indicadores = IndicadoresController::buscarIndicadoresPorGrupo($id_grupo, $periodo);
        
        return $this->renderAjax('//partials/indicadores_lista_view',['indicadores'=>$indicadores]);
    }

    public static function buscarIndicadoresPorGrupo($id_grupo, $periodo=null, $id_dimension=null){
        $query = Indicadores::find()
                ->with('dimension')
                ->where(['id_grupo'=>$id_grupo]);
        if($periodo !== null)
        {
            $query = $query->andWhere(['periodo'=>$periodo]);
        }
        if($id_dimension!==null){
            $query = $query->andWhere(['dimension'=>$id_dimension]);
        }
        $indicadores = $query->orderBy('id_dimension ASC')->all();
        return $indicadores;
    }
}