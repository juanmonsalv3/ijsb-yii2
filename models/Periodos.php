<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "periodos".
 *
 * @property integer $id_periodo
 * @property string $descripcion
 */
class Periodos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'periodos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_periodo', 'descripcion'], 'required'],
            [['id_periodo'], 'integer'],
            [['descripcion'], 'string', 'max' => 45],
            [['id_periodo'], 'unique'],
            [['descripcion'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_periodo' => 'Id Periodo',
            'descripcion' => 'Descripcion',
        ];
    }
}
