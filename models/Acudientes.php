<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "acudientes".
 *
 * @property integer $id_estudiante
 * @property integer $id_acudiente
 * @property string $parentesco
 *
 * @property Estudiantes $idEstudiante
 * @property Usuarios $idAcudiente
 */
class Acudientes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'acudientes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_estudiante', 'id_acudiente', 'parentesco'], 'required'],
            [['id_estudiante', 'id_acudiente', 'id_parentesco'], 'integer'],
            [['parentesco'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_estudiante' => 'Id Estudiante',
            'id_acudiente' => 'Id Acudiente',
            'parentesco' => 'Parentesco',
            'id_parentesco' => 'Parentesco'
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
    public function getAcudiente()
    {
        return $this->hasOne(Usuarios::className(), ['id_usuario' => 'id_acudiente']);
    }
    
    public function getParentescoEntitie()
    {
        return $this->hasOne(Parentesco::className(), ['id_parentesco' => 'id_parentesco']);
    }
}
