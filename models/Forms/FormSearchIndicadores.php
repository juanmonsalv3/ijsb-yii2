<?php
namespace app\models\forms;

use Yii;
use yii\base\Model;

class FormSearchIndicadores extends Model{

    public $id_grupo;
    public $periodo;
    public $id_dimension;
    public $descripcion;
    
    public function attributeLabels()
    {
        return [
            'id_indicador' => 'Id Indicador',
            'id_grupo' => 'Grupo',
            'id_dimension' => 'Dimensión',
            'periodo' => 'Período',
            'descripcion' => 'Búsqueda',
        ];
    }
    
    public function rules()
    {
        return [
        [['id_grupo','id_dimension','periodo','descripcion'], 'string'],
        ];
    }

}