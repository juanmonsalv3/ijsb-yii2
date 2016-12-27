<?php
namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\models\Usuarios;

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

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        $user = Usuarios::find()
	                ->where("activo=:activo", [":activo" => 1])
	                ->andWhere("id_usuario=:id", ["id" => $id])
	                ->one();
	        return isset($user) ? new static($user) : null;
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $users = Usuarios::find()
                ->where("activo=:activo", [":activo" => 1])
                ->andWhere("accessToken=:accessToken", [":accessToken" => $token])
                ->all();
        
        foreach ($users as $user) {
            if ($user->accessToken === $token) {
                return new static($user);
            }
        }

        return null;
    }
    
    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    
    /* Busca la identidad del usuario a través del username */
    public static function findByUsername($username)
    {
        $users = Usuarios::find()
                ->where("activo=:activo", ["activo" => 1])
                ->andWhere("login = '".$username."' or email = '".$username."'")
                ->all();
        
        foreach ($users as $user) {
            if (strcasecmp($user->login, $username) === 0) {
                return new static($user);
            }
            if (strcasecmp($user->email, $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }
    

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id_usuario;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    
    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        /* Valida el password */
        if (crypt($password, $this->password) == $this->password)
        {
        return $password === $password;
        }
    }
}