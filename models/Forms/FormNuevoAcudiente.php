<?php

namespace app\models\Forms;
use Yii;
use yii\base\Model;

class FormNuevoAcudiente extends Model{

    public $id_estudiante;
    public $parentesco;
    public $nombres;
    public $apellidos;
    public $telefono;
    public $email;

    public function rules()
     {
        return [
                [['id_estudiante','parentesco'],'integer'],
                [['parentesco','nombres', 'apellidos', 'email'], 'required','message'=>'Este campo no puede estar vacío'],
                [['login', 'ciudad_nacimiento'], 'string', 'max' => 50],
                [['telefono', 'celular'], 'string', 'max' => 20],
                ['email', 'match', 'pattern' => "/^.{5,80}$/", 'message' => 'Mínimo 5 y máximo 80 caracteres'],
                ['email', 'email', 'message' => 'Formato no válido'],
                ['email', 'email_existe'],
            ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parentesco' => 'Parentesco',
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'email' => 'Correo',
            'telefono' => 'Telefono',
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
}