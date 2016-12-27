<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title =  $grupo->nombre.' - Horario';
$this->params['breadcrumbs'][] = ['label' => 'Grupos', 'url' => Url::toRoute('grupos/')];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<style>
    .table-horarios td{
        position: relative;
    }
    .table-horarios .edit-add{
        position: absolute;
        bottom: 0;
        right: 0;
        font-size: 90%;
    }
</style>
<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?=$this->title ?></h3>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-responsive table-horarios">
            <thead>
                <tr>
                    <th>Lunes</th>
                    <th>Martes</th>
                    <th>Miércoles</th>
                    <th>Jueves</th>
                    <th>Viernes</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i=1;$i<9;$i++) {?>
                    <tr> 
                    <?php for ($j=1;$j<6;$j++) {?>
                        <td title='<?=$horas[$i]?>'>
                            
                           <?php if($horario[$i][$j] == null){ ?>
                            -
                            <a href="#" class="edit-add" data-dia="<?=$j?>" data-hora="<?=$i?>">
                                <span class="glyphicon glyphicon-plus" ></span>
                            </a>
                            <?php } else{ ?>
                            <?=$horario[$i][$j]?>
                            <a href="#" class="edit-add" data-dia="<?=$j?>" data-hora="<?=$i?>">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                            <?php } ?>
                        </td>
                    <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-changes">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Asignar</h4>
            </div>
            <div class="modal-body">
                <?=Html::radio('tipo-asignatura', true,['id'=>'tipo-asignatura'])?>
                <?= Html::label('Asignatura','tipo-asignatura')?>
                <div class="row">
                    <div class="col-md-12">
                        <?=Html::dropDownList('asignatura'
                                ,null
                                ,ArrayHelper::map($asignaturas,'id_asignatura','nombre')
                                ,[
                                    'prompt'=>'...',
                                    'id'=>'drp-asignatura',
                                    'class'=>'form-control'
                                ]
                                )?>
                    </div>
                    <br/><br/><br/>
                    <div class="col-md-12">
                        <?=Html::radio('tipo-actividad', false,['id'=>'tipo-actividad'])?>
                        <?= Html::label('Otra actividad','tipo-actividad')?>
                        <div class="row">
                            <div class="col-md-12">
                                <?=Html::input('text','actividad','',['id'=>'txt-actividad','class'=>'form-control','disabled'=>'disabled'])?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <br/>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="guardar-btn">Guardar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    var id_grupo = <?=$grupo->id_grupo?>;
    var dia=0;
    var hora=0;
    var asignatura=0;
    var actividad ='';
    $(function(){
        $('.edit-add').on('click',function(e){
            e.preventDefault();
            dia = $(this).data('dia');
            hora = $(this).data('hora');
            $('#modal-changes').modal();
        });

        $('#tipo-asignatura').change(function(){
            var checked = $(this).prop('checked');
            $('#tipo-actividad').prop('checked',!checked);
            estadosModal();
        });

        $('#tipo-actividad').change(function(){
            var checked = $(this).prop('checked');
            $('#tipo-asignatura').prop('checked',!checked);
            estadosModal();
        });
        $('#guardar-btn').on('click',function(){
            asignatura = $('#drp-asignatura').val() !== undefined ? $('#drp-asignatura').val() : 0;
            actividad = $('#txt-actividad').val();
            
            if($('#tipo-actividad').prop('checked') && actividad.length ===0){
                alert('La actividad no puede estar en blanco.');
                return;
            }
            if($('#tipo-asignatura').prop('checked') && asignatura<=0){
                alert('Seleccione una asignatura.');
                return;
            }
            
            $.ajax({
                    method: 'get',
                    url: '<?= Url::toRoute(['grupos/asignar-horario']); ?>',
                    data: { id_grupo: id_grupo, dia:dia, hora:hora, asignatura : asignatura, actividad:actividad} ,
                    success: function(data) {
                        setTimeout(function(){
                            location.reload();
                        },100);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $('#notify-wrap').notify({ text: 'Ocurrió un error procesando la solicitud', state: 'ui-state-error', timeout: 3000 });
                    }
                });
            
            
        });
    });
    
    
    function estadosModal()
    {
        if($('#tipo-actividad').prop('checked')){
            $('#txt-actividad').prop('disabled',false);
            $('#drp-asignatura').prop('disabled','disabled');
        }
        else
        {
            $('#drp-asignatura').prop('disabled',false);
            $('#txt-actividad').prop('disabled','disabled');
        }
    }
    
</script>