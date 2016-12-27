<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Configuración';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .btn-editar.disabled> span.glyphicon{
        color: #ccc;
        cursor: not-allowed;
    }
</style>
<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?=$this->title ?></h3>
    </div>
    <div class="panel-body">
        <div class="parametros-index">
            <fieldset>
                    <div class="col-md-4"> 
                        <?= Html::label($parametros['anioencurso']['nombre'],'anioencurso')?>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <a href="#" data-codigo="anioencurso" class="btn-editar">
                                    <span class="glyphicon glyphicon-pencil" ></span>
                                </a>
                            </span>    
                        <?= Html::textInput('anioencurso'
                                ,$parametros['anioencurso']['valor']
                                ,[
                                    'id'=>'anioencurso'
                                    ,'class'=>'form-control param'
                                    ,'disabled'=>'disabled'
                                    ,'data-value'=>$parametros['anioencurso']['valor']
                                ])
                        ?>
                        </div>
                    </div>
                    
                    <div class="col-md-4"> 
                        <?= Html::label($parametros['periodoencurso']['nombre'],'periodoencurso')?>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <a href="#" data-codigo="periodoencurso" class="btn-editar">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                            </span>    
                        <?= Html::dropDownList('periodoencurso'
                                    , $parametros['periodoencurso']['valor']
                                    , ["1"=>"Primer Período","2"=>"Segundo Período","3"=>"Tercer Período","4"=>"Cuarto Período"]
                                    ,[
                                        'id'=>'periodoencurso'
                                        ,'class'=>'form-control param'
                                        ,'disabled'=>'disabled'
                                        ,'data-value'=>$parametros['anioencurso']['valor']
                                    ]
                                )
                        ?>
                        </div>
                    </div>
            </fieldset>
            <hr/>
            <fieldset id="matriculas">
                <?= Html::checkbox('matriculasactivas', boolval($parametros['matriculasactivas']['valor']),['id'=>'matriculasactivas'])?>
                <?= Html::label($parametros['matriculasactivas']['nombre'],'matriculasactivas')?>
                <br><br>
                <div class="col-md-12 form-group">
                    <div class="col-md-4"> 
                        <?= Html::label($parametros['aniomatricula']['nombre'],'aniomatricula')?>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <a href="#" data-codigo="aniomatricula" class="btn-editar">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                            </span>    
                        <?= Html::textInput('aniomatricula'
                                ,$parametros['aniomatricula']['valor']
                                ,[
                                    'id'=>'aniomatricula'
                                    ,'class'=>'form-control param'
                                    ,'disabled'=>'disabled'
                                    ,'data-value'=>$parametros['anioencurso']['valor']
                                ])
                        ?>
                        </div>
                    </div>
                    
<!--                    <div class="col-md-4"> 
                        <?= Html::label($parametros['fechafinalmatriculas']['nombre'],'fechafinalmatriculas')?>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <a href="#" data-codigo="fechafinalmatriculas" class="btn-editar">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                            </span>    
                        <?= Html::input('date','fechafinalmatriculas'
                                ,$parametros['fechafinalmatriculas']['valor']
                                ,[
                                    'id'=>'fechafinalmatriculas'
                                    ,'class'=>'form-control param'
                                    ,'disabled'=>'disabled'
                                    ,'data-value'=>$parametros['fechafinalmatriculas']['valor']
                                ])
                        ?>
                        </div>
                    </div>-->
                </div>
            </fieldset>
            <hr/>
            <fieldset id="inscripciones">
                <?= Html::checkbox('inscripcionesactivas', boolval($parametros['inscripcionesactivas']['valor']),['id'=>'inscripcionesactivas'])?>
                <?= Html::label($parametros['inscripcionesactivas']['nombre'],'inscripcionesactivas')?>
                <br><br>
<!--                <div class="col-md-12 form-group">
                    <div class="col-md-4"> 
                        <?= Html::label($parametros['fechafinalinscripcio']['nombre'],'fechafinalinscripcio')?>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <a href="#" data-codigo="fechafinalinscripcio" class="btn-editar">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                            </span>    
                        <?= Html::input('date','fechafinalinscripcio'
                                ,$parametros['fechafinalinscripcio']['valor']
                                ,[
                                    'id'=>'fechafinalinscripcio'
                                    ,'class'=>'form-control param'
                                    ,'disabled'=>'disabled'
                                    ,'data-value'=>$parametros['fechafinalinscripcio']['valor']
                                ])
                        ?>
                        </div>
                    </div>
                </div>-->
            </fieldset>
            <hr/>
            <a class="btn btn-primary" href="<?=Url::toRoute('parametros/cierre')?>" >Cierre Académico</a>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('.btn-editar').on('click',function(e){
            e.preventDefault();
            if($(this).hasClass('disabled')){
                return;
            }
            
            var span = $(this).children('span.glyphicon');
            if(span.hasClass('glyphicon-pencil'))
            {
                if($('.glyphicon-floppy-disk').length>0){
                    if(!confirm('Se perderán los cambios que no ha guardado, ¿desea continuar?')){
                       return;
                    }
                    reiniciarTodos();
                }
                span.removeClass('glyphicon-pencil').addClass('glyphicon-floppy-disk');
                $('#'+$(this).data('codigo')).removeAttr('disabled');
            }
            else
            {
                
                guardarParam($(this).data('codigo'));
            }
        });
        $('input.param').keyup(function(e) {
            if (e.keyCode === 27) { 
               reiniciarTodos();
            }
            if (e.keyCode === 13) { 
               guardarParam($(this).prop('id'));
            }
        });
        if($('#matriculasactivas').prop('checked')===false){
             $('fieldset#matriculas .btn-editar').addClass('disabled');
        }
        if($('#inscripcionesactivas').prop('checked')===false){
             $('fieldset#inscripciones .btn-editar').addClass('disabled');
        }
        $('#matriculasactivas').on('change',function(){
            var textoad= 'desactivar';
            if($(this).prop('checked'))
            {
                textoad='activar';
            }
            if(!confirm('¿Confirma que desea '+textoad+' el período de matrículas?')){
                return;
            }
            guardarParamAjax('matriculasactivas',$(this).prop('checked'));
        });
        
        $('#inscripcionesactivas').on('change',function(){
            var textoad= 'desactivar';
            if($(this).prop('checked'))
            {
                textoad='activar';
            }
            if(!confirm('¿Confirma que desea '+textoad+' el período de matrículas?')){
                return;
            }
            guardarParamAjax('inscripcionesactivas',$(this).prop('checked'));
        });
       
    });
    
    function reiniciarTodos(){
        $('.param:not(:disabled)').each(function(){
            $(this).val($(this).data('value')).prop('disabled','disabled');
        });
        $('.glyphicon-floppy-disk').removeClass('glyphicon-floppy-disk').addClass('glyphicon-pencil');
    }
    
    function guardarParam(codigoparam){
        if(!confirm('¿Confirma que desea guardar el parámetro modificado?')){
            return;
        }
        var input =  $('#'+codigoparam);
        
        guardarParamAjax(input.prop('id'),input.val());
    };
    
    function guardarParamAjax(codigo, valor){
        $.ajax({
            method: 'get',
            url: '<?= Url::toRoute(['parametros/modificar-parametro']); ?>',
            data: { codigo: codigo, valor:valor} ,
            success: function(data) {
                location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('#notify-wrap').notify({ text: 'Ocurrió un error procesando la solicitud', state: 'ui-state-error', timeout: 3000 });
            }
        });
    }
    
</script>