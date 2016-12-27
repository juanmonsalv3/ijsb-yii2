<?php

namespace app\models\Forms;
use Yii;
use yii\base\Model;
use app\models\Usuarios;

class FormRegistroUsuarios extends Model{
 
    public $perfil;
    public $login;
    public $password;
    public $password_repeat;
    public $nombres;
    public $apellidos;
    public $email;
    
    
    public function rules()
    {
        return [
            [['login', 'email', 'password', 'password_repeat','nombres','apellidos' ], 'required', 'message' => 'Campo requerido'],
            ['login', 'match', 'pattern' => "/^.{3,50}$/", 'message' => 'Mínimo 3 y máximo 50 caracteres'],
            ['login', 'match', 'pattern' => "/^[0-9a-z]+$/i", 'message' => 'Sólo se aceptan letras y números'],
            ['login', 'username_existe'],
            ['perfil', 'integer'],
            ['email', 'match', 'pattern' => "/^.{5,80}$/", 'message' => 'Mínimo 5 y máximo 80 caracteres'],
            ['email', 'email', 'message' => 'Formato no válido'],
            ['email', 'email_existe'],
            ['password', 'match', 'pattern' => "/^.{6,16}$/", 'message' => 'Mínimo 6 y máximo 16 caracteres'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Los passwords no coinciden'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'perfil' => 'Perfil',
            'login' => 'Usuario',
            'password' => 'Contraseña',
            'password_repeat' => 'Repetir Contraseña',
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'email' => 'Correo',
        ];
    }
    
    public function email_existe($attribute, $params)
    {
  
        //Buscar el email en la tabla
        $table = Usuarios::find()->where("email=:email", [":email" => $this->email]);
  
        //Si el email existe mostrar el error
        if ($table->count() == 1)
        {
            $this->addError($attribute, "El email seleccionado ya existe");
        }
    }
 
    public function username_existe($attribute, $params)
    {
        //Buscar el username en la tabla
        $table = Usuarios::find()->where("login=:login", [":login" => $this->login]);

        //Si el username existe mostrar el error
        if ($table->count() == 1)
        {
            $this->addError($attribute, "El usuario seleccionado existe");
        }
    }
 
}