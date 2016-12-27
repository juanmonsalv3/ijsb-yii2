<?php
use yii\widgets\DetailView;

if(is_null($fichaMedica)){
    echo '<div class="alert alert-info" role="alert">No se ha registrado aún la ficha Médica</div>';
    return;
}

echo DetailView::widget([
    'model' => $fichaMedica,
    'options' => ['class' => 'table table-striped detail-view fichamedica'],
    'formatter' => [
        'class' => 'yii\i18n\Formatter',
        'nullDisplay' => '',
    ],
    'attributes'=>[
        'urgencia_avisar_a',
        'telefono',
        'tipo_sangre',
        'nacimiento',
        [
            'attribute'=>'alergias',
            'value' => $fichaMedica->alergias == NULL ? 'Ninguna':$fichaMedica->alergias
        ],
        [
            'attribute'=>'asma',
            'value' => $fichaMedica->asma == 1 ? 'Sí':'No'
        ],
        [
            'attribute'=>'convulsiones',
            'value' => $fichaMedica->convulsiones == 1 ? 'Sí':'No'
        ],
        [
            'attribute'=>'diabetes',
            'value' => $fichaMedica->diabetes == 1 ? 'Sí':'No'
        ],
        [
            'attribute'=>'sangrado_nasal',
            'value' => $fichaMedica->sangrado_nasal == 1 ? 'Sí':'No'
        ],
        [
            'attribute'=>'dolor_cabeza',
            'value' => $fichaMedica->dolor_cabeza == 1 ? 'Sí':'No'
        ],
        [
            'attribute'=>'tratamiento_actual',
            'value' => $fichaMedica->tratamiento_actual == 1 ? 'Sí':'No'
        ],
        [
            'attribute'=>'puedetomar_dolex',
            'value' => $fichaMedica->puedetomar_dolex == 1 ? 'Sí':'No'
        ],
        [
            'attribute'=>'puedetomar_acetaminofen',
            'value' => $fichaMedica->puedetomar_acetaminofen == 1 ? 'Sí':'No'
        ],
        [
            'attribute'=>'puedetomar_buscapina',
            'value' => $fichaMedica->puedetomar_buscapina == 1 ? 'Sí':'No'
        ],
        [
            'attribute'=>'puedetomar_plasil',
            'value' => $fichaMedica->puedetomar_plasil == 1 ? 'Sí':'No'
        ],
        [
            'attribute'=>'puedetomar_dristan',
            'value' => $fichaMedica->puedetomar_dristan == 1 ? 'Sí':'No'
        ],
        'enfermedades',
        'otras_enfermedades',
        'medicamentos',
        'observaciones'
    ]
]) ?>