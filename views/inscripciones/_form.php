<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Grupos;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Inscripciones */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .inscripciones-form .form-group {
        margin-bottom: 10px;
    }
</style>

<div class="inscripciones-form">

    <?php $form = ActiveForm::begin( ['enableClientValidation'=>true, 'method'=>'post']); ?>

    <div class="col-md-12 form-group">
        <div class="col-md-6">
            <?= $form->field($model, 'id_grupo')->dropDownList(ArrayHelper::map(Grupos::find()->all(), 'id_grupo', 'nombre')) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'sexo')->dropDownList(['F'=>'Femenino', 'M'=>'Masculino']) ?>
        </div>
    </div>
    
    <div class="col-md-12 form-group">
        <div class="col-md-6">
            <?= $form->field($model, 'nombres')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    
    <div class="col-md-12 form-group">
        <div class="col-md-6">
            <?= $form->field($model, 'ciudad_nacimiento')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'fecha_nacimiento')->widget(\yii\jui\DatePicker::classname(), [
                'language' => 'es',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control']
            ]) ?>
        </div>
    </div>
    <div class="col-md-12 form-group">
        <div class="col-md-6">
            <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="col-md-12 form-group">
        <div class="col-md-6">
            <?= $form->field($model, 'nacimiento')->dropDownList(['natural'=>'Parto Natural', 'cesarea'=>'Por Cesárea']) ?>
        </div>
    </div>
    <div class="col-md-12 form-group">
        <div class="col-md-12">
            <?= $form->field($model, 'vive_con')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="col-md-12 form-group">
        <div class="col-md-12">
            <?= $form->field($model, 'enfermedades')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="col-md-12 form-group">
        <div class="col-md-12">
            <?= $form->field($model, 'alergias')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="col-md-12 form-group">
        <div class="col-md-12">
            <?= $form->field($model, 'medicamentos')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    
    <div class="col-md-12 form-group">
        <div class="col-md-6">
            <?= $form->field($model, 'parentesco_acudiente')->dropDownList(['Padre'=>'Padre', 'Madre'=>'Madre', 'Tio'=>'Tio']) ?>
        </div>
    </div>
    <div class="col-md-12 form-group">
        <div class="col-md-6">
            <?= $form->field($model, 'nombres_acud')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'apellidos_acud')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="col-md-12 form-group">
        <div class="col-md-6">
            <?= $form->field($model, 'ciudad_nacimiento_acudiente')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'fecha_nacimiento_acudiente')->widget(\yii\jui\DatePicker::classname(), [
                'language' => 'es',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control']
            ]) ?>
        </div>
    </div>
    <div class="col-md-12 form-group">
        <div class="col-md-6">
            <?= $form->field($model, 'ocupacion_acudiente')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'email_acudiente')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="col-md-12 form-group">
        <div class="col-md-6">
            <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> '.($model->isNewRecord ? 'Inscribir' : 'Actualizar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
