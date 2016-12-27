<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Estudiantes';
$this->params['breadcrumbs'][] = ['label' => 'Acudiente', 'url' => Url::toRoute('acudiente/')];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .img-estudiante{
        width: 80px;
        height: 80px;
    }
    .estudiante-select{
        cursor: pointer;
        padding: 10px;
        border: 1px #ddd solid;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    .estudiante-select:hover {
        box-shadow: 0 0 3pt 2pt #ddd;
    }

</style>
<div class="seleccionestudiantes-index">
    <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><?=$this->title ?></h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <?php foreach($estudiantes as $estudiante):?>
                <div class="col-xs-12 col-md-6" >
                    <div class="estudiante-select" data-url="<?=Url::toRoute(['acudiente/seleccionar','id_estudiante'=>$estudiante->id_estudiante])?>">
                        <div class="media-left">
                            <a href="#">
                                <?=Html::img('@web/images/'.$estudiante->imageUrl, ['alt'=>$estudiante->nombreCompleto, 'class'=>'media-object img-estudiante'])?>
                            </a>
                        </div>
                        <div class="media-body">
                          <h4 class="media-heading"><?=$estudiante->nombreCompleto?></h4>
                          Grupo: <?=$estudiante->grupoActual->nombre?>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.estudiante-select').on('click',function(){
            window.location = $(this).data('url');
        });
    });
</script>