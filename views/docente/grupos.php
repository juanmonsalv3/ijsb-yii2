<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Grupos';
$this->params['breadcrumbs'][] = ['label' => 'Docente', 'url' => Url::toRoute('docente/')];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .grupo-select{
        cursor: pointer;
        padding: 10px;
        border: 1px #ddd solid;
        border-radius: 10px;
        margin-bottom: 20px;
        padding-left: 20px;
    }
    .grupo-select:hover {
        box-shadow: 0 0 3pt 2pt #ddd;
    }
</style>
<div class="seleccciongrupos-index">
    <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><?=$this->title ?></h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <?php foreach($grupos as $grupo):?>
                <div class="col-xs-12 col-md-6" >
                    <div class="grupo-select" data-url="<?=Url::toRoute(['docente/grupos','id'=>$grupo->grupo->id_grupo])?>">
                        <div class="media-body">
                            <h4 class="media-heading"><?=$grupo->grupo->nombre?></h4>
                            <?=$grupo->grupo->descripcion?><br/>
                            Total Estudiantes: <?=$grupo->grupo->totalEstudiantes?>
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
        $('.grupo-select').on('click',function(){
            window.location = $(this).data('url');
        });
    });
</script>