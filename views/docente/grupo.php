<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Grupo: '. $grupo->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Docente', 'url' => Url::toRoute('docente/')];
$this->params['breadcrumbs'][] = 'Grupo';
?>
<div class="grupodocente-index">
    <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><?=$this->title ?></h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12">
                    <h4>Grupo: <?=$grupo->nombre?></h4>
                    <h5><?=$grupo->descripcion?></h5>
                    <hr/>
                </div>
                <ul class="nav nav-tabs" role="tablist" style="margin-top: 40px;">
                    <li role="presentation" class="active">
                        <a href="#estudiantes" role="tab" data-toggle="tab">
                            <b>Estudiantes</b>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#horario" role="tab" data-toggle="tab">
                            <b>Horario</b>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#cronograma" role="tab" data-toggle="tab">
                            <b>Cronograma de Actividades</b>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#indicadores" role="tab" data-toggle="tab">
                            <b>Indicadores</b>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active fade in" id="estudiantes">
                        <div class="col-xs-12">
                            <h3>Estudiantes</h3>
                            <table class="table table-striped table-list table-hover table-condensed">
                                <?php foreach ($grupo->estudiantes as $estudiante): ?>
                                <tr>
                                    <td><?=$estudiante->nombreCompleto?></td>
                                    <td>
                                        <a href="<?=Url::toRoute(['docente/estudiante','id'=>$estudiante->id_estudiante])?>"><span class="glyphicon glyphicon-eye-open"/></a>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade in" id="horario">
                        <div class="col-xs-12">
                            <h3>Horario</h3>
                            <?= $this->render('//partials/horario_view',['horario'=>$horarios, 'horas'=>$horas])?>
                        </div>
                    </div>
                    <div class="tab-pane fade in" id="cronograma">
                        <div class="col-xs-12">
                            <h3>Cronograma de Actividades</h3>
                            <hr/>
                            <?= $this->render( '//cronogramas/cronogramactividadespartial', ['actividades'=> $cronograma] ); ?>
                        </div>
                    </div>
                    <div class="tab-pane fade in" id="indicadores">
                        <div class="col-xs-12">
                            <h3>Indicadores</h3>
                            <hr/>
                            <div class="row col-xs-12 col-sm-6 col-md-4">
                                <label for="periodo">Periodo</label>
                                <?= Html::dropDownList('periodo'
                                        , Yii::$app->cache->get('parametros')['periodoencurso']['valor']
                                        , ['1'=>'Primer Período','2'=>'Segundo Período','3'=>'Tercer Período','4'=>'Cuarto Período']
                                        , ['class'=>'form-control', 'id'=>'periodo']) ?>
                            </div>
                            <div class="clearfix"></div>
                            <br/>
                            <div class="indicadores">
                                <?= $this->render( '//partials/indicadores_lista_view', ['indicadores'=> $indicadores] ); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var id_grupo = <?=$grupo->id_grupo?>;
    $(document).ready(function(){
        $('#periodo').change(function(){
            var periodo = $('#periodo').val();
           $.ajax({
                method: 'get',
                url: '<?= Url::toRoute(['indicadores/indicadores-partial']); ?>',
                data: { id_grupo: id_grupo, periodo: periodo } ,
                success: function(data) {
                    $('.indicadores').html(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#notify-wrap').notify({ text: 'Ocurrió un error procesando la solicitud', state: 'ui-state-error', timeout: 3000 });
                }
            });
        });
    });
</script>