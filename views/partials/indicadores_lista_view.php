<?php
if(count($indicadores)===0){
    echo '<div class="alert alert-info" role="alert">No hay indicadores registrados para este periodo</div>';
    return;
}   
$dimension= $indicadores[0]->dimension->nombre;
?>
    <h4><?=$dimension;?></h4>
    <table class="table table-striped table-condensed table-hover">
<?php
foreach ($indicadores as $indicador) {
    if($dimension !== $indicador->dimension->nombre){
        $dimension = $indicador->dimension->nombre;
?>
    </table>
    <h4><?=$dimension;?></h4>
    <table class="table table-striped table-condensed table-hover">
<?php
    }
?>
        <tr><td><?=$indicador->descripcion?></td></tr>
<?php
}
?>
</table>
