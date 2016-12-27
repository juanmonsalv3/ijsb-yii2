<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = 'Usuario';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?=$this->title ?></h3>
    </div>
    <div class="panel-body">
        <div class="usuarios-view">

            <?= DetailView::widget([
                'model' => $model,
                'options'=>['class'=>'table table-striped'],
                'attributes' => [
                    [
                        'attribute'=>'login',
                        'label'=>'Username',
                        'format'=>'text'
                    ],
                    [
                        'attribute'=>'perfil.nombre',
                        'label'=>'Perfil',
                        'format'=>'text'
                    ],
                    'nombres',
                    'apellidos',
                    'email:email',
                    'telefono',
                    'celular',
                    'ciudad_nacimiento',
                    'fecha_nacimiento',
                    'ocupacion',
                    [
                        'attribute'=>'isActivo',
                        'label'=>'Activo',
                        'format'=>'text',
                    ]
                ],
                'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '--'],
            ]) ?>

        </div>
    </div>
</div>
