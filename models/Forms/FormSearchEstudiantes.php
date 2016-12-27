<?php

namespace app\models\Forms;

use Yii;
use yii\base\model;

class FormSearchEstudiantes extends model{
    
    public $grupo;
    public $nombre;
    
    public function attributeLabels()
    {
        return [
            'grupo' => 'Grupo',
            'nombre' => 'Nombres',
        ];
    }
    
    public function rules()
    {
        return [
        [['nombre'], 'string'],
        [['grupo'], 'integer'],
        ];
    }
}
