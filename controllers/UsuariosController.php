<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use app\models\Forms\FormRegistroUsuarios;
use app\models\Forms\FormSearchUsuarios;
use app\models\Forms\FormValidateEmail;
use app\models\Forms\FormResetPass;
use app\models\Usuarios;
use app\models\LoginForm;
use app\models\Parametros;


class UsuariosController extends Controller{
    
    public function beforeAction($action){
        
        
        if( $action->actionMethod == "actionMiPerfil" || $action->actionMethod == "actionLogin"){
            return true;
        }
        if( !in_array(Yii::$app->user->identity->id_perfil, [1,2]))
        {
            return $this->redirect(Url::toRoute('site/index'));
        }
    return true;
    }

    public function actionActivateemail($id) {
        $user = Usuarios::find()->where(["id_usuario" => $id])->one();
        $authKey = urlencode($user->authKey);

        $subject = "Confirmar registro";
        $body = "<h1>Haga click en el siguiente enlace para finalizar tu registro</h1>";
        $body .= "<a href='".Url::toRoute(['usuarios/confirm','id'=>$id,'authKey'=>$authKey],true)."'>Confirmar</a>";

        Yii::$app->mailer->compose()
            ->setTo($user->email)
            ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
            ->setSubject($subject)
            ->setHtmlBody($body)
            ->send();

        Yii::$app->session->setFlash('mensaje',  'Se envió un email con las instrucciones para activación.');
        return $this->redirect(['usuarios/']);
    }
    
    public function actionView($login){
        
        $model = Usuarios::find()->where("login=:login", [":login" => $login])
                    ->one();
        if($model == null)
        {
            return $this->redirect(['usuarios/index']);
        }
        
        return $this->render('view', ['model'=>$model]);
    }
    
    public function actionResend(){
        $this->layout = 'extranet';
        
        $model = new FormValidateEmail();
        
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $table = Usuarios::find()
                    ->where("email=:email", [":email" => $model->email])
                    ->one();
            
            $id = urlencode($table->id_usuario);
            $authKey = urlencode($table->authKey);
            
            $subject = "Restablecer contraseña - Instituto Jerome S Bruner";
            $body = "<h1>Haga click en el siguiente enlace para restablecer su contraseña ";
            $body .= "<a href='".Url::toRoute(['usuarios/reset','id'=>$id,'authKey'=>$authKey],true)."'>Restablecer</a></h1>";

            
            Yii::$app->mailer->compose()
            ->setTo($model->email)
            ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
            ->setSubject($subject)
            ->setHtmlBody($body)
            ->send();

            Yii::$app->session->setFlash('mensaje',  'Al correo indicado se enviaron las instrucciones para restablecer su contraseña.'); 
            $model->email = null;
            
        }
        
        if (Yii::$app->request->get())
        {
            $id = Html::encode(filter_input(INPUT_GET,"id", FILTER_SANITIZE_SPECIAL_CHARS));
            $authKey = filter_input(INPUT_GET, 'authKey', FILTER_SANITIZE_SPECIAL_CHARS);

            if ((int) $id)
            {
                $model = Usuarios::find()
                ->where("id_usuario=:id", [":id" => $id])
                ->andWhere("authKey=:authKey", [":authKey" => $authKey]);

                if ($model->count() == 1)
                {
                    $form->id = $id;
                    $form->authKey = $authKey;
                }
            }
        }
        
        return $this->render('resend',['model'=>$model]);
    }
    
    public function actionReset(){
        $this->layout = 'extranet';

        $form = new FormResetPass;
        
        if ($form->load(Yii::$app->request->post()) && Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        
        if($form->load(Yii::$app->request->post()) && $form->validate()){
            $table = Usuarios::find()
                    ->where("id_usuario=:id", [":id" => $form->id])
                    ->andWhere("authKey=:authKey", [":authKey" => $form->authKey])
                    ->one();
            $table->password = crypt($form->password, Yii::$app->params["salt"]);
            
            if($table->save())
            {
                Yii::$app->session->setFlash('mensaje',  'Contraseña guardada.'); 
            }
        }
        
        if (Yii::$app->request->get())
        {
            $id = Html::encode(filter_input(INPUT_GET,"id", FILTER_SANITIZE_SPECIAL_CHARS));
            $authKey = filter_input(INPUT_GET, 'authKey', FILTER_SANITIZE_SPECIAL_CHARS);

            if ((int) $id)
            {
                $model = Usuarios::find()
                ->where("id_usuario=:id", [":id" => $id])
                ->andWhere("authKey=:authKey", [":authKey" => $authKey]);

                if ($model->count() == 1)
                {
                    $form->id = $id;
                    $form->authKey = $authKey;
                }
            }
        }
        return $this->render('reset',['form'=>$form]);
    }
    
    public function actionForgot(){
        $this->layout = 'extranet';
        
        $model = new FormValidateEmail();
        
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post())){
            if($model->validate()){
                
                $user = Usuarios::find()->where(['email'=>$model->email])->one();
                $user->authKey = $this->randKey("abcdef0123456789", 200);
                $authKey = urlencode($user->authKey);
                
                if($user->save()){
                    
                    $id = urlencode($user->id_usuario);
                    $subject = "Restablecer contraseña - Instituto Jerome S Bruner";
                    $body = "<h1>Haga click en el siguiente enlace para restablecer su contraseña ";
                    $body .= "<a href='".Url::toRoute(['usuarios/reset','id'=>$id,'authKey'=>$authKey],true)."'>Restablecer</a></h1>";

                    
                    Yii::$app->mailer->compose()
                    ->setTo($model->email)
                    ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
                    ->setSubject($subject)
                    ->setHtmlBody($body)
                    ->send();
                    
                    Yii::$app->session->setFlash('mensaje',  'Al correo indicado se enviaron las instrucciones para restablecer su contraseña.'); 
                    $model->email = null;
                }
                else {
                    Yii::$app->session->setFlash('error',  'Operación abortada, por favor notifique al administrador del sistema.'); 
                }
            }
            else{
                Yii::$app->session->setFlash('error',  'Operación abortada, por favor notifique al administrador del sistema.'); 
            }
        }
        
        return $this->render("forgot", ['model'=>$model]);
    }
    
    public function actionIndex(){
        if (Yii::$app->user->isGuest){
            return $this->redirect(['usuarios/login']);
        }        
        $model = new FormSearchUsuarios;
        
        $query = Usuarios::find()->with('perfil');
        if ($model->load(Yii::$app->request->get()) )
        {
            if($model->perfil != null)
            {
                $query = $query->andWhere(["id_perfil"=>$model->perfil]);    
            }
            if($model->busqueda != null)
            {
                $query = $query->andWhere("login like '%".Html::encode($model->busqueda)."%'"
                        . "or nombres like '%".Html::encode($model->busqueda)."%'"
                        . "or apellidos like '%".Html::encode($model->busqueda)."%'"
                        . "or email like '%".Html::encode($model->busqueda)."%'"
                        );    
            }
            
        }
        $count = clone $query;
            $pages = new Pagination([
                "pageSize" => 10,
                "totalCount" => $count->count(),
            ]);
        
        $usuarios = $query->OrderBy('id_perfil, login, apellidos')
                ->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        
        return $this->render("index",["usuarios"=>$usuarios , "model"=>$model , "pages"=>$pages]);
    }
    
    public function actionNuevo(){
        if (Yii::$app->user->isGuest){
            return $this->redirect(['usuarios/login']);
        }
        $model = new FormRegistroUsuarios;
        
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())){
            
            if($model->validate()){
                $table = new Usuarios;
                $table->login = $model->login;
                $table->email = $model->email;
                $table->id_perfil = $model->perfil;
                $table->nombres = $model->nombres;
                $table->apellidos = $model->apellidos;
                $table->password = crypt($model->password, Yii::$app->params["salt"]);
                $table->authKey = $this->randKey("abcdef0123456789", 200);
                $table->accessToken = $this->randKey("abcdef0123456789", 200);
                echo $table->authKey;
                
                if ($table->insert()){
                    
                    $user = $table->find()->where(["email" => $model->email])->one();
                    $id = urlencode($user->id_usuario);
                    $authKey = urlencode($user->authKey);

                    $subject = "Confirmar registro";
                    $body = "<h1>Haga click en el siguiente enlace para finalizar tu registro</h1>";
                    $body .= "<a href='".Url::toRoute(['usuarios/confirm','id'=>$id,'authKey'=>$authKey],true)."'>Confirmar</a>";

                    Yii::$app->mailer->compose()
                        ->setTo($user->email)
                        ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
                        ->setSubject($subject)
                        ->setHtmlBody($body)
                        ->send();

                    $model->login = null;
                    $model->email = null;
                    $model->password = null;
                    $model->password_repeat = null;

                    Yii::$app->session->setFlash('mensaje',  'Se envió un email con las instrucciones para activar su cuenta.');
                    return $this->redirect(['usuarios/index']);
                }
                else
                {
                    $table->getErrors();
                }
            }
            else
            {
                $model->getErrors();
            }
        }
        return $this->render("registro", ["model" => $model]);
    }
    
    public function randKey($str='', $long=0){
        $key = null;
        $str = str_split($str);
        $start = 0;
        $limit = count($str)-1;
        for($x=0; $x<$long; $x++)
        {
            $key .= $str[rand($start, $limit)];
        }
        return $key;
    }
  
    public function actionConfirm(){
        
       $table = new Usuarios;
       
        if (Yii::$app->request->get()){
            
            $id = Html::encode(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS));
            $authKey = filter_input(INPUT_GET, 'authKey', FILTER_SANITIZE_SPECIAL_CHARS);

            if ((int) $id){
                
                $model = $table->find()
                ->where("id_usuario=:id", [":id" => $id])
                ->andWhere("authKey=:authKey", [":authKey" => $authKey]);

                if ($model->count() == 1){
                    $activar = Usuarios::findOne($id);
                    $activar->activo = 1;
                    if ($activar->update()){
                        Yii::$app->session->setFlash('mensaje',  'Registro exitoso.');
                    }
                    else{
                        Yii::$app->session->setFlash('error',  'Ocurrió un error al realizar el registro, intente nuevamente. '
                                . 'Si el problema persiste comuníquese con el administrador del sistema.');
                    }
                }
            }
           
            return $this->redirect(["site/index"]);
        }
    }
    
    public function actionLogin(){
        $this->layout = 'extranet';
        
        $model = new LoginForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->login()){
            
            $data = Parametros::find()->asArray()->indexBy('codigo_parametro')->all();

            Yii::$app->cache->set('parametros', $data);
            
            if( Yii::$app->user->identity->id_perfil == 4)
            {
                return $this->redirect(Url::toRoute('docente/index'));
            }
            else if( Yii::$app->user->identity->id_perfil == 5)
            {
                return $this->redirect(Url::toRoute('acudiente/index'));
            }
            
            return $this->redirect(["site/index"]);
            
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionLogout(){
        Yii::$app->session->remove('estudiante_acudiente');
        Yii::$app->user->logout();
        return $this->redirect(["usuarios/login"]);
    }
    
    public static function enviarCorreoConfirmacion($email, $login, $password){
        try{
            $subject = "Instituto Jerome S. Brunner - Usuario Registrado";
            $body = "<h1>Datos de usuario</h1>";
            $body .= "<br/>Usuario: ". $login;
            $body .= "<br/>Contraseña: ". $password;
            $body .= "<br/><a href='".Url::toRoute(['site/index'],true)."'>Acceder</a>";

            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
                ->setSubject($subject)
                ->setHtmlBody($body)
                ->send();
        } catch (Exception $ex) {
            Yii::$app->session->setFlash('error',  'Ocurrió un problema al enviar el correo de confirmación'); 
        }
    }
    
    public function actionMiPerfil() {
        $id_usuario = Yii::$app->user->identity->id_usuario;
        $usuario = Usuarios::find()->with('perfil')->where(['id_usuario'=>$id_usuario])->one();
        return $this->render('mi-perfil',['usuario'=>$usuario]);
    }
    
    public function actionEditarPerfil() {
        $id_usuario = Yii::$app->user->identity->id_usuario;
        $usuario = Usuarios::find()->with('perfil')->where(['id_usuario'=>$id_usuario])->one();
        
        if($usuario->load(Yii::$app->request->post())){
            if($usuario->save()){
                Yii::$app->session->setFlash('mensaje','Perfil actualizado');
                return $this->redirect(['usuarios/mi-perfil']);
            }
        }
        return $this->render('editar-perfil',['model'=>$usuario]);
    }
}
