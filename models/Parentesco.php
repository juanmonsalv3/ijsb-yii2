<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parentesco".
 *
 * @property integer $id_parentesco
 * @property string $nombre
 */
class Parentesco extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parentesco';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 45],
            [['nombre'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_parentesco' => 'Id Parentesco',
            'nombre' => 'Parentesco',
        ];
    }
}
