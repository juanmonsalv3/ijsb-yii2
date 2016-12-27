<?php

namespace app\models\Forms;
use yii\base\Model;

class FormResetPass extends Model{
 
    public $password;
    public $password_repeat;
    public $id;
    public $authKey;
    
    
    public function rules()
    {
        return [
            [['password', 'password_repeat'], 'required', 'message' => 'Campo requerido'],
            ['password', 'match', 'pattern' => "/^.{6,16}$/", 'message' => 'Mínimo 6 y máximo 16 caracteres'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Los passwords no coinciden'],
            ['id', 'integer'],
            ['authKey','string']
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'password' => 'Nueva Contraseña',
            'password_repeat' => 'Repetir Contraseña',
        ];
    }
 
}