<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Grupos;
use app\models\Dimensiones;
use app\models\Periodos;

/* @var $this yii\web\View */
/* @var $model app\models\Indicadores */

$this->title = 'Update Indicadores: ' . ' ' . $model->id_indicador;
$this->params['breadcrumbs'][] = ['label' => 'Indicadores', 'url' => Url::toRoute('indicadores/')];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?=$this->title ?></h3>
    </div>
    <div class="panel-body">
        <div class="indicadores-update">

            <h1><?= Html::encode($this->title) ?></h1>

            <?php $form = ActiveForm::begin([
                'method' => 'post',
            ]); ?>
            <div class="col-md-4">
                <?= $form->field($model, 'id_grupo')->dropDownList(ArrayHelper::map(Grupos::find()->all(), 'id_grupo', 'nombre'))?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'id_dimension')->dropDownList(ArrayHelper::map(Dimensiones::find()->all(), 'id_dimension', 'nombre'))?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'periodo')->dropDownList(ArrayHelper::map(Periodos::find()->orderBy('id_periodo')->all(), 'id_periodo', 'descripcion'))?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'descripcion')->input('search') ?>
            </div>

            <div class="col-md-12 form-group">
                <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Buscar', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php $form->end() ?>

        </div>
    </div>
</div>