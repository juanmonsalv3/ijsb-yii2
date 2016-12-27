<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "indicadores".
 *
 * @property integer $id_indicador
 * @property integer $id_grupo
 * @property integer $id_dimension
 * @property integer $periodo
 * @property string $descripcion
 * @property string $descripcion_cumple_masc
 * @property string $descripcion_cumple_fem
 * @property string $descripcion_nocumple_masc
 * @property string $descripcion_nocumple_fem
 *
 * @property Dimensiones $idDimension
 * @property Grupos $idGrupo
 * @property IndicadoresEstudiantes[] $indicadoresEstudiantes
 */
class Indicadores extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'indicadores';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_grupo', 'id_dimension', 'periodo', 'descripcion', 'descripcion_cumple_masc', 'descripcion_cumple_fem', 'descripcion_nocumple_masc', 'descripcion_nocumple_fem'], 'required', 'message' =>'Este campo es obligatorio'],
            [['id_indicador','id_grupo', 'id_dimension', 'periodo'], 'integer'],
            [['descripcion', 'descripcion_cumple_masc', 'descripcion_cumple_fem', 'descripcion_nocumple_masc', 'descripcion_nocumple_fem'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_indicador' => 'Id Indicador',
            'id_grupo' => 'Grupo',
            'id_dimension' => 'Dimensión',
            'periodo' => 'Período',
            'descripcion' => 'Descripción',
            'descripcion_cumple_masc' => 'Descripción Niño-Cumple',
            'descripcion_cumple_fem' => 'Descripcion Niña-Cumple',
            'descripcion_nocumple_masc' => 'Descripcion Niño-No cumple',
            'descripcion_nocumple_fem' => 'Descripcion Niña-No cumple',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDimension()
    {
        return $this->hasOne(Dimensiones::className(), ['id_dimension' => 'id_dimension']);
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
    public function getPeriodoo()
    {
        return $this->hasOne(Periodos::className(), ['id_periodo' => 'periodo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndicadoresEstudiantes()
    {
        return $this->hasMany(IndicadoresEstudiantes::className(), ['id_indicador' => 'id_indicador']);
    }
}
