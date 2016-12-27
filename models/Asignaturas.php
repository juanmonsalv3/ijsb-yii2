<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "asignaturas".
 *
 * @property integer $id_asignatura
 * @property string $nombre
 * @property string $descripcion
 *
 * @property GruposAsignaturas[] $gruposAsignaturas
 * @property Grupos[] $idGrupos
 */
class Asignaturas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asignaturas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'string', 'max' => 40],
            [['descripcion'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_asignatura' => 'Id Asignatura',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGruposAsignaturas()
    {
        return $this->hasMany(GruposAsignaturas::className(), ['id_asignatura' => 'id_asignatura']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdGrupos()
    {
        return $this->hasMany(Grupos::className(), ['id_grupo' => 'id_grupo'])->viaTable('grupos_asignaturas', ['id_asignatura' => 'id_asignatura']);
    }
}
