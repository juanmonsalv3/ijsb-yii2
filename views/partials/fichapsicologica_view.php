<?php
use yii\widgets\DetailView;

if(is_null($fichaPsicologica)){
    echo '<div class="alert alert-info" role="alert">No se ha registrado aún la ficha Psicológica</div>';
    return;
}

echo DetailView::widget([
    'model' => $fichaPsicologica,
    'options' => ['class' => 'table table-striped detail-view fichapsicologica'],
    'formatter' => [
        'class' => 'yii\i18n\Formatter',
        'nullDisplay' => '',
    ],
    'attributes'=>[
        'cuantoshermanos',
        'posicionhermanos',
        'detalle_embarazo',
        'detalle_nacimiento',
        'complicaciones_natales',
        'edad_gateo',
        'edad_camino',
        'caracter',
        'reaccion_malgenio',
        'reaccion_alegre',
        'persona_vinculoafectivo',
        'persona_atiendesupervisa',
        'edad_habla',
        'expresacorrientemente',
        'habla_gritos',
        'edad_controlesfinter',
        [
            'attribute'=>'lavadientes',
            'value' => $fichaPsicologica->lavadientes == 1 ? 'Sí':'No'
        ],
        [
            'attribute'=>'lavamanos',
            'value' => $fichaPsicologica->lavamanos == 1 ? 'Sí':'No'
        ],
        [
            'attribute'=>'viste',
            'value' => $fichaPsicologica->viste == 1 ? 'Sí':'No'
        ],
        [
            'attribute'=>'cordoneszapatos',
            'value' => $fichaPsicologica->cordoneszapatos == 1 ? 'Sí':'No'
        ],
        'horadormir',
        'horasdormido',
        'pesadillas',
        'habitodormir',
        [
            'attribute'=>'mojadenoche',
            'value' => $fichaPsicologica->mojadenoche == 1 ? 'Sí':'No'
        ],
        [
            'attribute'=>'chupadedo',
            'value' => $fichaPsicologica->chupadedo == 1 ? 'Sí':'No'
        ],
        'despierta',
        'comidasenfamilia',
        'apetito',
        'gustahacer',
        'conquienjuega',
        'actitudjuego',
        'amigoimaginario',
        'cuentos',
        'musica',
        'cine',
        'television',
        'programas',
        'conductas',
        'traumas'
    ]
]);