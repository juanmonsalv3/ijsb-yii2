<?php

use yii\helpers\Url;

$this->title = 'Acudientes';
$this->params['breadcrumbs'][] = ['label' => 'Estudiantes', 'url' => Url::toRoute(['estudiantes/'])];
$this->params['breadcrumbs'][] = ['label' => 'Estudiante', 'url' => Url::toRoute(['estudiantes/estudiante','id'=>$estudiante->id_estudiante])];
$this->params['breadcrumbs'][] = ['label' => $estudiante->nombreCompleto];
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?=$this->title ?></h3>
    </div>
    <div class="panel-body">
        <div class="estudiante-view">
            <div class="row">
                <?= $this->render( '//partials/estudiante_datosbasicos_view', ['estudiante'=> $estudiante] ); ?>
                <div class="clearfix"></div>
                <hr/>
                <div class="clearfix"></div>
                <br/>
                <div class="col-xs-12">
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modal-acudientes">
                        <span class="glyphicon glyphicon-pencil"></span> Asignar Acudiente
                    </a>
                    <?=$this->render( '//partials/acudientes_edit', ['acudientes'=> $estudiante->idAcudientes] );?>
                </div>
            </div>
        </div>
    </div>
</div>

<?=$this->render('//partials/acudientes_asignar',['id_estudiante'=>$estudiante->id_estudiante])?>

<script>
    $(document).ready(function(){
        $('#nuevo-acudiente').on('click',function(){
            window.location = "<?=Url::toRoute(['estudiantes/nuevo-acudiente','id'=>$estudiante->id_estudiante])?>";
        });
        $('.remove-acudiente').on('click',function(){
           var est = $(this).parents('tr').data('estudiante');
           var usr = $(this).parents('tr').data('usuario');
           
           var url = "<?=Url::toRoute(['acudientes/borrar-acudiente'])?>";
            $.ajax({
                method: 'get',
                data: { id_usuario: usr, id_estudiante: est } ,
                url: url,
                success: function(data) {
                    location.reload();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#notify-wrap').notify({ text: 'Ocurrió un error procesando la solicitud', state: 'ui-state-error', timeout: 3000 });
                }
            });
       });
    });
</script>