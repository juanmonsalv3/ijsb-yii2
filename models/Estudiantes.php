<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estudiantes".
 *
 * @property integer $id_estudiante
 * @property string $nombres
 * @property string $apellidos
 * @property string $fecha_nacimiento
 * @property string $ciudad_nacimiento
 * @property integer $activo
 * @property integer $id_inscripcion
 * @property string $sexo
 *
 * @property Acudientes[] $acudientes
 * @property Usuarios[] $idAcudientes
 * @property Fichamedica[] $fichamedicas
 * @property Fichapsicologica[] $fichapsicologicas
 * @property GruposEstudiantes[] $gruposEstudiantes
 */
class Estudiantes extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estudiantes';
    }
    
    public function rules()
    {
        return [
            [['nombres', 'apellidos'], 'required', 'message'=>'Este campo es obligatorio'],
            [['fecha_nacimiento'], 'safe','message'=>'Ingrese un formato de fecha válido'],
            [['activo', 'id_inscripcion'], 'integer'],
            [['nombres', 'apellidos'], 'string', 'max' => 200],
            [['ciudad_nacimiento'], 'string', 'max' => 50],
            [['sexo'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_estudiante' => 'Id Estudiante',
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'fecha_nacimiento' => 'Fecha de Nacimiento',
            'ciudad_nacimiento' => 'Ciudad de Nacimiento',
            'activo' => 'Activo',
            'id_inscripcion' => 'Inscripcion',
            'sexo' => 'Sexo',
            'sexoTexto'=>'Sexo'
        ];
    }

    public function getNombreCompleto() {
        return $this->apellidos.' '.$this->nombres;
    }
    
    public function getEdad(){
        $c= date('Y');
        $y= date('Y',strtotime($this->fecha_nacimiento));
        $edad = $c-$y;
        return $edad > 10 ? '-' : $edad. ' Años';
    }
    
    public function getSexoTexto(){
        if($this->sexo === 'M')
        {
            return 'Masculino';
        }
        else
        {
            return 'Femenino';
        }
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAcudientes()
    {
        return $this->hasMany(Acudientes::className(), ['id_estudiante' => 'id_estudiante']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcudientes()
    {
        return $this->hasMany(Usuarios::className(), ['id_usuario' => 'id_acudiente'])->viaTable('acudientes', ['id_estudiante' => 'id_estudiante']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFichaMedica()
    {
        return $this->hasOne(Fichamedica::className(), ['id_estudiante' => 'id_estudiante']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFichaPsicologica()
    {
        return $this->hasOne(Fichapsicologica::className(), ['id_estudiante' => 'id_estudiante']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGruposEstudiantes()
    {
        return $this->hasMany(GruposEstudiantes::className(), ['id_estudiante' => 'id_estudiante']);
    }
    
    public function getGrupos()
    {
        return $this->hasMany(Grupos::className(), ['id_grupo' => 'id_grupo'])
            ->via('gruposEstudiantes');
    }
    
    public function getGrupoActual()
    {
        return $this->hasOne(Grupos::className(), ['id_grupo' => 'id_grupo'])
            ->via('gruposEstudiantes',
                function($query){
                    $anioencurso = Yii::$app->cache->get('parametros')['anioencurso']['valor'];
                    $query->onCondition(['anio'=>$anioencurso]);
                });
    }
    
    public function getInscripcion()
    {
        return $this->hasOne(Inscripciones::className(), ['id_solicitud' => 'id_inscripcion']);
    }
    
    /**
     * fetch stored image url
     * @return string
     */
    public function getImageUrl() 
    {
        // return a default image placeholder if your source avatar is not found
        $avatar = isset($this->foto) ? 'estudiantes/'.$this->foto : 'default.png';
        return $avatar;
    }
}
