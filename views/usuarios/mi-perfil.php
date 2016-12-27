<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $usuario->nombreCompleto;
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .detail-view.mi-perfil tr th{
        width: 20%;
        text-align: right;
    }
</style>

<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?=$this->title ?></h3>
    </div>
    <div class="panel-body">
        <div class="miperfil-index">
            <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Editar Perfil', Url::toRoute(['usuarios/editar-perfil']), ['class'=>'btn btn-primary'])?>
        <br/><br/>    
        <?=DetailView::widget([
                'model' => $usuario,
                'options' => ['class' => 'table table-striped detail-view mi-perfil'],
                'formatter' => [
                    'class' => 'yii\i18n\Formatter',
                    'nullDisplay' => '',
                ],
                'attributes'=>[
                    [
                        'attribute'=>'perfil.nombre',
                        'label' => 'Perfil'
                    ],
                    'login',
                    [
                        'attribute'=>'nombreCompleto',
                        'label' => 'Nombres'
                    ],
                    'email',
                    'telefono',
                    'celular',
                    'ocupacion',
                    'ciudad_nacimiento',
                    'fecha_nacimiento'
                    ]
            ])?>
        </div>
    </div>
</div>