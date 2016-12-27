<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "actividades_grupos".
 *
 * @property integer $id_actividad
 * @property integer $id_grupo
 *
 * @property Grupos $idGrupo
 */
class ActividadesGrupos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'actividades_grupos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_actividad', 'id_grupo'], 'required'],
            [['id_actividad', 'id_grupo'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_actividad' => 'Id Actividad',
            'id_grupo' => 'Id Grupo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdGrupo()
    {
        return $this->hasOne(Grupos::className(), ['id_grupo' => 'id_grupo']);
    }
}
