<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Estudiantes;

class BaseController extends Controller
{
	public function beforeAction($action) {
        $this->enableCsrfValidation = false; // <-- here
        return parent::beforeAction($action);
    }
}