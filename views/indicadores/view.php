<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Indicadores */

$this->title = $model->id_indicador;
$this->params['breadcrumbs'][] = ['label' => 'Indicadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="indicadores-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_indicador], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_indicador], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_indicador',
            'id_grupo',
            'id_dimension',
            'periodo',
            'descripcion',
        ],
    ]) ?>

</div>
