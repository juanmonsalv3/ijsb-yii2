
<table class="table table-bordered table-responsive table-horarios">
    <thead>
        <tr>
            <th>Lunes</th>
            <th>Martes</th>
            <th>Miércoles</th>
            <th>Jueves</th>
            <th>Viernes</th>
        </tr>
    </thead>
    <tbody>
        <?php for ($i=1;$i<9;$i++) {?>
            <tr> 
            <?php for ($j=1;$j<6;$j++) {?>
                <td title="<?=$horas[$i]?>"><?=is_null($horario[$i][$j])? '-' : $horario[$i][$j]?></td>
            <?php } ?>
            </tr>
        <?php } ?>
    </tbody>
</table>