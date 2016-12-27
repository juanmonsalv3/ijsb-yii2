<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Dimensiones */
/* @var $form ActiveForm */

$this->title = 'Dimensiones';
$this->params['breadcrumbs'][] = ['label' => 'Indicadores', 'url' => Url::toRoute('indicadores/')];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?=$this->title ?></h3>
    </div>
    <div class="panel-body">
        <div class="indicadores-dimensiones">
            <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>English Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dimensiones as $dimension):?>
                        <tr>
                            <td><?=$dimension->nombre?></td>
                            <td><?=$dimension->nombre_eng?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
        </div>
    </div>
</div>

    <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Nueva Dimensión</h3>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'nombre') ?>
            <?= $form->field($model, 'nombre_eng') ?>

              <div class="form-group">
                  <?= Html::submitButton('Agregar', ['class' => 'btn btn-primary']) ?>
              </div>
            <?php ActiveForm::end(); ?>

        </div><!-- indicadores-dimensiones -->
    </div>
</div>
