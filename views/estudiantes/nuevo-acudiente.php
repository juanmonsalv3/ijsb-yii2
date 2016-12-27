<?php
//estudiantes/nuevo-acudiente
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Parentesco;

$this->title = 'Nuevo Acudiente';
$this->params['breadcrumbs'][] = ['label' => 'Estudiantes', 'url' => Url::toRoute('estudiantes/')];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?=$this->title ?></h3>
    </div>
    <div class="panel-body">
        <div class="nuevo-acudiente-index">
            <?= $this->render('//partials/acudiente_nuevo',['model'=>$model]) ?>
        </div>
    </div>
</div>
            