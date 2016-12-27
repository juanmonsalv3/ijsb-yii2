<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Fichamedica */
/* @var $form ActiveForm */
$this->title = 'Ficha Médica';
$this->params['breadcrumbs'][] = ['label' => 'Matrícula', 'url' => Url::toRoute('matricula/')];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?=$this->title ?></h3>
    </div>
    <div class="panel-body">
           <?=$this->render('//partials/fichamedica_form',['model'=>$model]) ?>
    </div>
</div>
