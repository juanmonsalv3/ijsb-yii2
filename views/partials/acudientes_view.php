<?php if(is_null($acudientes) || count($acudientes)===0):?>
<div class="alert alert-info" role="alert">El estudiante no tiene acudientes registrados</div>
<?php return; ?>
<?php endif; ?>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Celular</th>
            <th>Correo</th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($acudientes as $acudiente): ?>
    <tr>
        <td><?=$acudiente->nombreCompleto ?></td>
        <td><?=$acudiente->telefono ?></td>
        <td><?=$acudiente->celular ?></td>
        <td><?=$acudiente->email ?></td>
    </tr>
<?php endforeach; ?>
    </tbody>
</table>
