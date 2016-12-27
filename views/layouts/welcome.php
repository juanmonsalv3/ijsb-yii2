<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php echo Yii::$app->getHomeUrl(); ?>favicon.ico" type="image/x-icon" />
    <script src="https://code.jquery.com/jquery-2.1.4.min.js" type="text/javascript"></script>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' =>  Html::img('@web/images/logo.png', ['alt'=>Yii::$app->name, 'class'=>'img-logo'])." ".Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    if(!Yii::$app->user->isGuest)
    {
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [

                [
                    'label' => Yii::$app->user->identity->nombres,
                    'items' => [
                         ['label' => 'Mi Perfil', 'url' => Url::toRoute(["usuarios/mi-perfil"])],
                         ['label' => 'Cerrar Sesión', 'url' => Url::toRoute('usuarios/logout')],
                    ],
                ],
            ],
        ]);
    }
    
    NavBar::end();
    ?>
    <style>
        
    </style>
    <div class="container">
        <div id="notify-wrap"></div>
        <div class="row cuadricula">
            <div class="col-xs-12 col-sm-4 col-md-3">
                <div class="thumbnail">
                    <a href="<?=Url::toRoute(["inscripciones/"])?>">
                        <?=Html::img('@web/images/inscripciones.png')?>
                    </a>
                    <div class="caption">
                      <h3><a href="<?=Url::toRoute(["inscripciones/"])?>"> Inscripciones</a></h3>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-3">
                <div class="thumbnail">
                    <a href="<?=Url::toRoute(["matricula/"])?>">
                        <?=Html::img('@web/images/matricula.jpg')?>
                    </a>
                    <div class="caption">
                      <h3><a href="<?=Url::toRoute(["matricula/"])?>"> Matrícula</a></h3>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-3">
                <div class="thumbnail">
                    <a href="<?=Url::toRoute(["indicadores/"])?>">
                        <?=Html::img('@web/images/indicadores.jpg')?>
                    </a>
                    <div class="caption">
                      <h3><a href="<?=Url::toRoute(["indicadores/"])?>"> Indicadores</a></h3>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-3">
                <div class="thumbnail">
                    <a href="<?=Url::toRoute(["usuarios/"])?>">
                        <?=Html::img('@web/images/usuarios.jpg')?>
                    </a>
                    <div class="caption">
                      <h3><a href="<?=Url::toRoute(["usuarios/"])?>"> Usuarios</a></h3>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-3">
                <div class="thumbnail">
                    <a href="<?=Url::toRoute(["estudiantes/"])?>">
                        <?=Html::img('@web/images/estudiantes.jpg')?>
                    </a>
                    <div class="caption">
                      <h3><a href="<?=Url::toRoute(["estudiantes/"])?>"> Estudiantes</a></h3>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-3">
                <div class="thumbnail">
                    <a href="<?=Url::toRoute(["grupos/"])?>">
                        <?=Html::img('@web/images/grupos.jpg')?>
                    </a>
                    <div class="caption">
                      <h3><a href="<?=Url::toRoute(["grupos/"])?>"> Grupos</a></h3>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-3">
                <div class="thumbnail">
                    <a href="<?=Url::toRoute(["parametros/"])?>">
                        <?=Html::img('@web/images/parametros.png')?>
                    </a>
                    <div class="caption">
                      <h3><a href="<?=Url::toRoute(["parametros/"])?>"> Configuración</a></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
<footer class="footer" style="padding-top:10px;">
    <div class="container">
        <p class="pull-left">
            <?=Html::img('@web/images/udc.png', ['alt'=>Yii::$app->name, 'class'=>'img-logo']) ?> Universidad de Cartagena - <?= date('Y') ?>
        </p>

        <p class="pull-right">
            Grupo de Investigaciones Gimática <?=Html::img('@web/images/gimatica.png', ['alt'=>Yii::$app->name, 'class'=>'img-logo']) ?> 
        </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

<script>
    $(document).ready(function(){
        <?php if(Yii::$app->session->hasFlash('error')):  ?>
            mostrarError('<?= Yii::$app->session->getFlash('error') ?>');
        <?php endif ?>
        <?php if(Yii::$app->session->hasFlash('mensaje')):  ?>
            mostrarMensaje('<?= Yii::$app->session->getFlash('mensaje') ?>');
        <?php endif ?>
    });
</script>

