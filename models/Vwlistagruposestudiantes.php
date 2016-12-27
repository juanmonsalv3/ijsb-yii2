<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vwlistagruposestudiantes".
 *
 * @property integer $id_estudiante
 * @property string $nombres
 * @property string $apellidos
 * @property string $fecha_nacimiento
 * @property string $ciudad_nacimiento
 * @property integer $activo
 * @property integer $id_inscripcion
 * @property string $sexo
 * @property string $anio
 * @property integer $id_grupo
 * @property string $estado
 */
class Vwlistagruposestudiantes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vwlistagruposestudiantes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_estudiante', 'activo', 'id_inscripcion', 'id_grupo'], 'integer'],
            [['nombres', 'apellidos'], 'required'],
            [['fecha_nacimiento'], 'safe'],
            [['nombres', 'apellidos'], 'string', 'max' => 200],
            [['ciudad_nacimiento'], 'string', 'max' => 50],
            [['sexo', 'estado'], 'string', 'max' => 1],
            [['anio'], 'string', 'max' => 4]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_estudiante' => 'Id Estudiante',
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'ciudad_nacimiento' => 'Ciudad Nacimiento',
            'activo' => 'Activo',
            'id_inscripcion' => 'Id Inscripcion',
            'sexo' => 'Sexo',
            'anio' => 'Año',
            'id_grupo' => 'Grupo',
            'estado' => 'Estado',
        ];
    }
    
    public function getNombreCompleto() {
        return $this->apellidos.' '.$this->nombres;
    }
    
    public function getGrupo()
    {
        return $this->hasOne(Grupos::className(), ['id_grupo' => 'id_grupo']);
    }
}
