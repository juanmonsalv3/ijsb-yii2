<?php

use yii\helpers\Url;

$this->title = 'Historial Estudiante';
$this->params['breadcrumbs'][] = ['label' => 'Estudiantes', 'url' => Url::toRoute('estudiantes/')];
$this->params['breadcrumbs'][] = ['label' => 'Historial'];

?>
<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?=$estudiante->nombreCompleto ?></h3>
    </div>
    <div class="panel-body">

        <div class="site-historial">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Año</th>
                        <th>Grupo</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($estudiante->gruposEstudiantes as $grupoest):?>
                    <tr>
                        <td><?=$grupoest->anio?></td>
                        <td><?=$grupoest->grupo->nombre?></td>
                        <td><?=$grupoest->textoEstado?></td>
                        <td><a href="<?=Url::toRoute(['estudiantes/anio','id'=>$estudiante->id_estudiante,'anio'=>$grupoest->anio])?>"><span class="glyphicon glyphicon-th-list" title="Revisar logros del año"></span></a></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
           
        </div>
    </div>
</div>