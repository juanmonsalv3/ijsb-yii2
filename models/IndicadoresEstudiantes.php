<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "indicadores_estudiantes".
 *
 * @property integer $id_indicador_estudiante
 * @property integer $id_estudiante_grupo
 * @property integer $id_indicador
 * @property string $anio
 * @property integer $cumple
 *
 * @property Indicadores $idIndicador
 * @property GruposEstudiantes $idEstudianteGrupo
 */
class IndicadoresEstudiantes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'indicadores_estudiantes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_estudiante_grupo', 'id_indicador', 'anio','cumple'], 'required'],
            [['id_indicador_estudiante','id_estudiante_grupo', 'id_indicador','cumple'], 'integer'],
            [['anio'], 'string', 'max' => 4]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_indicador_estudiante' => 'Id Indicador Estudiante',
            'id_estudiante_grupo' => 'Id Estudiante Grupo',
            'id_indicador' => 'Id Indicador',
            'anio' => 'Anio',
            'cumple' => 'Cumple',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndicador()
    {
        return $this->hasOne(Indicadores::className(), ['id_indicador' => 'id_indicador']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudianteGrupo()
    {
        return $this->hasOne(GruposEstudiantes::className(), ['id_grupo_estudiante' => 'id_estudiante_grupo']);
    }
    
    public function getCumpletexto() {
        return $this->cumple? 'Sí':'No';        
    }
}

