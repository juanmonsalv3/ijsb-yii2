<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Indicadores */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="indicadores-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_grupo')->textInput() ?>

    <?= $form->field($model, 'id_dimension')->textInput() ?>

    <?= $form->field($model, 'periodo')->textInput() ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
