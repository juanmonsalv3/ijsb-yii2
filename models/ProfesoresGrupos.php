<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profesores_grupos".
 *
 * @property integer $id_usuario
 * @property integer $id_grupo
 * @property string $anio
 *
 * @property Grupos $idGrupo
 * @property Usuarios $idUsuario
 */
class ProfesoresGrupos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profesores_grupos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_grupo', 'anio'], 'required'],
            [['id_usuario', 'id_grupo'], 'integer'],
            [['anio'], 'string', 'max' => 4]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_usuario' => 'Id Usuario',
            'id_grupo' => 'Id Grupo',
            'anio' => 'Anio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrupo()
    {
        return $this->hasOne(Grupos::className(), ['id_grupo' => 'id_grupo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id_usuario' => 'id_usuario']);
    }
}
