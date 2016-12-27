<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Grupos;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Estudiantes';
$this->params['breadcrumbs'][] = ['label' => 'Estudiantes', 'url' => Url::toRoute('estudiantes/')];
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?=$this->title ?></h3>
    </div>
    <div class="panel-body">
        <?php $f = ActiveForm::begin(['method' => 'get',
            'enableClientValidation'=>false]); ?>

            <div class="col-md-4">
                <?= $f->field($form, 'grupo')
                    ->dropDownList(ArrayHelper::map(Grupos::find()->all(), 'id_grupo', 'nombre'),['prompt'=>'Filtrar por Grupo','onchange'=>'this.form.submit()'])?>
            </div>
            <div class="col-md-8">
                <?= $f->field($form, 'nombre')->textInput();?>
            </div>

            <div class="col-md-12 form-group">
                <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> Buscar', ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Nuevo Estudiante', ['nuevo'], [
                    'class' => 'btn btn-success',
                ]) ?>
            </div>

        <?php $f->end();?>
        <br/>
        
        <?=GridView::widget([
            'dataProvider' => $dataProvider,
            'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '-'],
            'layout' => '{items}{pager}{summary}',
            'summary' => '<div class="summary">Mostrando:{begin} - {end} Total: {count}</div>',
            'emptyText' => 'No se encontraron registros',
            'tableOptions' => [
                'class' => 'table table-striped table-hover',
            ],
            'columns'=>[
                [
                    'attribute'=>'id_grupo',
                    'value'=>'grupoActual.nombre',
                    'label' => 'Grupo',
                ],
                [
                    'attribute'=>'apellidos',
                    'value'=>'nombreCompleto',
                    'label' => 'Nombres',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{ver} / {imprimir} / {borrar}',
                    'buttons' => [
                        'ver' => function ($url,$model) {
                            $url = Url::toRoute(['estudiantes/estudiante','id'=>$model->id_estudiante]);
                            return Html::a(' <span class="glyphicon glyphicon-eye-open"/>', $url, ['title' => 'Ver datos del estudiante']); 
                        },
                        'borrar' => function ($url,$model) {
                            $url = Url::toRoute(['estudiantes/borrar','id'=>$model->id_estudiante]);
                            return ' '.Html::a(' <span class="glyphicon glyphicon-remove"/>', $url, ['title' => 'Eliminar el estudiante',
                                'onclick'=>'return confirm("¿Seguro que desea eliminar el estudiante seleccionado?")']); 
                        },
                        'imprimir' => function ($url,$model) {
                            $periodo = Yii::$app->cache->get('parametros')['periodoencurso']['valor'];
                            $url = Url::toRoute(['informes/boletin','id'=>$model->id_estudiante,'periodo'=>$periodo]);
                            return ' '.Html::a(' <span class="glyphicon glyphicon-print"/>', $url, ['title' => 'Imprimir boletín del período actual','target'=>'_blank']); 
                        },
                    ],
                ]
            ]
        ])?>
    </div>
</div>