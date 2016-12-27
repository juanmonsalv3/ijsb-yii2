<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inscripciones".
 *
 * @property integer $id_solicitud
 * @property integer $estado_solicitud
 * @property string $fecha_registro
 * @property integer $id_grupo
 * @property string $nombres
 * @property string $apellidos
 * @property string $ciudad_nacimiento
 * @property string $fecha_nacimiento
 * @property string $vive_con
 * @property string $direccion
 * @property string $telefono
 * @property string $nacimiento
 * @property string $enfermedades
 * @property string $alergias
 * @property string $medicamentos
 * @property string $parentesco_acudiente
 * @property string $nombres_acud
 * @property string $apellidos_acud
 * @property string $ciudad_nacimiento_acudiente
 * @property string $fecha_nacimiento_acudiente
 * @property string $ocupacion_acudiente
 * @property string $email_acudiente
 *
 * @property Grupos $idGrupo
 */
class Inscripciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inscripciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['estado_solicitud', 'id_grupo'], 'integer'],
            [['fecha_registro', 'id_grupo', 'nombres', 'apellidos', 'ciudad_nacimiento', 'fecha_nacimiento', 'vive_con', 'nacimiento', 'parentesco_acudiente', 'nombres_acud', 'ciudad_nacimiento_acudiente', 'fecha_nacimiento_acudiente', 'email_acudiente'], 'required', 'message'=>'Este campo no puede estar vacío'],
            [['fecha_registro', 'fecha_nacimiento', 'fecha_nacimiento_acudiente'], 'safe'],
            [['nombres', 'apellidos', 'vive_con', 'nombres_acud', 'apellidos_acud', 'ocupacion_acudiente', 'email_acudiente'], 'string', 'max' => 100],
            [['ciudad_nacimiento', 'ciudad_nacimiento_acudiente'], 'string', 'max' => 50],
            [['direccion'], 'string', 'max' => 200],
            [['telefono'], 'string', 'max' => 20],
            [['nacimiento'], 'string', 'max' => 10],
            [['enfermedades', 'alergias', 'medicamentos', 'parentesco_acudiente'], 'string', 'max' => 500],
            [['sexo'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_solicitud' => 'Id',
            'estado_solicitud' => 'Estado de la Solicitud',
            'fecha_registro' => 'Fecha de Registro',
            'id_grupo' => 'Grupo',
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'sexo' => 'Sexo',
            'ciudad_nacimiento' => 'Ciudad de Nacimiento',
            'fecha_nacimiento' => 'Fecha de Nacimiento',
            'vive_con' => 'Actualmente Vive Con',
            'direccion' => 'Dirección',
            'telefono' => 'Telefono',
            'nacimiento' => 'Nacimiento',
            'enfermedades' => 'Enfermedades',
            'alergias' => 'Alergias conocidas',
            'medicamentos' => 'Medicamentos',
            'parentesco_acudiente' => 'Parentesco del Acudiente',
            'nombres_acud' => 'Nombres del Acudiente',
            'apellidos_acud' => 'Apellidos del Acudiente',
            'ciudad_nacimiento_acudiente' => 'Ciudad de Nacimiento del Acudiente',
            'fecha_nacimiento_acudiente' => 'Fecha de Nacimiento del Acudiente',
            'ocupacion_acudiente' => 'Ocupacion del Acudiente',
            'email_acudiente' => 'Email del Acudiente',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrupo()
    {
        return $this->hasOne(Grupos::className(), ['id_grupo' => 'id_grupo']);
    }
    
    public function getNombreCompleto()
    {
        return $this->nombres.' '.$this->apellidos;
    }
    
    public function getEstado()
    {
        if($this->estado_solicitud ===0)
        {
            return "Rechazada";
        }
        else if($this->estado_solicitud ===1)
        {
            return "Aprobada";
        }
        else 
        {
            return "Por Revisar";
        }
        
    }
    
    public function getSex()
    {
        if($this->sexo ==='F')
        {
            return "Femenino";
        }
        else 
        {
            return "Masculino";
        }
        
    }
}
