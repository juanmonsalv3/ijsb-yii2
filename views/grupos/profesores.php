<?php
use yii\helpers\Url;

?>
<style>
    .table-hover tr{
        cursor: pointer;
    }
</style>
<table id="tabla-profesores" class="table table-striped table-hover">
    <?php if(count($profesores)==0):?>
    <tr><td>No hay profesores registrados aún. Puede registrarlos en la opción <a href="<?=Url::toRoute(['usuarios/'])?>">Usuarios</a></td></tr>
    <?php endif;?>
    <?php foreach ($profesores as $profesor):?>
        <tr class="select 
            <?php if($profesor_grupo!=null){
                echo $profesor_grupo->id_usuario == $profesor->id_usuario? 'success': ''; 
            }?>
            ">
            <td><?=$profesor->nombrecompleto?></td>
            <td><input type="hidden" value="<?=$profesor->id_usuario?>" class="id_usuario"/></td>
        </tr>
    <?php endforeach?>
</table>
<?php if(count($profesores)>0):?>
<script type="text/javascript">
    $('#tabla-profesores').on('click', 'tr.select', function() {
        $(this).addClass('success').siblings().removeClass('success');
    });
</script>
<?php endif;?>
