<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estudiantes_matricula".
 *
 * @property integer $id_estudiante
 * @property string $nombres
 * @property string $apellidos
 * @property string $fecha_nacimiento
 * @property string $ciudad_nacimiento
 * @property integer $activo
 * @property integer $id_inscripcion
 * @property string $sexo
 * @property string $estado
 * @property string $proximo_grupo
 */
class EstudiantesMatricula extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estudiantes_matricula';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_estudiante', 'activo', 'id_inscripcion', 'proximo_grupo'], 'integer'],
            [['nombres', 'apellidos','ciudad_nacimiento','fecha_nacimiento'], 'required','message'=>'Este campo es requerido'],
            [['fecha_nacimiento'], 'safe'],
            [['nombres', 'apellidos','ciudad_nacimiento'], 'string', 'max' => 200],
            [['sexo', 'estado'], 'string', 'max' => 1]
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
            'activo' => 'Activo',
            'id_inscripcion' => 'Id Inscripcion',
            'sexo' => 'Sexo',
            'estado' => 'Estado',
            'proximo_grupo' => 'Grupo a Matricular',
        ];
    }
    
    public function getGrupo()
    {
        return $this->hasOne(Grupos::className(), ['id_grupo' => 'proximo_grupo']);
    }
}
