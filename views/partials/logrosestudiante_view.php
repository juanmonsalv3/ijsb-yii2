<?php
if(count($logros)===0){
    echo '<div class="alert alert-info" role="alert">No hay Logros registrados</div>';
    return;
}   
$dimension= $logros[0]->indicador->dimension->nombre;
?>
    <h4><?=$dimension;?></h4>
    <table class="table table-striped table-condensed table-hover">
<?php
foreach ($logros as $logro) {
    if($dimension !== $logro->indicador->dimension->nombre){
        $dimension = $logro->indicador->dimension->nombre;
?>
    </table>
    <h4><?=$dimension;?></h4>
    <table class="table table-striped table-condensed table-hover">
<?php
    }
?>
        <tr>
            <td width="50px"><span class="glyphicon glyphicon-<?=$logro->cumple?'ok':'remove'?>"></span></td>
            <td>
                <?php if($logro->cumple ==1): ?>
                <?=$logro->indicador->descripcion_cumple_masc?>
                <?php else: ?>
                <?=$logro->indicador->descripcion_nocumple_masc?>
                <?php endif; ?>
            </td>
        </tr>
<?php
}
?>
</table>
