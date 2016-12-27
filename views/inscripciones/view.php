<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Inscripciones */

$this->title = 'Solicitud de Inscripción';
$this->params['breadcrumbs'][] = ['label' => 'Inscripciones', 'url' => Url::toRoute('inscripciones/')];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .detail-view th:first-child{
        width: 30%;
    }
</style>
<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?=$this->title ?></h3>
    </div>
    <div class="panel-body">
        <div class="inscripciones-view">
            <?php if($model->estado =='Por Revisar'):?>
            <div class="col-xs-12">
                <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Modificar', ['modificar', 'id' => $model->id_solicitud], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<span class="glyphicon glyphicon-ok"></span> Aceptar', ['aceptar', 'id' => $model->id_solicitud], ['class' => 'btn btn-success'
                    ,'data' => [
                        'confirm' => '¿Está seguro que desea aprobar esta solicitud?',
                        'method' => 'post'
                        ]
                    ]) ?>
                <?= Html::a('<span class="glyphicon glyphicon-remove"></span> Rechazar', ['rechazar', 'id' => $model->id_solicitud], ['class' => 'btn btn-warning'
                    ,'data' => [
                        'confirm' => '¿Está seguro que desea rechazar esta solicitud?',
                        'method' => 'post'
                        ]
                    ]) ?>
                <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Borrar', ['borrar', 'id' => $model->id_solicitud], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => '¿Está seguro que desea borrar esta solicitud?',
                        'method' => 'post',
                    ],
                ]) ?>

            </div>
            <div class="clearfix"></div>
            <br/>
            
            <?php endif?>
            <div class="col-xs-12">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-striped detail-view'],
                'attributes' => [
                    'estado',
                    'fecha_registro',
                    [
                        'attribute'=>'grupo.nombre',
                        'label'=>'Grupo',
                        'format'=>'text'
                    ],
                    'nombres',
                    'apellidos',
                    [
                        'attribute'=>'sex',
                        'label'=>'Sexo',
                        'format'=>'text'
                    ],
                    'ciudad_nacimiento',
                    'fecha_nacimiento',
                    'vive_con',
                    'direccion',
                    'telefono',
                    'nacimiento',
                    'enfermedades',
                    'alergias',
                    'medicamentos',
                    'parentesco_acudiente',
                    'nombres_acud',
                    'apellidos_acud',
                    'ciudad_nacimiento_acudiente',
                    'fecha_nacimiento_acudiente',
                    'ocupacion_acudiente',
                    'email_acudiente:email',
                ],
                'formatter' => [
                    'class' => 'yii\i18n\Formatter',
                    'nullDisplay' => '',
                ],
            ]) ?>
            </div>
        </div>
    </div>
</div>