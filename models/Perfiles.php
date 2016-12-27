<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "perfiles".
 *
 * @property integer $id_perfil
 * @property string $nombre
 *
 * @property MenusPerfiles[] $menusPerfiles
 * @property Menus[] $idMenus
 * @property Usuarios[] $usuarios
 */
class Perfiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'perfiles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_perfil' => 'Id Perfil',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenusPerfiles()
    {
        return $this->hasMany(MenusPerfiles::className(), ['id_perfil' => 'id_perfil']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMenus()
    {
        return $this->hasMany(Menus::className(), ['id_menu' => 'id_menu'])->viaTable('menus_perfiles', ['id_perfil' => 'id_perfil']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::className(), ['id_perfil' => 'id_perfil']);
    }
}
