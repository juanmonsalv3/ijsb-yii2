<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Grupos;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Matrícula';
$this->params['breadcrumbs'][] = ['label' => 'Matrícula', 'url' => Url::toRoute('matricula/')];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?=$this->title ?></h3>
    </div>
    <div class="panel-body">
        <div class="inscripciones-index">

            <?php $f = ActiveForm::begin(['method' => 'get',]); ?>
            <div class="col-md-8">
                <?= $f->field($form, 'nombre')->textInput(['placeholder'=>'Términos de búsqueda'])->label('Búsqueda')?>
            </div>

            <div class="col-md-4 form-group">
                <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> Buscar', ['class' => 'btn btn-primary sinlabel']) ?>
            </div>
            <?php $f->end();?>


            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Grupo a Matricular</th>
                        <th>Nombres</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($model as $row): ?>
                    <tr>
                        <td>
                            <?php 
                            $idgrupo = 1;
                            if($row->grupos ==null && $row->inscripcion !=null){
                                $idgrupo = $row->inscripcion->id_grupo;
                                echo $grupos[$idgrupo];
                            }
                            else{
                                
                                $aniomatricula = (int)(Yii::$app->cache->get('parametros')['aniomatricula']['valor'])-1;
                                foreach ($row->gruposEstudiantes as $grupo) {
                                    if($grupo->anio==$aniomatricula)
                                    {
                                        $idgrupo = $grupo->id_grupo;
                                        if($grupo->estado=='P')
                                        {
                                            $idgrupo = $grupo->id_grupo+1;    
                                        }
                                    }
                                }
                                echo $grupos[$idgrupo];
                            }
                            ?>
                        </td>
                        <td><?=$row->nombreCompleto?></td>
                        <td align="center"><a href="<?=Url::toRoute(['matricula/matricular','id'=>$row->id_estudiante,'id_grupo'=>$idgrupo])?>"><span class="glyphicon glyphicon-ok"></span></a></td>
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