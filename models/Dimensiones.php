<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dimensiones".
 *
 * @property integer $id_dimension
 * @property string $nombre
 * @property string $nombre_eng
 *
 * @property Indicadores[] $indicadores
 */
class Dimensiones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dimensiones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre','nombre_eng'], 'required'],
            [['nombre','nombre_eng'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_dimension' => 'Id Dimension',
            'nombre' => 'Nombre',
            'nombre_eng' => 'Nombre Inglés',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndicadores()
    {
        return $this->hasMany(Indicadores::className(), ['id_dimension' => 'id_dimension']);
    }
}
