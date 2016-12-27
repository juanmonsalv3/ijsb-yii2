<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Grupos;
use app\models\Dimensiones;
use app\models\Periodos;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $model app\models\Indicadores */
/* @var $form ActiveForm */
$this->title = 'Indicadores';
$this->params['breadcrumbs'][] = ['label' => 'Indicadores', 'url' => Url::toRoute('indicadores/')];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .pagination{
        margin: 0;
    }
</style>
<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?=$this->title ?></h3>
    </div>
    <div class="panel-body">
        <div class="indicadores-index">
            <div class="col-md-12 form-group">
                <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Nuevo Indicador', ['nuevo'], [
                    'class' => 'btn btn-success',
                ]) ?>
            </div>
           <?php $form = ActiveForm::begin([
                'action' => Url::toRoute('index'),
                'method' => 'get',
               'enableClientValidation'=>false
            ]); ?>
            <div class="col-md-4">
                <?= $form->field($model, 'id_grupo')
                    ->dropDownList(ArrayHelper::map(Grupos::find()->all(), 'id_grupo', 'nombre'),['prompt'=>'Filtrar por Grupo','onchange'=>'this.form.submit()'])?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'periodo')->dropDownList(ArrayHelper::map(Periodos::find()->orderBy('id_periodo')->all(), 'id_periodo', 'descripcion'),['prompt'=>'Filtrar por Período','onchange'=>'this.form.submit()'])?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'id_dimension')->dropDownList(ArrayHelper::map(Dimensiones::find()->orderBy('id_dimension')->all(), 'id_dimension', 'nombre'),['prompt'=>'Filtrar por Dimensión','onchange'=>'this.form.submit()'])?>
            </div>

            <?php $form->end() ?>

            <div class="col-md-12">
                <br/>
            </div>
            <div class="col-md-12">
                <table class=" table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Grupo</th>
                            <th>Periodo</th>
                            <th>Dimension</th>
                            <th>Descripción</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($indicadores as $indicador):?>
                        <tr>
                            <td><?=$indicador->grupo->nombre?></td>
                            <td><?=$indicador->periodoo->descripcion?></td>
                            <td><?=$indicador->dimension->nombre?></td>
                            <td><?=$indicador->descripcion?></td>
                            <td><a href="<?=Url::toRoute(['indicadores/editar','id'=>$indicador->id_indicador])?>"><i class="glyphicon glyphicon-edit" title="Editar"></i></a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <?= LinkPager::widget([
                        "pagination" => $pages,
                    ]);?>
            </div>
        </div><!-- indicadores-index -->
    </div>
</div>
