<?php
//docente/estudiante
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Estudiante: ' . $estudiante->nombreCompleto;
$this->params['breadcrumbs'][] = ['label' => 'Docente', 'url' => Url::toRoute(['docente/'])];
$this->params['breadcrumbs'][] = 'Estudiante';
?>

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
                                <a href="<?= Url::toRoute(['docente/logros','id_estudiante'=>$estudiante->id_estudiante])?>" class="btn btn-primary" >Modificar</a>
                                
                                <br/><br/>
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
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var id_estudiante = <?=$estudiante->id_estudiante?>;
    var urlboletines = '<?= Url::toRoute('informes/boletin')?>';
    $(document).ready(function(){
        $('#periodo').change(function(){
            var periodo = $('#periodo').val();
           $.ajax({
                method: 'get',
                url: '<?= Url::toRoute(['docente/logros-partial']); ?>',
                data: { periodo: periodo, id_estudiante: id_estudiante } ,
                success: function(data) {
                    $('.indicadores').html(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#notify-wrap').notify({ text: 'Ocurrió un error procesando la solicitud', state: 'ui-state-error', timeout: 3000 });
                }
            });
        });
        $(document).on('click','.imprimir-boletin',function(){
            var periodo = $('#periodo').val();
            window.open(urlboletines+'?id='+id_estudiante+'&periodo='+periodo, '_blank'); 
        });
    });
</script>