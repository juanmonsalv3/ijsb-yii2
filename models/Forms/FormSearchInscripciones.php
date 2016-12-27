<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;

class FormSearchInscripciones extends Model{

    public $id_grupo;
    public $mes;
    public $estado;
    public $busqueda;
    
    public function attributeLabels()
    {
        return [
            'id_grupo' => 'Grupo',
            'mes' => 'Antigüedad inscripción',
            'estado' => 'Estado',
            'busqueda' => 'Palabras de Búsqueda',
        ];
    }
    
    public function rules()
    {
        return [
        [['busqueda','estado'], 'string'],
        [['id_grupo','mes'], 'integer'],
        ];
    }

}

