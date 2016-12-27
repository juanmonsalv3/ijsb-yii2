<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Parentesco;
?>
<style>
    .seleccion-acudientes{
        margin: 10px;
    }
    .seleccion-acudientes .grid-view table tr td{
        cursor: pointer
    }
    .oculto{
        visibility: hidden;
    }
    
</style>
<!-- Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-acudientes">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Asignar Acudiente</h4>
      </div>
      <div class="modal-body">
        
          <div class="clearfix"></div>
          <div class="col-md-6">
            <?= Html::label('Buscar','busqueda')?>
            <?= Html::textInput('busqueda'
                    ,''
                    ,[
                        'id'=>'busqueda'
                        ,'class'=>'form-control'
                    ])
            ?>
            </div>
          <div class="col-md-6 oculto parentesco" >
            <?= Html::label('Parentesco','parentesco')?>
            <?= Html::dropDownList('parentesco'
                    ,'1'
                    ,ArrayHelper::map(Parentesco::find()->orderBy('id_parentesco')->all(), 'id_parentesco', 'nombre')
                    ,[
                        'id'=>'parentesco'
                        ,'class'=>'form-control'
                    ])
            ?>
            </div>
            <div class="clearfix"></div>

            <div class="seleccion-acudientes">
                <table class="table table-condensed table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                        </tr>
                      </thead>
                  <tbody>
                  </tbody>
                </table>
            </div>
            
      </div>
      <div class="modal-footer">
        <button type="button" id="modal-cerrar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button id="nuevo-acudiente" class='btn btn-success'>Registrar nuevo</button>
        <button id="modal-guardar" type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    var id = <?=$id_estudiante?>; 
    $(document).ready(function(){
        $('.seleccion-acudientes').on('click', 'table tbody tr:not(.noselect)[data-key]', function() {
            $(this).addClass('success').siblings().removeClass('success');
            $('.parentesco').removeClass('oculto');
        });
        $('#asignar-acudiente').on('click',function(){
            $('#busqueda').val('');
            $('.seleccion-acudientes table tbody').html('');
            $('.seleccion-acudientes table tbody').html('<tr class="noselect"><td></td></tr>');
            $('.parentesco').addClass('oculto');
            $('#modal-acudientes').modal();
        });
        $('#busqueda').on('input',function(){
            var text = $(this).val();
            $.ajax({
                method: 'get',
                url: '<?= Url::toRoute(['acudientes/seleccion-acudientes']); ?>',
                data: { id: id, search:text} ,
                success: function(data) {
                    $('.seleccion-acudientes').html(data);
                    $('.parentesco').addClass('oculto');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#notify-wrap').notify({ text: 'Ocurrió un error procesando la solicitud', state: 'ui-state-error', timeout: 3000 });
                }
            });
        });
        $('#modal-guardar').on('click',function(){
            var parentesco = $('#parentesco').val();
            var $tr = $('.seleccion-acudientes table tr.success');
            if($tr.length===0)
            {
                alert('Seleccione un acudiente.');
                return;
            }
            if(parentesco.length === 0)
            {
                alert('Indique el parentesco del acudiente con el estudiante.');
                return;
            }
            $.ajax({
                method: 'get',
                url: '<?= Url::toRoute(['acudientes/asignar-acudiente']); ?>',
                data: { id_estudiante: id, id_usuario:$($tr).data('key'), parentesco: parentesco} ,
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