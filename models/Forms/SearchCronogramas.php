<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;

class SearchCronogramas extends Model{

    public $id_grupo;
    
    public function attributeLabels()
    {
        return [
            'id_grupo' => 'Grupo',
        ];
    }
    
    public function rules()
    {
        return [
        [['id_grupo'], 'integer'],
        ];
    }

}

