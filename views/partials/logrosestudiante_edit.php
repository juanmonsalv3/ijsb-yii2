<?php
use yii\helpers\Html;
use yii\helpers\Url;

if(count($indicadores)===0){
    echo '<div class="alert alert-info" role="alert">No hay indicadores registrados</div>';
    return;
}   
$dimension= $indicadores[0]["dimension"];
?>
    <h4><?=$dimension;?></h4>
    <table class="table table-striped table-condensed table-hover">
<?php
foreach ($indicadores as $indicador) {
    if($dimension !== $indicador["dimension"]){
        $dimension = $indicador["dimension"];
?>
    </table>
    <h4><?=$dimension;?></h4>
    <table class="table table-striped table-condensed table-hover">
<?php
    }
?>
        <tr>
            <td><?=$indicador["descripcion"]?></td>
            
            <td style="padding: 0; width: 30%;">
                
                <?= Html::dropDownList(
                        'cumple'.$indicador["id_indicador"]
                        , $indicador["cumple"]
                        , array('2'=>'Por evaluar','1'=>'Cumple','0'=>'No cumple')
                        , array('class'=>'form-control cumple-nocumple','data-id'=>$indicador["id_indicador"])
                        )?>
            </td>
        </tr>
<?php
}
?>
</table>
<script type="text/javascript">
    var id_estgrp = <?=$estudiantegrupo->id_grupo_estudiante ?>;
    $('.cumple-nocumple').on('change',function(e){
            e.preventDefault();
            var idindicador = $(this).data('id');
            var cumple = $(this).val();
            
            asignarIndicador(idindicador, cumple);
        });
        
    function asignarIndicador(indicador, cumple){
        $.ajax({
                method: 'get',
                url: '<?= Url::toRoute(['estudiantes/indicador-estudiante']); ?>',
                data: { id_estudiante_grupo: id_estgrp, id_indicador : indicador, cumple:cumple} ,
                success: function(data) {
                    mostrarMensaje('Se modificó el indicador');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#notify-wrap').notify({ text: 'Ocurrió un error procesando la solicitud', state: 'ui-state-error', timeout: 3000 });
                }
            });
    }
</script>