<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "horarios".
 *
 * @property integer $id_horario
 * @property integer $dia_semana
 * @property integer $hora_dia
 * @property integer $id_grupo
 * @property string $actividad
 * @property integer $id_asignatura
 *
 * @property Asignaturas $idAsignatura
 * @property Grupos $idGrupo
 */
class Horarios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'horarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dia_semana', 'hora_dia', 'id_grupo'], 'required'],
            [['dia_semana', 'hora_dia', 'id_grupo', 'id_asignatura'], 'integer'],
            [['actividad'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_horario' => 'Id Horario',
            'dia_semana' => 'Dia Semana',
            'hora_dia' => 'Hora Dia',
            'id_grupo' => 'Id Grupo',
            'actividad' => 'Actividad',
            'id_asignatura' => 'Id Asignatura',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignatura()
    {
        return $this->hasOne(Asignaturas::className(), ['id_asignatura' => 'id_asignatura']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdGrupo()
    {
        return $this->hasOne(Grupos::className(), ['id_grupo' => 'id_grupo']);
    }
}
