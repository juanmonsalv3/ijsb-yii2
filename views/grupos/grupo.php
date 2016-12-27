<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title =  $grupo->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Grupos', 'url' => Url::toRoute('grupos/')];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<style>
    .modificar-horario{
        display: inline-block;
        font-weight: bold;
        margin: 15px 0;
    }
</style>

<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?=$this->title ?></h3>
    </div>
    <div class="panel-body">
        <div class="site-index">
            <div class="row">
                <div class="col-xs-12">
                    <h3><?=$grupo->nombre?></h3>
                    <h4><?=$grupo->descripcion?></h4>

                    <br/>

                    <div class="col-xs-12 col-lg-6">
                        <label for="profesor">Docente:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" disabled="true" id="profesor" value="<?=(count($grupo->profesores) >0?$grupo->profesores->nombrecompleto:"No hay profesor asignado" ) ?>"/>
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" id='modify-teacher'>
                                    <span class="glyphicon glyphicon-<?=($grupo->profesores!=null?'pencil" title="Cambiar Profesor':'plus" title="Asignar Profesor')?>"></span>
                                </button>
                            </span>
                        </div><!-- /input-group -->
                    </div>
                </div>
                
                <div class="clearfix"></div>
                <ul class="nav nav-tabs" role="tablist" style="margin-top: 40px;">
                    <li role="presentation" class="active"><a href="#estudiantes" data-toggle="tab"><b>Estudiantes</b></a></li>
                    <li role="presentation" ><a href="#asignaturas" data-toggle="tab"><b>Asignaturas</b></a></li>
                    <li role="presentation"><a href="#horario" data-toggle="tab"><b>Horario</b></a></li>
                    <li role="presentation"><a href="#cronograma" data-toggle="tab"><b>Cronograma de Actividades</b></a></li>
                    <li role="presentation"><a href="#indicadores" data-toggle="tab"><b>Indicadores</b></a></li>
                 </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in" id="asignaturas">
                        <div class="col-xs-12">
                            <h3>Asignaturas</h3>
                            <a class="btn btn-success" id="agregar-asignatura">Agregar Asignatura</a>
                            <br/><br/>
                            <div class="asignaturas-grupo">
                                <?=$this->render('//partials/asignaturasgrupo_edit',['asignaturas'=>$grupo->asignaturas])?>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="active tab-pane fade in" id="estudiantes">
                        <div class="col-xs-12">
                            <h3>Estudiantes</h3>
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nombres</th>
                                        <th>Edad</th>
                                        <th>Sexo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($grupo->estudiantes as $estudiante):?>
                                    <tr>
                                        <td><?=$estudiante->nombreCompleto?></td>
                                        <td><?=$estudiante->edad?></td>
                                        <td><?=$estudiante->sexo?></td>
                                        <td>
                                            <?php
                                                $url = Url::toRoute(['estudiantes/estudiante','id'=>$estudiante->id_estudiante]);
                                                echo Html::a('<span class="glyphicon glyphicon-eye-open"/>', $url, ['title' => 'Ver datos del estudiante']);
                                            ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade in" id="horario">
                        <div class="col-xs-12">
                            <h3>Horario</h3>        
                            <?=Html::a('Modificar Horario', Url::toRoute(['grupos/horario','id_grupo'=>$grupo->id_grupo]),['class'=>'btn btn-primary'])?>
                            <hr/>
                            <?= $this->render('//partials/horario_view',['horario'=>$horario,'horas'=>$horas])?>
                        </div>
                    </div>
                    <div class="tab-pane fade in" id="cronograma">
                        <div class="col-xs-12">
                            <h3>Cronograma de Actividades</h3>
                            <a href="<?=Url::toRoute('cronogramas/')?>" class="btn btn-success">Agregar Actividades</a>
                            <br/><br/>                            
                            <?= $this->render( '//cronogramas/cronogramactividadespartial', ['actividades'=> $cronograma] ); ?>
                        </div>
                    </div>
                    <div class="tab-pane fade in" id="indicadores">
                        <div class="col-xs-12">
                            <h3>Indicadores</h3>
                            <a href="<?=Url::toRoute('indicadores/')?>" class="btn btn-success">Agregar Indicadores</a>
                            <br/><br/>
                            <div class="row col-xs-12 col-sm-6 col-md-4">
                                <label for="periodo">Periodo</label>
                                <?= Html::dropDownList('periodo'
                                        , Yii::$app->cache->get('parametros')['periodoencurso']['valor']
                                        , ['1'=>'Primer Período','2'=>'Segundo Período','3'=>'Tercer Período','4'=>'Cuarto Período']
                                        , ['class'=>'form-control', 'id'=>'periodo']) ?>
                            </div>
                            <div class="clearfix"></div>
                            <br/>
                            <div class="indicadores">
                                <?= $this->render( '//partials/indicadores_lista_view', ['indicadores'=> $indicadores] ); ?>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-changes">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="guardar-btn">Guardar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
    var id_grupo= <?=$grupo->id_grupo?>;
    var nombre_grupo= "<?=$grupo->nombre?>";
    var option="";
    $(document).ready(function (){
        $('#modify-teacher').on('click',function(){
            option= "profesor";
            $('.modal-title').html('Asignar Profesor');
            $.ajax({
                method: 'get',
                url: '<?= Url::toRoute(['grupos/profesores']); ?>',
                data: { id_grupo: id_grupo},
                success: function(data) {
                    $('.modal-body').html(data);
                    $('#modal-changes').modal();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#notify-wrap').notify({ text: 'Ocurrió un error procesando la solicitud', state: 'ui-state-error', timeout: 3000 });
                }
             });
        });
        
        $('#agregar-asignatura').on('click',function(){
            option= "asignatura";
            $('.modal-title').html('Asignar Asignatura');
            $.ajax({
                method: 'get',
                url: '<?= Url::toRoute(['grupos/asignaturas']); ?>',
                data: { id_grupo: id_grupo},
                success: function(data) {
                    $('.modal-body').html(data);
                    $('#modal-changes').modal();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#notify-wrap').notify({ text: 'Ocurrió un error procesando la solicitud', state: 'ui-state-error', timeout: 3000 });
                }
             });
        });
        $('#guardar-btn').on('click',function(){
            switch (option)
            {
                case "profesor":
                    asignarProfesor();
                    break;
                case "asignatura":
                    asignarAsignatura();
                    break;
                default:
                    break;
            }
        });
        
        $(document).on('click','.remove-asignatura',function(e){
            e.preventDefault();
            if(confirm('¿Está seguro que desea desactivar la asignatura seleccionada?')){
                var id_asignatura = $(this).data('key');
                $.ajax({
                    method: 'get',
                    url: '<?= Url::toRoute(['grupos/remover-asignatura']); ?>',
                    data: { id_grupo: id_grupo, id_asignatura : id_asignatura} ,
                    success: function(data) {
                        $('.asignaturas-grupo').html(data);
                        $('#modal-changes').modal('hide');
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $('#notify-wrap').notify({ text: 'Ocurrió un error procesando la solicitud', state: 'ui-state-error', timeout: 3000 });
                    }
                });
            } 
        });
        $('#periodo').change(function(){
            var periodo = $('#periodo').val();
           $.ajax({
                method: 'get',
                url: '<?= Url::toRoute(['indicadores/indicadores-partial']); ?>',
                data: { id_grupo: id_grupo, periodo: periodo } ,
                success: function(data) {
                    $('.indicadores').html(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#notify-wrap').notify({ text: 'Ocurrió un error procesando la solicitud', state: 'ui-state-error', timeout: 3000 });
                }
            });
        });
    });
    
    function asignarProfesor(){
        if($('#tabla-profesores tr.success').length){
            if(confirm('¿Está seguro que desea asignar este profesor al grupo '+nombre_grupo+'?')){
                var id_prof = $('#tabla-profesores tr.success .id_usuario').val();
                $.ajax({
                    method: 'get',
                    url: '<?= Url::toRoute(['grupos/asignar-profesor']); ?>',
                    data: { id_grupo: id_grupo, id_profesor : id_prof} ,
                    success: function(data) {
                        var response = JSON.parse(data);
                        $('#profesor').val(response.nombre);
                        $('#notify-wrap').notify({ text: response.msg, state: 'ui-state-'+(response.status?'success':'error'), timeout: 3000 });
                        $('#modal-changes').modal('hide');
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $('#notify-wrap').notify({ text: 'Ocurrió un error procesando la solicitud', state: 'ui-state-error', timeout: 3000 });
                    }
                });
            }
        }
    }
    
    function asignarAsignatura(){
        if($('#tabla-asignaturas tr.success').length){
            if(confirm('¿Está seguro que desea guardar?')){
                var id_asignatura = $('#tabla-asignaturas tr.success .id_asignatura').val();
                $.ajax({
                    method: 'get',
                    url: '<?= Url::toRoute(['grupos/asignar-asignatura']); ?>',
                    data: { id_grupo: id_grupo, id_asignatura : id_asignatura} ,
                    success: function(data) {
                        $('.asignaturas-grupo').html(data);
                        $('#modal-changes').modal('hide');
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $('#notify-wrap').notify({ text: 'Ocurrió un error procesando la solicitud', state: 'ui-state-error', timeout: 3000 });
                    }
                });
            }
        }
    }
</script>