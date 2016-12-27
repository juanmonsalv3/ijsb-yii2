<?php
//matricula/nuevo-acudiente
use yii\helpers\Url;

$this->title = 'Nuevo Acudiente';
$this->params['breadcrumbs'][] = ['label' => 'Matricula', 'url' => Url::toRoute('matricula/')];
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
           