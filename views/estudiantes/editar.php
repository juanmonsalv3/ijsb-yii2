<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Editar Estudiante';
$this->params['breadcrumbs'][] = ['label' => 'Estudiantes', 'url' => Url::toRoute(['estudiantes/'])];
$this->params['breadcrumbs'][] = ['label' => 'Editar'];
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?=$this->title ?></h3>
    </div>
    <div class="panel-body">
        <div class="editarestudiante-view">
             <?php $f = ActiveForm::begin(['method' => 'post',]); ?>

            <?=  Html::activeHiddenInput($formestudiante, 'id_estudiante')?>

            <div class="col-md-12">
                <div class="col-md-4">
                    <?= $f->field($formestudiante, 'sexo')->dropDownList(['F'=>'Femenino','M'=>'Masculino'])?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <?= $f->field($formestudiante, 'nombres')->textInput()?>
                </div>
                <div class="col-md-6">
                    <?= $f->field($formestudiante, 'apellidos')->textInput()?>
                </div>
            </div>
            <div class="col-md-12 form-group">
                <div class="col-md-6">
                    <?= $f->field($formestudiante, 'ciudad_nacimiento')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $f->field($formestudiante, 'fecha_nacimiento')->widget(\yii\jui\DatePicker::classname(), [
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