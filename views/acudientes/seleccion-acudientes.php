<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
?>

<?=GridView::widget([
    'dataProvider' => $acudientes,
    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '-'],
    'layout' => '{items}{pager}',
    'emptyText' => 'No se encontraron registros',
    'tableOptions' => [
        'class' => 'table table-condensed table-hover table-striped',
        ],
    'columns'=>[
        [
            'attribute'=>'nombreCompleto',
            'label'=>'Nombre'
        ]
    ]
])?>