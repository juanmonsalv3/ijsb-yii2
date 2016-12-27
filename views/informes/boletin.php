<style>
    .datos-estudiante{
        font-size: 12px;
        border-bottom: 1px solid #000;
        padding-bottom: 5px;
        margin-bottom: 5px;
        padding-top: 5px;
    }
    .nombres-apellidos{
        width: 45%;
        float: left;
    }
    .datos-estudiante .label{
        display: block;
        float:left;
        font-weight: bold;
        width: 30%;
    }
    .datos-estudiante .dato{
        display: block;
        float:left;
        width:60%;
        border: 1px solid #000;
        padding-left: 10px;
    }
    .nombre-estudiante{
        margin-bottom: 2px;
    }
    .periodo-grupo{
        float: left;
        width: 30%;
    }
    .periodo-grupo .label{
        width: 35%;
    }
    .periodo-grupo .dato{
        width: 45%;
    }
    .periodo{
        margin-bottom: 2px;
    }
    .fecha-anio .label{
        width: 30%;
    }
    .fecha-anio .dato{
        width: 50%;
    }
    .fecha-anio .fecha{
        margin-bottom: 2px;
    }
    .indicadores{
        margin-left: 0;
        padding-left: 0;
        font-family: 'Calibri';
        margin-top: 0;
        font-size: 13px;
    }
    .indicadores li{
        padding-bottom: 2px;
    }
    .dimension{
        font-family: 'Cambria';
        font-weight: bold;
        list-style:  none;
        width: 100%;
        text-transform: uppercase;
        border-bottom: 1px solid #000;
        margin-top: 12px;
        margin-bottom: 5px;
        font-size: 14px;
    }

</style>
<div class="datos-estudiante">
    <div class="nombres-apellidos">
        <div class="nombre-estudiante">
            <div class="label">NAME: </div>
            <div class="dato"><?=$estudiante->nombres ?></div>
        </div>
        <div class="apellido-estudiante">
            <div class="label">LAST NAME: </div>
            <div class="dato"><?=$estudiante->apellidos ?></div>
        </div>
    </div>
    <div class="periodo-grupo">
        <div class="periodo">
            <div class="label">PERIOD: </div>
            <div class="dato"><?=$periodo ?></div>
        </div>
        <div class="grupo">
            <div class="label">GRADE: </div>
            <div class="dato"><?=strtoupper($estudiante->grupoActual->nombre_ingles) ?></div>
        </div>
    </div>
    <div class="fecha-anio">
        <div class="fecha">
            <?php ini_set('date.timezone','America/Bogota'); ?>
            <div class="label">DATE: </div>
            <div class="dato"><?= date('d-m'); ?></div>
        </div>
        <div class="anio">
            <div class="label">YEAR: </div>
            <div class="dato"><?=date('Y') ?></div>
        </div>
    </div>
</div>
<div style="clear:both;"></div>
<?php
$aux ='';
echo '<ul class="indicadores">';
foreach($indicadores as $indicador){
    if($aux !== $indicador->dimension)
    {
        $aux = $indicador->dimension;
        echo '<li class="dimension">'.$indicador->dimension_ingles.'</li>';
    }
    echo '<li>'.$indicador->descripcion.'</li>';
}
echo '</ul>';
?>

