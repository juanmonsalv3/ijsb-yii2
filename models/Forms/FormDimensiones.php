<?php

namespace app\models\Forms;
use Yii;
use yii\base\Model;

class FormDimensiones extends Model{

public $id_dimension;
public $nombre;
public $nombre_eng;

public function rules()
 {
    return [
        ['nombre', 'required', 'message' => 'Campo requerido'],
        ['nombre', 'match', 'pattern' => '/^[a-záéíóúñ\s]+$/i', 'message' => 'Sólo se aceptan letras'],
        ['nombre', 'match', 'pattern' => '/^.{3,50}$/', 'message' => 'Mínimo 3 máximo 50 caracteres'],
        ['nombre_eng', 'required', 'message' => 'Campo requerido'],
        ['nombre_eng', 'match', 'pattern' => '/^[a-záéíóúñ\s]+$/i', 'message' => 'Sólo se aceptan letras'],
        ['nombre_eng', 'match', 'pattern' => '/^.{3,50}$/', 'message' => 'Mínimo 3 máximo 50 caracteres'],
       ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nombre' => 'Nombre',
            'nombre_eng' => 'Nombre Inglés',
        ];
    }
 
}