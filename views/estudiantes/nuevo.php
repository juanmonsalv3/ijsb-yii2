<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Grupos;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nuevo';
$this->params['breadcrumbs'][] = ['label' => 'Estudiantes', 'url' => Url::toRoute('estudiantes/')];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?=$this->title ?></h3>
    </div>
    <div class="panel-body">
        <div class="inscripciones-index">

            <?php $f = ActiveForm::begin(['method' => 'post',]); ?>

            <?=  Html::activeHiddenInput($form, 'id_estudiante')?>

            <div class="col-md-12">
                <div class="col-md-4">
                    <?= $f->field($form, 'sexo')->dropDownList(['F'=>'Femenino','M'=>'Masculino'])?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <?= $f->field($form, 'nombres')->textInput()?>
                </div>
                <div class="col-md-6">
                    <?= $f->field($form, 'apellidos')->textInput()?>
                </div>
            </div>
            <div class="col-md-12 form-group">
                <div class="col-md-6">
                    <?= $f->field($form, 'ciudad_nacimiento')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $f->field($form, 'fecha_nacimiento')->widget(\yii\jui\DatePicker::classname(), [
                        'language' => 'es',
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => ['class' => 'form-control']
                    ]) ?>
                </div>
            </div>
            <div class="col-md-12 form-group">
                <div class="col-md-12 form-group">
                    <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary','confirm'=>'Are you sure you want to save?']) ?>    
                </div>
            </div>
            <?php $f->end();?>
        </div>
    </div>
</div>