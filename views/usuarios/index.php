<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Perfiles;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => Url::toRoute('usuarios/')];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?=$this->title ?></h3>
    </div>
    <div class="panel-body">
        <div class="inscripciones-index">

            <?php $f = ActiveForm::begin([
                'method' => 'get',
                'enableClientValidation'=>false]); ?>

            <div class="col-md-4">
                <?= $f->field($model, 'perfil')
                        ->dropDownList(ArrayHelper::map(Perfiles::find()->all(), 'id_perfil', 'nombre')
                                ,['prompt'=>'Filtrar por perfil',
                                    'onchange'=>'this.form.submit()'])?>
            </div>
            <div class="col-md-8">
                <?= $f->field($model, 'busqueda')->textInput();?>
            </div>

            <div class="col-md-12 form-group">
                <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> Buscar', ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Nuevo Usuario', ['nuevo'], [
                    'class' => 'btn btn-success',
                ]) ?>

            <?php $f->end();?>
                <br/>
                <br/>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Perfil</th>
                        <th>Username</th>
                        <th>Nombres</th>
                        <th>Correo</th>
                        <th>Activo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($usuarios as $row): ?>
                    <tr>
                        <td><?=$row->perfil->nombre?></td>
                        <td><?=$row->login?></td>
                        <td><?=$row->apellidos.' '.$row->nombres?></td>
                        <td><?=$row->email?></td>
                        <td>
                            <?php 
                            if ($row->activo){
                                echo $row->isActivo;
                            }
                            else
                            {
                                echo '<a title="Enviar correo de activación" href="'.Url::toRoute(['usuarios/activateemail','id'=>$row->id_usuario]).'">'.$row->isActivo.'</a';
                            }
                                    
                            ?>
                        </td>
                        <td>
                            <a href="<?=Url::toRoute(['usuarios/view','login'=>$row->login])?>"title="Ver" aria-label="Ver" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a> 
                            
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
                <?= LinkPager::widget([
                    "pagination" => $pages,
                ]);?>
            </div>
        </div>
    </div>
</div>