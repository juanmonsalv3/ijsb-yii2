<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grupos_estudiantes".
 *
 * @property integer $id_grupo_estudiante
 * @property integer $id_estudiante
 * @property integer $id_grupo
 * @property string $anio
 * @property string $estado
 *
 * @property Estudiantes $idEstudiante
 * @property Grupos $idGrupo
 * @property IndicadoresEstudiantes[] $indicadoresEstudiantes
 */
class GruposEstudiantes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'grupos_estudiantes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_estudiante', 'id_grupo', 'anio'], 'required'],
            [['id_estudiante', 'id_grupo'], 'integer'],
            [['anio'], 'string', 'max' => 4],
            [['estado'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_estudiante' => 'Id Estudiante',
            'id_grupo' => 'Id Grupo',
            'anio' => 'Anio',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudiante()
    {
        return $this->hasOne(Estudiantes::className(), ['id_estudiante' => 'id_estudiante']);
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
    public function getIndicadoresEstudiantes()
    {
        return $this->hasMany(IndicadoresEstudiantes::className(), ['id_estudiante_grupo' => 'id_grupo_estudiante']);
    }
    
    public function getIndicadores()
    {
        return $this->hasMany(Indicadores::className(), ['id_indicador' => 'id_indicador'])
        ->viaTable('indicadores_estudiantes', ['id_estudiante_grupo' => 'id_grupo_estudiante']);
    }
    
    public function getTextoEstado() {
        switch ($this->estado)
        {
            case 'A':
                return 'Activo';
            case 'P':
                return 'Promovido';
            case 'N':
                return 'No Promovido';
            default:
                return'';
        }
    }
}
