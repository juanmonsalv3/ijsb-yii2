<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parametros".
 *
 * @property string $codigo_parametro
 * @property string $nombre
 * @property string $descripcion
 * @property string $valor
 */
class Parametros extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parametros';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo_parametro', 'nombre', 'descripcion', 'valor'], 'required'],
            [['codigo_parametro'], 'string', 'max' => 20],
            [['nombre'], 'string', 'max' => 100],
            [['descripcion'], 'string', 'max' => 500],
            [['valor'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'codigo_parametro' => 'Codigo Parametro',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'valor' => 'Valor',
        ];
    }
}
