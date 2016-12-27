<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cronograma_actividades".
 *
 * @property integer $id_actividad
 * @property string $fecha
 * @property string $descripcion
 */
class CronogramaActividades extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cronograma_actividades';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha', 'descripcion'], 'required'],
            [['fecha'], 'safe'],
            [['descripcion'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_actividad' => 'Id Actividad',
            'fecha' => 'Fecha',
            'descripcion' => 'Descripcion',
        ];
    }
    
    public function getActividadesGrupos()
    {
        return $this->hasMany(ActividadesGrupos::className(), ['id_actividad' => 'id_actividad']);
    }
    
    public function getGrupos()
    {
        return $this->hasMany(Grupos::className(), ['id_grupo' => 'id_grupo'])
            ->via('actividadesGrupos');
    }
}
