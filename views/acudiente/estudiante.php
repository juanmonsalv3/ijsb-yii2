<?php
//acudiente/estudiante
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Estudiante';
$this->params['breadcrumbs'][] = ['label' => 'Acudiente', 'url' => Url::toRoute('acudiente/')];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .img-estudiante{
        height: 100px;
        width: 100px;
    }
    .media-left{
        position: relative;
    }
    dt, dd{ 
        margin-bottom: 5px;
    }
    .header-text{
        font-size: 18px;
        font-weight: 500;
        line-height: 1.1;
    }
    .tab-pane{
        padding-top: 20px;
    }
</style>
<div clas="estudiante-index">
    <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><?=$this->title ?></h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <?= $this->render( '//partials/estudiante_datosbasicos_view', ['estudiante'=> $estudiante] ); ?>
                <div class="clearfix"></div>
                
                <ul class="nav nav-tabs" role="tablist" style="margin-top: 20px;">
                    <li role="presentation" class="active">
                        <a href="#acudientes" role="tab" data-toggle="tab">
                            <b>Acudientes</b>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#fichamedica" role="tab" data-toggle="tab">
                            <b>Ficha Médica</b>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#fichapsicologica" role="tab" data-toggle="tab">
                            <b>Ficha Psicológica</b>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#logros" role="tab" data-toggle="tab">
                            <b>Logros</b>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#horario" role="tab" data-toggle="tab">
                            <b>Horario</b>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#cronograma" role="tab" data-toggle="tab">
                            <b>Actividades</b>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in" id="fichamedica">
                        <div class="col-xs-12">
                            <h4>Ficha Médica</h4>
                            <hr/>
                            <?=$this->render( '//partials/fichamedica_view', ['fichaMedica'=> $estudiante->fichaMedica] );?>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade in" id="fichapsicologica">
                        <div class="col-xs-12">
                            <h4>Ficha Psicológica</h4>
                            <hr/>
                            <?=$this->render( '//partials/fichapsicologica_view', ['fichaPsicologica'=> $estudiante->fichaPsicologica] );?>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane active fade in" id="acudientes">
                        <div class="col-xs-12">
                            <h4>Acudientes</h4>
                            <hr/>
                            <?=$this->render( '//partials/acudientes_view', ['acudientes'=> $estudiante->acudientes] );?>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade in" id="logros">
                        <div class="col-xs-12">
                            <h4>Logros</h4>
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
                                <?= $this->render( '//partials/logrosestudiante_view', ['logros'=> $logros] ); ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade in" id="horario">
                        <div class="col-xs-12">
                            <h4>Horario</h4>
                            <hr/>
                            <?= $this->render('//partials/horario_view',['horario'=>$horarios, 'horas'=>$horas])?>
                        </div>
                    </div>
                    <div class="tab-pane fade in" id="cronograma">
                        <div class="col-xs-12">
                            <h4>Actividades</h4>
                            <hr/>
                            <?= $this->render( '//cronogramas/cronogramactividadespartial', ['actividades'=> $cronograma] ); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>