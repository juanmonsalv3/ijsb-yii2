<?php

namespace app\models\Forms;

use Yii;
use yii\base\Model;

class FormSearchUsuarios extends Model
{
    
    public $perfil;
    public $busqueda;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['perfil'], 'integer'],
            [['busqueda'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'perfil' => 'Perfil',
            'busqueda' => 'Busqueda',
        ];
    }
}

