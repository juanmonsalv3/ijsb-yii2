<?php

namespace app\models;
use Yii;
use yii\base\model;

class ValidarFormulario extends model
{
    public $nombre;
    public $email;
    
    public function rules()
    {
        return [
            ["nombre","required","message"=>"Campo Requerido"],
            ["nombre","match","pattern" => "/^.{3,50}$/","message"=>"Minimo 3 caracteres y máximo 50"],
            ["nombre","match","pattern" => "/^[0-9a-z]+$/i", "message"=>"Solo se aceptan letras y números"],
            ["email","required","message" => "Campo Requerido"],
            ["email","match","pattern" => "/^.{5,80}$/","message"=>"Minimo 5 caracteres y máximo 80"],
            ["email","email","message" => "Formato no válido"],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            "nombre" => "Nombre:",
            "email" => "email:",
        ];
    }
}
