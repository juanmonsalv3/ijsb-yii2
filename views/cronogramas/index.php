<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Grupos;

$this->title =  'Cronograma de Actividades';
$this->params['breadcrumbs'][] = ['label' => 'Cronogramas', 'url' => Url::toRoute('cronogramas/')];
$this->params['breadcrumbs'][] = ['label' => $this->title];

$dias = array();
$dias[1] = "Lunes";
$dias[2] = "Martes";
$dias[3] = "Miércoles";
$dias[4] = "Jueves";
$dias[5] = "Viernes";
$dias[6] = "Sábado";
$dias[7] = "Domingo";

$meses = array();
$meses[1]='Enero';
$meses[2]='Febrero';
$meses[3]='Marzo';
$meses[4]='Abril';
$meses[5]='Mayo';
$meses[6]='Junio';
$meses[7]='Julio';
$meses[8]='Agosto';
$meses[9]='Septiembre';
$meses[10]='Octubre';
$meses[11]='Noviembre';
$meses[12]='Diciembre';
?>
<style>
    .tabla-cronogramas td:first-child{
        width: 30%;
    }
    .tabla-cronogramas td:last-child{
        width: 10%;
    }
</style>
<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?=$this->title ?></h3>
    </div>
    <div class="panel-body">
        <?php $f = ActiveForm::begin(['method' => 'get',]); ?>

            <div class="col-md-4">
                <?= $f->field($form, 'id_grupo')->dropDownList($grupos,['prompt'=>'Todos los grupos','onchange'=>'this.form.submit()'])?>
            </div>
        
            <?php $f->end();?>
        <div class="clearfix"></div>
        <div class="col-md-4">
            <a href="#" id="agregar-actividad" class="btn btn-success" >Agregar Actividad</a>
        </div>
        <div class="clearfix"></div>
        <?php
        
        for($i = 1; $i<=12; $i++ ) {
            
            if(array_key_exists ( $i , $actividades ))
            {
                ?>
                <h3><?=$meses[$i] ?></h3>
                <table class='table table-striped table-hover table-condensed tabla-cronogramas'>
                <?php
                foreach($actividades[$i] as $actividad)
                {
                ?>
                    <tr data-id='<?=$actividad['id_actividad']?>' data-grupos="<?=$actividad['grupos']?>" data-fecha="<?=$actividad['fecha']?>">
                        <td><?=$dias[date_format(date_create($actividad['fecha']),'N')].' - '. date_format(date_create($actividad['fecha']),'d').' de '.$meses[$i]?></td>
                        <td><?=$actividad['descripcion']?></td>
                        <td>
                            <a href='#' class='btn-editar'><span class='glyphicon glyphicon-pencil'></span></a>
                            <a href='#' class='btn-eliminar'><span class='glyphicon glyphicon-remove'></span></a>
                        </td>
                    </tr>
                <?php 
                }
                ?>
                </table>
                <?php
            }
        }
        ?>
        
    </div>
</div>
<div id="actividad" class="modal fade" tabindex="-1" role="dialog" id="modal-changes">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nueva actividad</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idactividad"/>
                <div class="row">
                    <div class="col-md-4">
                    <?= Html::label('Fecha','fecha')?>
                    <?= Html::input('date','fecha'
                                ,date('Y-m-d')
                                ,[
                                    'id'=>'fecha'
                                    ,'class'=>'form-control'
                                ])
                        ?>
                    </div>
                    <div class="col-md-8">
                    <?= Html::label('Descripción','descripcion')?>
                    <?= Html::input('descripcion','descripcion'
                                ,''
                                ,[
                                    'id'=>'descripcion'
                                    ,'class'=>'form-control'
                                ])
                        ?>
                    </div>
                </div>
                <div class="col-md-12">
                    <h4>Grupos</h4>
                    <?php foreach($grupos as $id => $nombre){ ?>
                    <div class="col-md-6">
                        <?= Html::checkbox('chk'.$nombre,true,['id'=>'chk'.$nombre,'class'=>'chkgrupo','data-idg'=>$id])?>
                        <?= Html::label($nombre,'chk'.$nombre)?>
                    </div>
                    <?php } ?>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="guardar-btn">Guardar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    
    $(function(){
        $('#agregar-actividad').on('click',function(e){
            e.preventDefault();
            $('#actividad .modal-title').text('Agregar Actividad');
            $('#descripcion').val('');
            $('.chkgrupo').prop('checked',true);
            $('#actividad').modal();
        });
        
        $('.btn-eliminar').on('click',function(e){
            e.preventDefault();
            var id_actividad= $(this).closest('tr').data('id');
            
            $.ajax({
                method: 'get',
                url: '<?= Url::toRoute(['cronogramas/borrar-actividad']); ?>',
                data: { id_actividad: id_actividad} ,
                success: function(data) {
                    location.reload();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#notify-wrap').notify({ text: 'Ocurrió un error procesando la solicitud', state: 'ui-state-error', timeout: 3000 });
                }
            });
        });
        
        $('.btn-editar').on('click',function(e){
            e.preventDefault();
            var $tr = $(this).closest('tr');
            $('#idactividad').val($tr.data('id'));
            var arraygrupos = $tr.data('grupos').split(';');
            $('input.chkgrupo').prop('checked',false);
            for(grupo in arraygrupos)
            {
                $('[data-idg="'+arraygrupos[grupo]+'"]').prop('checked',true);
            }
            $('#fecha').val($tr.data('fecha'));
            $('#descripcion').val($tr.find('td:nth-child(2)').text());
            $('#actividad .modal-title').text('Modificar Actividad');
            $('#actividad').modal();
        });
        
        $('#guardar-btn').on('click',function(e){
            e.preventDefault();
            var id_actividad = $('#idactividad').val();
            var fecha =  $('#fecha').val();
            var descripcion = $('#descripcion').val();
            var grupos = '';

            $('.chkgrupo:checked').each(function(e){
                grupos += $(this).data('idg')+';';
            });

            if(fecha.length === 0)
            {
                alert('Por favor indique una fecha');
                return;
            }
            if(descripcion.length === 0)
            {
                alert('Por favor indique una descripción');
                return;
            }
            if(grupos.length === 0)
            {
                alert('Seleccione al menos un grupo');
                return;
            }

            if(id_actividad.length ===0)
            {
                id_actividad = 0;
            }

           $.ajax({
                method: 'get',
                url: '<?= Url::toRoute(['cronogramas/agregar-actividad']); ?>',
                data: { id_actividad: id_actividad, fecha: fecha, descripcion: descripcion, grupos: grupos} ,
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