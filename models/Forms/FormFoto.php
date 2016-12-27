<?php

namespace app\models\Forms;

use yii\base\Model;
use yii\web\UploadedFile;

class FormFoto extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'message'=>'Solo se adminten formatos png y jpg'],
            [['imageFile'], 'required', 'message' => 'Por favor seleccione una imagen', ],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $fileName = FormFoto::generateRandomString(). '.' . $this->imageFile->extension;
            $this->imageFile->saveAs('images/estudiantes/' . $fileName);
            return $fileName;
        } else {
            return false;
        }
    }
    
    function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}