<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vw_estudiantes_indicadores".
 *
 * @property integer $id_estudiante_grupo
 * @property integer $id_estudiante
 * @property integer $id_grupo
 * @property string $anio
 * @property string $sexo
 * @property integer $id_indicador
 * @property integer $id_periodo
 * @property string $dimension
 * @property string $descripcion_general
 * @property integer $cumple
 * @property string $descripcion
 */
class VwEstudiantesIndicadores extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_estudiantes_indicadores';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_estudiante_grupo', 'id_grupo', 'anio', 'id_periodo', 'dimension', 'descripcion_general', 'cumple'], 'required'],
            [['id_estudiante_grupo', 'id_estudiante', 'id_grupo', 'id_indicador', 'id_periodo', 'cumple'], 'integer'],
            [['anio'], 'string', 'max' => 4],
            [['sexo'], 'string', 'max' => 1],
            [['dimension'], 'string', 'max' => 50],
            [['descripcion_general', 'descripcion'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_estudiante_grupo' => 'Id Estudiante Grupo',
            'id_estudiante' => 'Id Estudiante',
            'id_grupo' => 'Id Grupo',
            'anio' => 'Anio',
            'sexo' => 'Sexo',
            'id_indicador' => 'Id Indicador',
            'id_periodo' => 'Id Periodo',
            'dimension' => 'Dimension',
            'descripcion_general' => 'Descripcion General',
            'cumple' => 'Cumple',
            'descripcion' => 'Descripcion',
        ];
    }
}
