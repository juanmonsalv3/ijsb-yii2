<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fichamedica".
 *
 * @property integer $id_estudiante
 * @property string $urgencia_avisar_a
 * @property string $telefono
 * @property string $tipo_sangre
 * @property string $nacimiento
 * @property string $alergias
 * @property boolean $asma
 * @property boolean $convulsiones
 * @property boolean $diabetes
 * @property boolean $sangrado_nasal
 * @property boolean $dolor_cabeza
 * @property boolean $tratamiento_actual
 * @property string $otras_enfermedades
 * @property boolean $puedetomar_dolex
 * @property boolean $puedetomar_acetaminofen
 * @property boolean $puedetomar_buscapina
 * @property boolean $puedetomar_plasil
 * @property boolean $puedetomar_dristan
 * @property string $enfermedades
 * @property string $medicamentos
 * @property string $observaciones
 *
 * @property Estudiantes $idEstudiante
 */
class Fichamedica extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fichamedica';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_estudiante', 'urgencia_avisar_a', 'telefono', 'tipo_sangre'], 'required','message'=>'Este campo no puede estar en blanco'],
            [['id_estudiante'], 'integer'],
            [['asma', 'convulsiones', 'diabetes', 'sangrado_nasal', 'dolor_cabeza', 'tratamiento_actual', 'puedetomar_dolex', 'puedetomar_acetaminofen', 'puedetomar_buscapina', 'puedetomar_plasil', 'puedetomar_dristan'], 'boolean'],
            [['urgencia_avisar_a'], 'string', 'max' => 100],
            [['telefono'], 'string', 'max' => 50],
            [['tipo_sangre'], 'string', 'max' => 3],
            [['nacimiento'], 'string', 'max' => 10],
            [['alergias', 'otras_enfermedades', 'enfermedades', 'medicamentos', 'observaciones'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_estudiante' => 'Id Estudiante',
            'urgencia_avisar_a' => 'En caso de urgencia avisar a',
            'telefono' => 'Teléfono',
            'tipo_sangre' => 'Tipo de Sangre',
            'nacimiento' => 'Tipo de nacimiento',
            'alergias' => 'Alergias conocidas',
            'asma' => '¿Sufre de Asma?',
            'convulsiones' => '¿Sufre de Convulsiones?',
            'diabetes' => 'Sufre de Diabetes?',
            'sangrado_nasal' => '¿Sufre de Sangrado Nasal?',
            'dolor_cabeza' => '¿Sufre de Dolores de Cabeza Frecuentes?',
            'tratamiento_actual' => '¿Está bajo tratamiento Actualmente?',
            'otras_enfermedades' => '¿Otras Enfermedades?',
            'puedetomar_dolex' => '¿Puede tomar Dolex?',
            'puedetomar_acetaminofen' => '¿Puede tomar Acetaminofén?',
            'puedetomar_buscapina' => '¿Puede tomar Buscapina?',
            'puedetomar_plasil' => '¿Puede tomar Plasil?',
            'puedetomar_dristan' => '¿Puede tomar Dristan?',
            'enfermedades' => 'Enfermedades conocidas',
            'medicamentos' => 'Medicamentos que consuma actualmente',
            'observaciones' => 'Observaciones',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudiante()
    {
        return $this->hasOne(Estudiantes::className(), ['id_estudiante' => 'id_estudiante']);
    }
}
