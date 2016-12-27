<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios".
 *
 * @property integer $id_usuario
 * @property string $login
 * @property string $password
 * @property integer $id_perfil
 * @property string $nombres
 * @property string $apellidos
 * @property string $email
 * @property string $telefono
 * @property string $celular
 * @property string $ciudad_nacimiento
 * @property string $fecha_nacimiento
 * @property string $ocupacion
 * @property integer $activo
 * @property string $authKey
 * @property string $accessToken
 *
 * @property Acudientes[] $acudientes
 * @property Estudiantes[] $idEstudiantes
 * @property Mensajes[] $mensajes
 * @property MensajesDestinatarios[] $mensajesDestinatarios
 * @property ProfesoresGrupos[] $profesoresGrupos
 * @property Perfiles $idPerfil
 */
class Usuarios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_perfil', 'nombres', 'email', 'authKey', 'accessToken'], 'required','message'=>'Campo obligatorio'],
            [['id_perfil', 'activo'], 'integer'],
            [['fecha_nacimiento'], 'safe'],
            [['login', 'ciudad_nacimiento'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 40],
            [['nombres', 'apellidos', 'email', 'ocupacion'], 'string', 'max' => 100],
            [['telefono', 'celular'], 'string', 'max' => 20],
            [['authKey', 'accessToken'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_usuario' => 'Id Usuario',
            'login' => 'Login',
            'password' => 'Password',
            'id_perfil' => 'Perfil',
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'email' => 'Email',
            'telefono' => 'Telefono',
            'celular' => 'Celular',
            'ciudad_nacimiento' => 'Ciudad Nacimiento',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'ocupacion' => 'Ocupación',
            'activo' => 'Activo',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcudientes()
    {
        return $this->hasMany(Acudientes::className(), ['id_acudiente' => 'id_usuario']);
    }
    
    public function getAcudiente()
    {
        return $this->hasOne(Acudientes::className(), ['id_acudiente' => 'id_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEstudiantes()
    {
        return $this->hasMany(Estudiantes::className(), ['id_estudiante' => 'id_estudiante'])->viaTable('acudientes', ['id_acudiente' => 'id_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMensajes()
    {
        return $this->hasMany(Mensajes::className(), ['id_remitente' => 'id_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMensajesDestinatarios()
    {
        return $this->hasMany(MensajesDestinatarios::className(), ['id_destinatario' => 'id_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfesoresGrupos()
    {
        return $this->hasMany(ProfesoresGrupos::className(), ['id_usuario' => 'id_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerfil()
    {
        return $this->hasOne(Perfiles::className(), ['id_perfil' => 'id_perfil']);
    }
    
    public function getIsActivo(){
        return $this->activo ? 'Sí': 'No';
    }
    
    public function getNombreCompleto(){
        return $this->nombres.' '.$this->apellidos;
    }
    
    public function convertNombresToLogin(){
        $nombres = explode(" ", $this->nombres);
        $apellidos = explode(" ", $this->apellidos);
        
        $firsletter = substr($this->nombres, 0, 1);
        $surname = $apellidos[0];
        
        $user = strtolower($firsletter.$surname);
        
        if(!Usuarios::find()
            ->where( [ 'login' => $user ] )
            ->exists())
        {
            return $user;
        }
                
        if(count($nombres)>1)
        {
            $secondletter = substr($nombres[1], 0, 1);
            $user = strtolower($firsletter.$secondletter.$surname);
            if(!Usuarios::find()
                ->where( [ 'login' => $user ] )
                ->exists())
            {
                return $user;
            }
        }
        else if (count($apellidos)>1)
        {
            $secondletter = substr($apellidos[1], 0, 1);
            $user = strtolower($firsletter.$surname.$secondletter);
            if(!Usuarios::find()
                ->where( [ 'login' => $user ] )
                ->exists())
            {
                return $user;
            }
        }
        else{
            for ($i=1;$i<100;$i++)
            {
                $user = strtolower($firsletter.$surname.$i);
                if(!Usuarios::find()
                    ->where( [ 'login' => $user ] )
                    ->exists())
                {
                    return $user;
                }
            }
        }
    }
}
