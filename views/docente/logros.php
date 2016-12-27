<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Logros del Estudiante';
$this->params['breadcrumbs'][] = ['label' => 'Docente', 'url' => Url::toRoute('docente/')];
$this->params['breadcrumbs'][] = ['label' => 'Estudiante', 'url' => Url::toRoute(['docente/estudiante','id'=>$estudiantegrupo->id_estudiante])];
$this->params['breadcrumbs'][] = 'Logros'
?>

<div class="docentelogros-index">
    <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><?=$this->title ?></h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12">
                    <?= $this->render( '//partials/estudiante_datosbasicos_view', ['estudiante'=> $estudiantegrupo->estudiante] ); ?>
                </div>
                <div class="clearfix"></div>
                <br/>
                <div class="col-xs-6">
                    <?= Html::dropDownList('periodo'
                                        , $periodo
                                        , ['1'=>'Primer Período','2'=>'Segundo Período','3'=>'Tercer Período','4'=>'Cuarto Período']
                                        , ['class'=>'form-control', 'id'=>'periodo']) ?>
                </div>
                <hr/>
                <div class="col-xs-12">
                    <?=$this->render('//partials/logrosestudiante_edit',['indicadores'=>$indicadores,'estudiantegrupo'=>$estudiantegrupo]);?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
       $(document).on('change','#periodo',function(){
           var url = '<?=Url::toRoute(['docente/logros','id_estudiante'=>$estudiantegrupo->id_estudiante])?>';
           var periodo = $('#periodo').val();
           window.location = url+'&periodo='+periodo;
       });
    });
</script>