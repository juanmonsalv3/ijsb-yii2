<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Parentesco;

/* @var $this yii\web\View */
/* @var $model app\models\forms\FormNuevoAcudiente */
/* @var $form ActiveForm */
?>
<div class="acudientes-nuevo">

    <?php $form = ActiveForm::begin(['id'=>'nuevo-acudiente']); ?>
        <?= $form->field($model, 'id_estudiante')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'parentesco')->dropDownList(ArrayHelper::map(Parentesco::find()->orderBy('id_parentesco')->all(), 'id_parentesco', 'nombre'))?>
        <?= $form->field($model, 'nombres') ?>
        <?= $form->field($model, 'apellidos') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'telefono') ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Registrar', ['class' => 'btn btn-primary']) ?>    
    <?php ActiveForm::end(); ?>

</div>