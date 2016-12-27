<?php
//Matricula/Acudientes
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Parentesco;

$this->title = 'Acudientes';
$this->params['breadcrumbs'][] = ['label' => 'Matrícula', 'url' => Url::toRoute('matricula/')];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .seleccion-acudientes{
        margin-top: 20px;
    }
    
</style>
<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?=$this->title ?></h3>
    </div>
    <div class="panel-body">
        <div class="acudientes-index">
            <div class="alert alert-info" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4>
                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                    Asignación de acudientes
                </h4>
                El estudiante puede tener más de un acudiente asignado.
                Si el acudiente no tiene un usuario registrado en el sistema se puede registrar desde esta opción.
            </div>
            
            <?=Html::a('<span class="glyphicon glyphicon-plus"></span> Agregar acudiente', '#', ['id'=>'asignar-acudiente','class'=>'btn btn-success'])?>
            <a href="<?=Url::toRoute(['matricula/'])?>" class="btn btn-info">
                <span class="glyphicon glyphicon-fast-backward"></span>
                Volver a Matrículas
            </a>
            <br/>
            <hr/>
            <?=GridView::widget([
                'dataProvider' => $acudientes,
                'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '-'],
                'layout' => '{items}{pager}',
                'emptyText' => 'No tiene acudientes asignados',
                'tableOptions' => [
                    'class' => 'table table-condensed table-hover table-striped table-acudientes',
                    ],
                'columns'=>[
                    ['attribute'=>'nombreCompleto',
                    'label' => 'Nombre',]
                    ,'acudiente.parentescoEntitie.nombre'
                    ,[
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{borrar}',
                        'buttons' => [
                            'borrar' => function ($url,$model) {
                                $url = Url::toRoute(['acudientes/borrar-acudiente','id_usuario'=>$model->id_usuario,'id_estudiante'=>$model->acudiente->id_estudiante]);
                                return Html::a('<span class="glyphicon glyphicon-remove"/>', '#', ['title' => 'Remover Acudiente','id'=>'remove-acud','data-url'=>$url]); 
                            }
                        ],
                    ]
                ]
            ])?>
        </div>
    </div>
</div><?=$this->render('//partials/acudientes_asignar',['id_estudiante'=>$id])?>

<script>
    $(document).ready(function(){
        $('#nuevo-acudiente').on('click',function(){
            window.location = "<?=Url::toRoute(['matricula/nuevo-acudiente','id'=>$id])?>";
        });
        $('#remove-acud').on('click',function(){
            var url = $(this).data('url');
            $.ajax({
                method: 'get',
                url: url,
                success: function(data) {
                    location.reload();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#notify-wrap').notify({ text: 'OcurriÃ³ un error procesando la solicitud', state: 'ui-state-error', timeout: 3000 });
                }
            });
        });
    });
</script>
