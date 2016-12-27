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
/* @var $form ActiveForm */
$this->title = 'Indicadores';
$this->params['breadcrumbs'][] = ['label' => 'Indicadores', 'url' => Url::toRoute('indicadores/')];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?=$this->title ?></h3>
    </div>
    <div class="panel-body">
        <div class="indicadores-nuevo">

            <?php $form = ActiveForm::begin(); ?>

            <div class="col-md-4">
                <?= $form->field($model, 'id_grupo')->dropDownList(ArrayHelper::map(Grupos::find()->all(), 'id_grupo', 'nombre'))?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'periodo')->dropDownList(ArrayHelper::map(Periodos::find()->orderBy('id_periodo')->all(), 'id_periodo', 'descripcion'))?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'id_dimension')->dropDownList(ArrayHelper::map(Dimensiones::find()->all(), 'id_dimension', 'nombre'))?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'descripcion') ?>
                <?= $form->field($model, 'descripcion_cumple_masc') ?>
                <?= $form->field($model, 'descripcion_cumple_fem') ?>
                <?= $form->field($model, 'descripcion_nocumple_masc') ?>
                <?= $form->field($model, 'descripcion_nocumple_fem') ?>



                <div class="form-group">
                    <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar',['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>



            <script type="text/javascript">
                $("#indicadores-descripcion").blur(function(){
                    if( !$("#indicadores-descripcion_cumple_masc").val() ) {
                        $("#indicadores-descripcion_cumple_masc").val( $("#indicadores-descripcion").val());
                    }
                    if( !$("#indicadores-descripcion_cumple_fem").val() ) {
                        $("#indicadores-descripcion_cumple_fem").val( $("#indicadores-descripcion").val());
                    }
                    if( !$("#indicadores-descripcion_nocumple_masc").val() ) {
                        $("#indicadores-descripcion_nocumple_masc").val( $("#indicadores-descripcion").val());
                    }
                    if( !$("#indicadores-descripcion_nocumple_fem").val() ) {
                        $("#indicadores-descripcion_nocumple_fem").val( $("#indicadores-descripcion").val());
                    }
                });
            </script>
        </div><!-- indicadores-nuevo -->
    </div>
</div>