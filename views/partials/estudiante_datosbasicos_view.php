<?php

use yii\helpers\Url;
use yii\helpers\Html;
?>
<style>
    .img-estudiante{
        height: 100px;
        width: 100px;
    }
    .media-left{
        position: relative;
    }
</style>

<div class="col-xs-12">
    <div class="media-left">
        <?=Html::img('@web/images/'.$estudiante->imageUrl, ['alt'=>$estudiante->nombreCompleto, 'class'=>'media-object img-estudiante'])?>
    </div>
    <div class="media-body">
      <h4 class="media-heading"><?=$estudiante->nombreCompleto?></h4>
      Edad: <?=$estudiante->edad === '-'? '-' : $estudiante->edad?><br/>
      Grupo: <?=$estudiante->grupoActual->nombre?>
    </div>

</div>