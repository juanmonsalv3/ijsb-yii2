<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Modificar Imagen';
$this->params['breadcrumbs'][] = ['label' => 'Acudiente', 'url' => Url::toRoute('acudiente/')];
$this->params['breadcrumbs'][] = ['label' => 'Estudiante', 'url' => Url::toRoute('acudiente/estudiante')];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .img-estudiante{
        width: 200px;
        height: 200px;
    }
</style>
<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?=$this->title?></h3>
    </div>
    <div class="panel-body">
        <?=Html::img('@web/images/'.$estudiante->imageUrl, ['alt'=>$estudiante->nombreCompleto, 'class'=>'media-object img-estudiante'])?>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($model, 'imageFile')->fileInput()->label('') ?>

        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>

        <?php ActiveForm::end() ?>
    </div>
</div>