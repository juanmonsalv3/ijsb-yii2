<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fichapsicologica".
 *
 * @property integer $id_estudiante
 * @property string $cuantoshermanos
 * @property string $posicionhermanos
 * @property string $detalle_embarazo
 * @property string $detalle_nacimiento
 * @property string $complicaciones_natales
 * @property string $edad_gateo
 * @property string $edad_camino
 * @property string $caracter
 * @property string $reaccion_malgenio
 * @property string $reaccion_alegre
 * @property string $persona_vinculoafectivo
 * @property string $persona_atiendesupervisa
 * @property string $edad_habla
 * @property string $expresacorrientemente
 * @property string $habla_gritos
 * @property string $edad_controlesfinter
 * @property string $lavadientes
 * @property string $lavamanos
 * @property string $viste
 * @property string $cordoneszapatos
 * @property string $horadormir
 * @property string $horasdormido
 * @property string $pesadillas
 * @property string $habitodormir
 * @property string $mojadenoche
 * @property string $chupadedo
 * @property string $despierta
 * @property string $comidasenfamilia
 * @property string $apetito
 * @property string $gustahacer
 * @property string $conquienjuega
 * @property string $actitudjuego
 * @property string $amigoimaginario
 * @property string $cuentos
 * @property string $musica
 * @property string $cine
 * @property string $television
 * @property string $programas
 * @property string $conductas
 * @property string $traumas
 *
 * @property Estudiantes $idEstudiante
 */
class Fichapsicologica extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fichapsicologica';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_estudiante'], 'required'],
            [['id_estudiante'], 'integer'],
            [['cuantoshermanos', 'posicionhermanos', 'edad_gateo', 'edad_camino', 'edad_habla', 'edad_controlesfinter', 'lavadientes', 'lavamanos', 'viste', 'cordoneszapatos', 'horadormir', 'horasdormido', 'mojadenoche', 'chupadedo'], 'string', 'max' => 10],
            [['detalle_embarazo', 'detalle_nacimiento', 'complicaciones_natales', 'caracter', 'reaccion_malgenio', 'reaccion_alegre', 'habitodormir', 'apetito', 'musica', 'programas', 'conductas', 'traumas'], 'string', 'max' => 300],
            [['persona_vinculoafectivo', 'persona_atiendesupervisa', 'expresacorrientemente', 'habla_gritos', 'pesadillas', 'comidasenfamilia', 'gustahacer', 'conquienjuega', 'actitudjuego', 'amigoimaginario', 'cine', 'television'], 'string', 'max' => 100],
            [['despierta', 'cuentos'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_estudiante' => 'Id Estudiante',
            'cuantoshermanos' => 'Cantidad de hermanos',
            'posicionhermanos' => 'Posición entre hermanos',
            'detalle_embarazo' => 'Detalle del Embarazo',
            'detalle_nacimiento' => 'Detalle del Nacimiento',
            'complicaciones_natales' => 'Complicaciones Natales',
            'edad_gateo' => '¿A qué edad gateó?',
            'edad_camino' => '¿A que edad caminó?',
            'caracter' => '¿Cómo es el carácter del niño?',
            'reaccion_malgenio' => '¿Cómo es su reacción con malgenio?',
            'reaccion_alegre' => '¿Cómo es su reacción alegre?',
            'persona_vinculoafectivo' => '¿Con qué persona posee mayor vinculo afectivo más estrecho?',
            'persona_atiendesupervisa' => '¿Habitualmente qué persona Atiende y supervisa al niño en sus tareas?',
            'edad_habla' => '¿A qué edad empezó a hablar?',
            'expresacorrientemente' => '¿Se expresa corrientemente?',
            'habla_gritos' => '¿Habla a los gritos?',
            'edad_controlesfinter' => '¿A qué edad empezó el control de esfínteres?',
            'lavadientes' => '¿Se lava los dientes solo?',
            'lavamanos' => '¿Se lava las manos solo? ',
            'viste' => '¿Se viste solo, sin pedir ayuda? ',
            'cordoneszapatos' => '¿Se amarra los cordones de los zapatos? ',
            'horadormir' => '¿A que horas se acuesta?',
            'horasdormido' => '¿Cuántas horas duerme?',
            'pesadillas' => '¿Presenta pesadillas con regularidad? ',
            'habitodormir' => '¿Tiene algún hábito para dormir?',
            'mojadenoche' => '¿Se moja de noche?',
            'chupadedo' => '¿Se chupa el dedo?',
            'despierta' => '¿Cómo se despierta generalmente?',
            'comidasenfamilia' => '¿Realiza sus cómidas en familia?',
            'apetito' => '¿Cómo es su apetito?',
            'gustahacer' => '¿Qué es lo que más le gusta hacer?',
            'conquienjuega' => '¿Con quién juega?',
            'actitudjuego' => '¿Qué actitud asume en el juego?',
            'amigoimaginario' => '¿Ha presentado amigo imaginario?',
            'cuentos' => '¿Le leen cuentos?',
            'musica' => '¿Qué música le gusta escuchar?',
            'cine' => '¿Va al cine con frecuencia? ',
            'television' => '¿Cuántas horas de televisión ve en el día? ',
            'programas' => '¿Qué tipo de programas prefiere?',
            'conductas' => '¿Ha presentado conductas agresivas de excesiva sumisión o de timidez y miedo en las relaciones con sus hermanos o con otros niños?',
            'traumas' => '¿Considera usted que el niño ha vivido alguna experiencia traumática?',
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
