<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="matricula-ficha_psicologica">
    <?php $form = ActiveForm::begin(['method' => 'post']); ?>
    <?=  Html::activeHiddenInput($model, 'id_estudiante')?>
    <div class="col-md-6">
        <?= $form->field($model, 'cuantoshermanos') ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'posicionhermanos') ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'edad_gateo') ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'edad_camino') ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'edad_habla') ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'edad_controlesfinter') ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'lavadientes')->checkbox()?>
        <?= $form->field($model, 'lavamanos')->checkbox() ?>
        <?= $form->field($model, 'viste')->checkbox() ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'cordoneszapatos')->checkbox() ?>
        <?= $form->field($model, 'mojadenoche')->checkbox() ?>
        <?= $form->field($model, 'chupadedo')->checkbox() ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'horadormir') ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'horasdormido') ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'detalle_embarazo') ?>
        <?= $form->field($model, 'detalle_nacimiento') ?>
        <?= $form->field($model, 'complicaciones_natales') ?>
        <?= $form->field($model, 'caracter') ?>
        <?= $form->field($model, 'reaccion_malgenio') ?>
        <?= $form->field($model, 'reaccion_alegre') ?>
        <?= $form->field($model, 'habitodormir') ?>
        <?= $form->field($model, 'apetito') ?>
        <?= $form->field($model, 'musica') ?>
        <?= $form->field($model, 'programas') ?>
        <?= $form->field($model, 'conductas') ?>
        <?= $form->field($model, 'traumas') ?>
        <?= $form->field($model, 'persona_vinculoafectivo') ?>
        <?= $form->field($model, 'persona_atiendesupervisa') ?>
        <?= $form->field($model, 'expresacorrientemente') ?>
        <?= $form->field($model, 'habla_gritos') ?>
        <?= $form->field($model, 'pesadillas') ?>
        <?= $form->field($model, 'comidasenfamilia') ?>
        <?= $form->field($model, 'gustahacer') ?>
        <?= $form->field($model, 'conquienjuega') ?>
        <?= $form->field($model, 'actitudjuego') ?>
        <?= $form->field($model, 'amigoimaginario') ?>
        <?= $form->field($model, 'cine') ?>
        <?= $form->field($model, 'television') ?>
        <?= $form->field($model, 'despierta') ?>
        <?= $form->field($model, 'cuentos') ?>
        <div class="form-group">
            <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>