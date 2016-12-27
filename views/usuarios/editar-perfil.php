<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Editar Perfil';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?=$this->title ?></h3>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin([
            'method' => 'post',
           ]);
        ?>
        <div class="col-xs-12">
            <div class="form-group">
                <?= $form->field($model, "nombres")->input("text") ?>   
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group">
                <?= $form->field($model, "apellidos")->input("text") ?>   
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group">
                <?= $form->field($model, "email")->input("text") ?>   
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <?= $form->field($model, "telefono")->input("text") ?>   
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <?= $form->field($model, "celular")->input("text") ?>   
            </div>
        </div>
        <div class="col-xs-12 ">
            <div class="form-group">
                <?= $form->field($model, "ocupacion")->input("text") ?>   
            </div>
        </div>
        
        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <?= $form->field($model, "ciudad_nacimiento")->input("text") ?>   
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <?= $form->field($model, 'fecha_nacimiento')->widget(\yii\jui\DatePicker::classname(), [
                            'language' => 'es',
                            'dateFormat' => 'yyyy-MM-dd',
                            'options' => ['class' => 'form-control']
                        ]) ?>
            </div>
        </div>
        <div class="col-xs-12">
            <?= Html::submitButton("<span class='glyphicon glyphicon-floppy-disk'></span> Guardar", ["class" => "btn btn-primary"]) ?>
        </div>
        <?php $form->end() ?>
    </div>
</div>