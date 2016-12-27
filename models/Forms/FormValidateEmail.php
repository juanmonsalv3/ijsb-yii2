<?php

namespace app\models\Forms;

use yii\base\Model;
use app\models\Usuarios;

/**
 * Description of FormForgotPass
 *
 * @author usuario
 */
class FormValidateEmail extends Model{
    
    public $email;

    public function rules()
    {
        return [
            // username and password are both required
            ['email', 'required' , 'message'=>'El email no puede estar en blanco'],
            ['email', 'email_existe'],
        ];
    }
    
    public function email_existe($attribute, $params)
    {
        //Buscar el email en la tabla
        $table = Usuarios::find()->where("email=:email", [":email" => $this->email])->andWhere('activo = 1');
  
        //Si el email existe mostrar el error
        if ($table->count() == 0)
        {
            $this->addError($attribute, "El email seleccionado no existe");
        }
    }
}
