
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Parentesco</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($acudientes as $relationAcudiente): ?>
    <tr data-estudiante="<?=$relationAcudiente->id_estudiante?>" data-usuario="<?=$relationAcudiente->id_acudiente?>">
        <td><?=$relationAcudiente->parentescoEntitie == null ? $relationAcudiente->parentesco : $relationAcudiente->parentescoEntitie->nombre?></td>
        <td><?=$relationAcudiente->acudiente->nombreCompleto ?></td>
        <td><?=$relationAcudiente->acudiente->email ?></td>
        <td>
            <a href="#" class="remove-acudiente">
                <span class="glyphicon glyphicon-remove"></span>
            </a>
        </td>
    </tr>
<?php endforeach; ?>
    </tbody>
</table>
