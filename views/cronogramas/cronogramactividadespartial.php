<?php
$dias = array();
$dias[1] = "Lunes";
$dias[2] = "Martes";
$dias[3] = "Miércoles";
$dias[4] = "Jueves";
$dias[5] = "Viernes";
$dias[6] = "Sábado";
$dias[7] = "Domingo";

$meses = array();
$meses[1]='Enero';
$meses[2]='Febrero';
$meses[3]='Marzo';
$meses[4]='Abril';
$meses[5]='Mayo';
$meses[6]='Junio';
$meses[7]='Julio';
$meses[8]='Agosto';
$meses[9]='Septiembre';
$meses[10]='Octubre';
$meses[11]='Noviembre';
$meses[12]='Diciembre';
?>
<style>
    .tabla-cronogramas td:first-child{
        width: 30%;
    }
</style>
<?php
if(count($actividades) == 0){
    echo '<div class="alert alert-info" role="alert">No se han registrado actividades</div>';
    return;
}
    
    for($i = 1; $i<=12; $i++ ) {

        if(array_key_exists ( $i , $actividades ))
        {
            ?>
            <h4><?=$meses[$i] ?></h4>
            <table class='table table-striped table-hover table-condensed tabla-cronogramas'>
            <?php
            foreach($actividades[$i] as $actividad)
            {
                
            ?>
                <tr data-id='<?=$actividad['id_actividad']?>' data-grupos="<?=$actividad['grupos']?>" data-fecha="<?=$actividad['fecha']?>">
                    <td><?= date_format(date_create($actividad['fecha']),'d').' de '.$meses[$i].' - '.$dias[date_format(date_create($actividad['fecha']),'N')]?></td>
                    <td><?=$actividad['descripcion']?></td>
                </tr>
            <?php 
            }
            ?>
            </table>
            <?php
        }
    }
?>