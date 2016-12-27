<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Periodos;
use app\models\Dimensiones;


$this->title = 'Logros Estudiante';
$this->params['breadcrumbs'][] = ['label' => 'Estudiantes', 'url' => Url::toRoute('estudiantes/')];
$this->params['breadcrumbs'][] = ['label' => 'Estudiante', 'url' => Url::toRoute(['estudiantes/estudiante','id'=>$estudiantegrupo->estudiante->id_estudiante])];
$this->params['breadcrumbs'][] = ['label' => 'Logros'];

?>

<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?=$this->title?></h3>
    </div>
    <div class="panel-body">
        <div class="estudiante-select" data-url="<?=Url::toRoute(['acudiente/seleccionar','id_estudiante'=>$estudiantegrupo->estudiante->id_estudiante])?>">
            <div class="media-left">
                <?=Html::img('@web/images/'.$estudiantegrupo->estudiante->ImageUrl, ['alt'=>$estudiantegrupo->estudiante->nombreCompleto, 'class'=>'media-object img-estudiante'])?>
            </div>
            
            <div class="media-body">
              <h4 class="media-heading"><?=$estudiantegrupo->estudiante->nombreCompleto?></h4>
              Edad: <?=$estudiantegrupo->estudiante->edad?> <br/>
              Grupo: <?=$estudiantegrupo->estudiante->grupoActual->nombre?>

            </div>
        </div>
        <br/>
        <?php $f = ActiveForm::begin([
                'method' => 'get',
                'enableClientValidation'=>false
            ]); ?>
        <div class="row">
            <div class="col-sm-6">
                <?= $f->field($formsearch, 'periodo')->dropDownList(ArrayHelper::map(Periodos::find()->orderBy('id_periodo')->all(), 'id_periodo', 'descripcion'),['onchange'=>'this.form.submit()'] )?>
            </div>
            <div class="col-sm-6">
                <?= $f->field($formsearch, 'id_dimension')->dropDownList(ArrayHelper::map(Dimensiones::find()->all(), 'id_dimension', 'nombre'),['onchange'=>'this.form.submit()'] )?>
            </div>
        </div>
        <?php $f->end() ?>
        
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Cumple</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($indicadores as $indicador):?>
                <tr>
                    <td>
                        <?=$indicador["descripcion"]?>
                    </td>
                    <td style="padding: 0; width: 30%;">
                        <?= Html::dropDownList(
                                'cumple'.$indicador["id_indicador"]
                                , $indicador["cumple"]
                                , array('2'=>'Por evaluar','1'=>'Cumple','0'=>'No cumple')
                                , array('class'=>'form-control cumple-nocumple','data-id'=>$indicador["id_indicador"])
                                )?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    var id_estgrp = <?=$estudiantegrupo->id_grupo_estudiante ?>;
    $('.cumple-nocumple').on('change',function(e){
            e.preventDefault();
            var idindicador = $(this).data('id');
            var cumple = $(this).val();
            
            asignarIndicador(idindicador, cumple);
        });
        
    function asignarIndicador(indicador, cumple){
        $.ajax({
                method: 'get',
                url: '<?= Url::toRoute(['estudiantes/indicador-estudiante']); ?>',
                data: { id_estudiante_grupo: id_estgrp, id_indicador : indicador, cumple:cumple} ,
                success: function(data) {
                    mostrarMensaje('Actualizado');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#notify-wrap').notify({ text: 'Ocurrió un error procesando la solicitud', state: 'ui-state-error', timeout: 3000 });
                }
            });
    }
</script>