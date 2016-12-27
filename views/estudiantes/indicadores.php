<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Dimensiones;
use app\models\Periodos;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;


$this->title = 'Logros Estudiante';
$this->params['breadcrumbs'][] = ['label' => 'Estudiantes', 'url' => Url::toRoute('estudiantes/')];
$this->params['breadcrumbs'][] = ['label' => 'Logros'];

$dataProvider1 = new ActiveDataProvider([
    'query' => $indicadoresxasignar,
    'pagination' => [
        'pageSize' => 5,
    ],
]);
$dataProvider1->pagination->pageParam = 'xasignar';
$dataProvider1->sort->sortParam = 'xasignar';

$dataProvider2 = new ActiveDataProvider([
    'query' => $indicadoresasignados,
    'pagination' => [
        'pageSize' => 5,
    ],
]);
$dataProvider2->pagination->pageParam = 'asignados';
$dataProvider2->sort->sortParam = 'asignados';

$estudiantegrupoid = $estudiantegrupo->id_grupo_estudiante
?>

<style>
    .pagination{
        margin: 0;
    }
    .summary{
        display: inline;
        float: right;
    }
    select.gridview-select.form-control {
        margin: -5px;
    }
    table.table{
        margin-bottom: 50px;
    }
</style>
<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?=$this->title?></h3>
    </div>
    <div class="panel-body">
        <ul class="table-list">
            <li>
                <?=$estudiantegrupo->estudiante->nombreCompleto?>
            </li>
            <li>
                <b>Grupo:</b> <?=$estudiantegrupo->grupo->nombre?>
            </li>
        </ul>
        
        <?php $form = ActiveForm::begin([
                'method' => 'get',
            ]); ?>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($formsearch, 'periodo')->dropDownList(ArrayHelper::map(Periodos::find()->orderBy('id_periodo')->all(), 'id_periodo', 'descripcion'))?>
            </div>
            <div class="col-md-4">
                <?= $form->field($formsearch, 'id_dimension')->dropDownList(ArrayHelper::map(Dimensiones::find()->all(), 'id_dimension', 'nombre'))?>
            </div>
            <div class="col-md-4" style="padding-top: 25px;">
                <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <?php $form->end() ?>
        <h4>Indicadores por Asignar</h4>
        <?=GridView::widget([
            'dataProvider' => $dataProvider1,
            'layout' => '{items}{pager}{summary}',
            'summary' => '<div class="summary">Mostrando:{begin} - {end} Total: {count}</div>',
            'emptyText' => 'No se encontraron registros',
            'columns'=>[
                [
                    'attribute'=>'id_indicador',
                    'label' => 'ID',
                    'visible'=>false
                ],
                'descripcion',
                'periodo',
                [
                    'attribute'=>'dimension.nombre',
                    'label' => 'Dimensión',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{cumple} {nocumple}',
                    'buttons' => [
                        'cumple' => function ($url,$model) {
                            $url = Url::toRoute('estudiantes/asignar-indicador',true);
                            return Html::a('<span class="glyphicon glyphicon-ok"/>', '#', ['title' => 'Cumple con el indicador','data-url'=>$url,'class'=>'cumplebtn']); 
                            
                        },
                        'nocumple' => function ($url,$model) {
                            $url = Url::toRoute('estudiantes/asignar-indicador',true);
                            return ' '.Html::a('<span class="glyphicon glyphicon-remove"/>', '#', ['title' => 'No Cumple con el indicador','data-url'=>$url,'class'=>'nocumplebtn']); 
                        },
                    ],
                ]
            ]
        ])?>
        
        <h4>Indicadores Asignados</h4>
        <?=GridView::widget([
            'dataProvider' => $dataProvider2,
            'layout' => '{items}{pager}{summary}',
            'summary' => '<div class="summary">Mostrando:{begin} - {end} Total: {count}</div>',
            'emptyText' => 'No se encontraron registros',
            'columns'=>[
                [
                    'attribute'=>'id_indicador',
                    'label' => 'ID',
                    'visible'=>false
                ],
                'indicador.descripcion',
                'indicador.periodo',
                [
                    'attribute'=>'indicador.dimension.nombre',
                    'label' => 'Dimensión'
                ],
                [
                    'label'=>'Cumple',
                    'format'=>'raw',
                    'value' => function($data){
                        return Html::dropDownList('dropdown',$data->cumple,[1=>"Sí Cumple",0=>'No cumple'],['class'=>'gridview-select form-control cumple-nocumple']);
                    },
                    'options'=>['class'=>'dropdowntr']
                ],
            ]
        ])?>
    </div>
</div>
<script type="text/javascript">
    var id_estudiante_grupo = <?=$estudiantegrupo->id_grupo_estudiante ?>;
    $(function(){
        $('.cumplebtn').on('click',function(e){
            e.preventDefault();
            var indicador = $(this).parent().parent().attr('data-key');
            asignarIndicador(indicador,1);
        });
        $('.nocumplebtn').on('click',function(e){
            e.preventDefault();
            var indicador = $(this).parent().parent().attr('data-key');
            asignarIndicador(indicador,0);
        });
        $('.cumple-nocumple').on('change',function(e){
            e.preventDefault();
            var indicadorestudiante = $(this).parent().parent().attr('data-key');
            modificarIndicador(indicadorestudiante,parseInt($(this).val()));
        });
        
        
    });
    function asignarIndicador(indicador, cumple){
        $.ajax({
                method: 'get',
                url: '<?= Url::toRoute(['estudiantes/asignar-indicador']); ?>',
                data: { id_estudiante_grupo: id_estudiante_grupo, id_indicador : indicador, cumple:cumple} ,
                success: function(data) {
                    var response = JSON.parse(data);
                    setTimeout(function(){
                        location.reload();
                    },100);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#notify-wrap').notify({ text: 'Ocurrió un error procesando la solicitud', state: 'ui-state-error', timeout: 3000 });
                }
            });
    }
    function modificarIndicador(indicadorestudiante, cumple){
        $.ajax({
                method: 'get',
                url: '<?= Url::toRoute(['estudiantes/modificar-indicador']); ?>',
                data: { id_indicador_estudiante: indicadorestudiante, cumple:cumple} ,
                success: function(data) {
                    var response = JSON.parse(data);
                    setTimeout(function(){
                        location.reload();
                    },100);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#notify-wrap').notify({ text: 'Ocurrió un error procesando la solicitud', state: 'ui-state-error', timeout: 3000 });
                }
            });
    }
</script>