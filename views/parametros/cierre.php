<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Cierre Académico';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    #accordion .panel .panel-title a:hover,
    #accordion .panel .panel-title a:focus{
        text-decoration: none;
    }
    #accordion .list-group-item{
        padding: 2px;
    }
    #accordion .list-group-item .nombre{
        padding-top: 10px;
        padding-left: 20px;
    }
    #accordion a.panel-heading{
        display: block;
    }
    .nombre{
        width: 48%;
        float: left;
    }
    .estado{
        width: 200px;
        float: right;
    }
</style>
<div clas="cierre-index">
    <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><?=$this->title ?></h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12">
                    <div class="alert alert-warning" role="alert">
                        <strong>Cierre Académico!</strong>
                        El proceso de cierre académico se debe realizar solo al final del año escolar y consiste en indicar para cada estudiante si fue <strong>Promovido</strong> o  <strong>No Promovido</strong> para el siguiente año.
                        Una vez se realice el cierre, el sistema funcionará con datos del siguiente año Escolar y se activarán las matrículas e inscripciones para el siguiente año.
                    </div>
                    
                    <a href="<?=Url::toRoute('parametros/cerrar')?>" id="cerrar" class="btn btn-primary">Realizar Cierre</a>
                    <hr/>
                    
                    <div class="panel-group" id="accordion" >
                        <?php 
                        $grupo = '';
                        foreach ($matriculados as $buscagrupo):
                            if($grupo != $buscagrupo->grupo->nombre):
                                $grupo = $buscagrupo->grupo->nombre;
                        ?>
                        <div class="panel panel-default">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$grupo?>" class="panel-heading" id="heading<?=$grupo?>">
                                <h4 class="panel-title">
                                        <span class="glyphicon glyphicon-triangle-bottom"></span>  
                                        <?=$grupo?>
                                </h4>
                            </a>
                            <div id="collapse<?=$grupo?>" class="panel-collapse collapse" >
                                <ul class="list-group">
                                    <?php 
                                    foreach ($matriculados as $matriculado):
                                        if($grupo == $matriculado->grupo->nombre):
                                    ?>
                                            <li class="list-group-item">
                                                <div class="nombre">
                                                    <?=$matriculado->estudiante->nombreCompleto?>
                                                </div>
                                                <div class="estado">
                                                    <?=Html::dropDownList('estado'
                                                            ,$matriculado->estado
                                                            ,['A'=>'Activo', 'P'=>'Promovido', 'N'=>'No Promovido']
                                                            ,['class'=>'form-control estado '.($matriculado->estado == 'A'?'falta':'')
                                                                ,'data-key'=>$matriculado->id_grupo_estudiante]
                                                            )?>
                                                </div>
                                                <div class="clearfix"></div>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach;?>
                                </ul>
                            </div>
                        </div>
                            <?php endif; ?>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function (){
       $('.estado').on('change',function(){
           var grupo_est = $(this).data('key');
           var estado = $(this).val();
           if(grupo_est === undefined || estado === undefined){return;}
           if(estado === 'A'){
               $(this).addClass('falta');
           }else{
               $(this).removeClass('falta');
           }
            $.ajax({
                method: 'get',
                url: '<?= Url::toRoute(['parametros/estado-estudiante']); ?>',
                data: { id_grupo_estudiante: grupo_est, estado: estado } ,
                success: function() {
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#notify-wrap').notify({ text: 'Ocurrió un error procesando la solicitud', state: 'ui-state-error', timeout: 3000 });
                }
            });
        });
        $('#cerrar').on('click',function(e){
            e.preventDefault();
            if($('.falta').length > 0){
                var conf = confirm('Faltan estudiantes por verificar ¿Desea continuar aprobándolos a todos?');
                if(!conf){ return; }
                window.location = $(this).prop('href');
            }
            else{
                var conf = confirm('¿Confirma que desea realizar el cierre académico?');
                if(!conf){ return; }
                window.location = $(this).prop('href');
            }
        });
       
    });
</script>