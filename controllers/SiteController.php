<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;


class SiteController extends Controller{
    
    public function beforeAction($action){
        if($action->id == 'error'){
            $this->layout = 'extranet';
            return true;
        }
        if (Yii::$app->user->isGuest)
        {
            $this->redirect(['usuarios/login']);
        }
        if(Yii::$app->user->identity->id_perfil == 4){
            $this->redirect(['docente/grupos']);
        }
        return true;
    }
    
    public function behaviors(){
        
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex(){
        if(Yii::$app->user->identity->id_perfil === 5){
            return $this->redirect(['acudiente/']);
        }
        $this->layout = 'welcome';
        return $this->render('index');
    }
    
    public function actionError()
    {
        $this->layout = '';
        
        $error = Yii::app()->errorHandler->error;

        if( $error )
        {
            $this -> render( 'error', array( 'error' => $error ) );
        }
    }
}
