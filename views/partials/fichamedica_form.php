<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="fichamedica_form">
    <?php $form = ActiveForm::begin(['method' => 'post']); ?>
    <?=  Html::activeHiddenInput($model, 'id_estudiante')?>
    <div class="col-md-6">
        <?= $form->field($model, 'nacimiento')->dropDownList(['natural'=>'Parto Natural', 'cesarea'=>'Por Cesárea']) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'tipo_sangre')->dropDownList(['O-','O+','A-','A+','B-','B+','AB-','AB+']) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'urgencia_avisar_a') ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'telefono') ?>
    </div>
    <div class="col-md-12"></div>
    <div class="col-md-6">
        <?= $form->field($model, 'asma')->checkbox() ?>
        <?= $form->field($model, 'convulsiones')->checkbox() ?>
        <?= $form->field($model, 'diabetes')->checkbox() ?>
        <?= $form->field($model, 'sangrado_nasal')->checkbox() ?>
        <?= $form->field($model, 'dolor_cabeza')->checkbox() ?>
        <?= $form->field($model, 'tratamiento_actual')->checkbox() ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'puedetomar_dolex')->checkbox() ?>
        <?= $form->field($model, 'puedetomar_acetaminofen')->checkbox() ?>
        <?= $form->field($model, 'puedetomar_buscapina')->checkbox() ?>
        <?= $form->field($model, 'puedetomar_plasil')->checkbox() ?>
        <?= $form->field($model, 'puedetomar_dristan')->checkbox() ?>
    </div>
    <div class="col-md-12">

        <?= $form->field($model, 'alergias')->textarea() ?>
        <?= $form->field($model, 'otras_enfermedades')->textarea() ?>
        <?= $form->field($model, 'enfermedades')->textarea() ?>
        <?= $form->field($model, 'medicamentos')->textarea() ?>
        <?= $form->field($model, 'observaciones')->textarea() ?>
        <div class="form-group">
            <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>