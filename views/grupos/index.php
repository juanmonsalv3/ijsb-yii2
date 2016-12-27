<?php
use yii\helpers\Url;

$this->title = 'Grupos';
$this->params['breadcrumbs'][] = ['label' => 'Grupos', 'url' => Url::toRoute('grupos/')];
?>
<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?=$this->title ?></h3>
    </div>
    <div class="panel-body">

        <div class="site-index">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Ver</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($grupos as $grupo):?>
                    <tr>
                        <td><?=$grupo->nombre?></td>
                        <td><?=$grupo->descripcion?></td>
                        <td><a href="<?=  Url::toRoute(["grupos/grupo","id_grupo"=>$grupo['id_grupo']])?>"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>

        </div>
    </div>
</div>