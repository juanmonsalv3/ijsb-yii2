<?php if(count($asignaturas)==0):?>
    <div class="alert alert-info" role="alert">No se han agregado asignaturas al grupo</div>
    <?php return; ?>
<?php endif?>

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Asignatura</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($asignaturas as $asignatura):?>
        <tr>
            <td><?=$asignatura->nombre?></td>
            <td>
                <a href="#" class="remove-asignatura" data-key="<?=$asignatura->id_asignatura?>" >
                    <span class="glyphicon glyphicon-remove"></span>
                </a>
            </td>
        </tr>
        <?php endforeach?>
    </tbody>
</table>