<?php

namespace app\models;

use Yii;
use app\models\Profesores;



/**
 * This is the model class for table "grupos".
 *
 * @property integer $id_grupo
 * @property string $nombre
 * @property string $descripcion
 *
 * @property GruposAsignaturas[] $gruposAsignaturas
 * @property Asignaturas[] $idAsignaturas
 * @property GruposEstudiantes[] $gruposEstudiantes
 * @property Indicadores[] $indicadores
 * @property Inscripciones[] $inscripciones
 * @property Profesores[] $profesores
 */
class Grupos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'grupos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'descripcion'], 'required'],
            [['nombre'], 'string', 'max' => 40],
            [['descripcion'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_grupo' => 'Id Grupo',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGruposAsignaturas()
    {
        return $this->hasMany(GruposAsignaturas::className(), ['id_grupo' => 'id_grupo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignaturas()
    {
        return $this->hasMany(Asignaturas::className(), 
                ['id_asignatura' => 'id_asignatura'])
                    ->viaTable('grupos_asignaturas', ['id_grupo' => 'id_grupo'],
                            function($query){
                                $query->onCondition(['activo'=>'1']);
                            });
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudiantes()
    {
        return $this->hasMany(Estudiantes::className(), ['id_estudiante' => 'id_estudiante'])
                ->andOnCondition(['activo' => 1])
                ->viaTable('grupos_estudiantes', ['id_grupo' => 'id_grupo'],
                function($query){
                    $anioencurso = Yii::$app->cache->get('parametros')['anioencurso']['valor'];
                    $query->onCondition(['anio'=>$anioencurso]);
                })->orderBy('apellidos');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGruposEstudiantes()
    {
        return $this->hasMany(GruposEstudiantes::className(), ['id_grupo' => 'id_grupo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndicadores()
    {
        return $this->hasMany(Indicadores::className(), ['id_grupo' => 'id_grupo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInscripciones()
    {
        return $this->hasMany(Inscripciones::className(), ['id_grupo' => 'id_grupo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfesores()
    {
        return $this->hasOne(Usuarios::className(), ['id_usuario' => 'id_usuario'])
            ->viaTable('profesores_grupos', ['id_grupo' => 'id_grupo'],
            function($query){
                $anioencurso = Parametros::find()->where(['codigo_parametro' => 'anioencurso'])->one();
                $query->onCondition(['anio'=>$anioencurso->valor]);
            });
    }
    
    public function getTotalEstudiantes(){
        $anio = Yii::$app->cache->get('parametros')['anioencurso']['valor'];
        return GruposEstudiantes::find()->where(['id_grupo'=>$this->id_grupo,'anio'=>$anio])->count();
    }
}
