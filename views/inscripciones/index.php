<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Grupos;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inscripciones';
$this->params['breadcrumbs'][] = ['label' => 'Inscripciones', 'url' => Url::toRoute('inscripciones/')];
$this->params['breadcrumbs'][] = $this->title;

?>
<style>
[class^="flaticon-"]:before, [class*=" flaticon-"]:before, [class^="flaticon-"]:after, [class*=" flaticon-"]:after {
    font-size: 150px;
}
</style>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?=$this->title ?></h3>
  </div>
  <div class="panel-body">
        <div class="inscripciones-index">

            <?php $f = ActiveForm::begin(['method' => 'get',
                'enableClientValidation'=>'false']); ?>
            <div class="col-md-12 form-group">
                <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Inscribir Estudiante', ['nueva'], [
                    'class' => 'btn btn-success',
                ]) ?>
            </div>
            <div class="col-md-4">
                <?= $f->field($form, 'id_grupo')->dropDownList(ArrayHelper::map(Grupos::find()->all(), 'id_grupo', 'nombre'),['prompt'=>'Filtrar por grupo','onchange'=>'this.form.submit()'])?>
            </div>
            <div class="col-md-4">
                <?= $f->field($form, 'estado')->dropDownList(['1'=>'Aprobada','0'=>'Rechazada',],['prompt'=>'Filtrar por estado','onchange'=>'this.form.submit()'])?>
            </div>
            <div class="col-md-4">
                <?= $f->field($form, 'mes')->dropDownList(['1'=>'1 mes','2'=>'2 meses','3'=>'3 meses','4'=>'4 meses','5'=>'5 meses','6'=>'6 meses',],['onchange'=>'this.form.submit()'])?>
            </div>
            
            <?php $f->end();?>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Fecha Registro</th>
                        <th>Grupo</th>
                        <th>Nombre Completo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($model as $row): ?>
                    <tr>
                        <td><?= $row->estado_solicitud == 1 ?  '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' ?></td>
                        <td><?= $row->fecha_registro?></td>
                        <td><?= $row->grupo->nombre?></td>
                        <td><?= $row->nombreCompleto?></td>
                        <td align="right">
                            <a href="<?= Url::toRoute(['inscripciones/view','id'=>$row->id_solicitud])?>" title="Ver" aria-label="View" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a> 
                            <?php if($row->estado_solicitud == 1) :?>
                            <a href="<?= Url::toRoute(['inscripciones/rechazar','id'=>$row->id_solicitud])?>"><span class="glyphicon glyphicon-remove" title="Rechazar Solicitud"></span></a>
                            <?php endif; ?>
                            <?php if($row->estado_solicitud == 0) :?>
                            <a href="<?= Url::toRoute(['inscripciones/aprobar','id'=>$row->id_solicitud])?>"><span class="glyphicon glyphicon-ok" title="Aprobar Solicitud"></span></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <?= LinkPager::widget([
                    "pagination" => $pages,
                ]);?>
        </div>
    </div>
</div>