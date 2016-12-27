<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grupos_asignaturas".
 *
 * @property integer $id_asignatura
 * @property integer $id_grupo
 * @property integer $activo
 *
 * @property Asignaturas $idAsignatura
 * @property Grupos $idGrupo
 */
class GruposAsignaturas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'grupos_asignaturas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_asignatura', 'id_grupo'], 'required'],
            [['id_asignatura', 'id_grupo', 'activo'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_asignatura' => 'Id Asignatura',
            'id_grupo' => 'Id Grupo',
            'activo' => 'Activo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAsignatura()
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
