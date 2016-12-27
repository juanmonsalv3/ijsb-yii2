<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Usuarios;
use app\models\Acudientes;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use app\controllers\UsuariosController;
use yii\web\Response;
use yii\helpers\Url;

class AcudientesController extends Controller{
    
    public function beforeAction($action){
        if (Yii::$app->user->isGuest)
        {
            $this->redirect(['usuarios/login']);
        }
        return true;
    }
    
    public function actionSeleccionAcudientes($id, $search=''){
        $query = Usuarios::find()
                ->leftJoin('acudientes','acudientes.id_acudiente = usuarios.id_usuario and acudientes.id_estudiante = '.$id)
                ->where('acudientes.id_acudiente is null and usuarios.id_perfil = 5')
                ->andWhere("nombres like '%".$search."%' or apellidos like '%".$search."%'");
        
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        
        return $this->renderAjax('seleccion-acudientes',['acudientes'=>$dataProvider]);
    }
    
    public function actionBorrarAcudiente($id_usuario, $id_estudiante)
    {
        $acudiente = Acudientes::find()->where(['id_acudiente'=>$id_usuario,'id_estudiante'=>$id_estudiante])->one();
        
        if($acudiente->delete())
        {
            Yii::$app->session->setFlash('mensaje',  'Acudiente removido.'); 
        }
        else{
            Yii::$app->session->setFlash('error',  'No se pudo borrar el acudiente.'); 
        }
        
    }
    
    public function actionAsignarAcudiente($id_estudiante, $id_usuario, $parentesco )
    {
        $acudiente = new Acudientes;
        $acudiente->id_estudiante = $id_estudiante;
        $acudiente->id_acudiente = $id_usuario;
        $acudiente->parentesco = '-';
        $acudiente->id_parentesco = $parentesco;
        
        if($acudiente->save())
        {
            Yii::$app->session->setFlash('mensaje',  'Acudiente asignado.'); 
        }
        else{
            Yii::$app->session->setFlash('error',  'No se pudo agregar el acudiente.'); 
        }
    }
    // $form: \app\models\Forms\FormNuevoAcudiente
    public static function registrarAcudiente($form){
        $existeusuario = Usuarios::find()->where( [ 'email' => $form->email ] )->exists();
        if($existeusuario)
        {
            Yii::$app->session->setFlash('error',  'El correo indicado ya está registrado.'); 
            return false;
        }
        $usuario = new Usuarios;
        $usuario->nombres = $form->nombres;
        $usuario->apellidos = $form->apellidos;
        $usuario->login = $usuario->convertNombresToLogin();
        $usuario->id_perfil = 5;
        $usuario->email = $form->email;
        $usuario->telefono = $form->telefono;
        $password = substr(UsuariosController::randKey("abcdef0123456789", 200),0,6);
        $usuario->password = crypt($password, Yii::$app->params["salt"]);
        $usuario->authKey = UsuariosController::randKey("abcdef0123456789", 200);
        $usuario->accessToken = UsuariosController::randKey("abcdef0123456789", 200);
        $usuario->activo = 1;
        
        if($usuario->insert()){
            self::actionAsignarAcudiente($form->id_estudiante,$usuario->id_usuario,$form->parentesco);
            UsuariosController::enviarCorreoConfirmacion($usuario->email, $usuario->login, $password);

            return true;
        }
        else
        {
            Yii::$app->session->setFlash('error',  'Ocurrió un problema al registrar el usuario'); 
            return false;
        }
        
        return true;
    }
    
    
    public function actionNuevoAcudiente($id_estudiante = null){
        $form = new \app\models\Forms\FormNuevoAcudiente();
        
        $request = \Yii::$app->getRequest();
        
        if ($request->isPost && $form->load($request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            if(Usuarios::find()
                    ->where( [ 'email' => $form->email ] )
                    ->exists())
            {
                return ['result'=>false,'message'=>'Ya existe un usuario registrado con este correo.'];
            }
            $usuario = new Usuarios;
            $usuario->nombres = $form->nombres;
            $usuario->apellidos = $form->apellidos;
            $usuario->login = $usuario->convertNombresToLogin();
            $usuario->id_perfil = 5;
            $usuario->email = $form->email;
            $usuario->telefono = $form->telefono;
            $password = substr(UsuariosController::randKey("abcdef0123456789", 200),0,6);
            $usuario->password = crypt($password, Yii::$app->params["salt"]);
            $usuario->authKey = UsuariosController::randKey("abcdef0123456789", 200);
            $usuario->accessToken = UsuariosController::randKey("abcdef0123456789", 200);
            $usuario->activo = 1;
            
            $bool = $usuario->insert();
            if ($bool){
                self::actionAsignarAcudiente($form->id_estudiante,$usuario->id_usuario,$form->parentesco);
                                
                $subject = "Instituto Jerome S. Brunner - Usuario Registrado";
                $body = "<h1>Datos de usuario</h1>";
                $body .= "<br/>Usuario: ". $usuario->login;
                $body .= "<br/>Contraseña: ". $password;
                $body .= "<br/><a href='".Url::toRoute(['site/index'],true)."'>Acceder</a>";

                Yii::$app->mailer->compose()
                    ->setTo($usuario->email)
                    ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
                    ->setSubject($subject)
                    ->setHtmlBody($body)
                    ->send();
                
                return ['result'=>true,'message'=>'Acudiente registrado correctamente'];
            }
            else
            {
                $usuario->getErrors();
                return ['result'=>false, 'message'=>'No se pudo registrar el usuario'];
            }
            
        }
        
        $form->id_estudiante = $id_estudiante;
        
        return $this->renderAjax('nuevo',['model'=>$form]);
    }
}

