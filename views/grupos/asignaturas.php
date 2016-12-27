<?php
use yii\helpers\Url;

?>
<style>
    .table-hover tr{
        cursor: pointer;
    }
</style>
<table id="tabla-asignaturas" class="table table-striped table-hover">
    <?php if(count($asignaturas)==0):?>
    <tr><td>No hay asignaturas registradas aún.</td></tr>
    <?php endif;?>
    <?php foreach ($asignaturas as $asignatura):?>
        <tr class="select">
            <td><?=$asignatura->nombre?></td>
            <td><input type="hidden" value="<?=$asignatura->id_asignatura?>" class="id_asignatura"/></td>
        </tr>
    <?php endforeach?>
</table>
<script type="text/javascript">
    $('#tabla-asignaturas').on('click', 'tr.select', function() {
        $(this).addClass('success').siblings().removeClass('success');
    });
</script>
