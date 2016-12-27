<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Collapse;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
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
       
        'brandLabel' =>  Html::img('@web/images/logo.png', ['alt'=>Yii::$app->name, 'class'=>'img-logo']).' Instituto Jerome S. Bruner ',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    
//    echo Nav::widget([
//        'options' => ['class' => 'navbar-nav navbar-left'],
//        'items' => 
//        [
//            [
//                'label' => 'Inscripciones', 
//                'items' => 
//                [
//                    ['label' => 'Nueva', 'url' => Url::toRoute('inscripciones/nueva')],
//                    '<li class="divider"></li>',
//                    ['label' => 'Lista', 'url' => Url::toRoute('inscripciones/')],
//                ],
//                 'active'=>Yii::$app->controller->id =='inscripciones' ,
//            ],
//            [
//                'label' => 'Matrícula', 
//                'url' => Url::toRoute('matricula/'),
//                 'active'=>Yii::$app->controller->id =='matricula' ,
//            ],
//        ],
//    ]);
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

    <div class="container">
        <div id="notify-wrap"></div>
        <div class="row">
            <div class="col-sm-3">
                <!-- left -->
             <?php   echo Collapse::widget([
                    'items' => [
                        [
                            'label' => 'Inscripciones',
                            'encode'=>false,
                            'content' => [
                                '<a href="'.Url::toRoute(["inscripciones/"]).'"><i class="glyphicon glyphicon-list-alt"></i> Lista</a>',
                                '<a href="'.Url::toRoute(["inscripciones/nueva"]).'"><i class="glyphicon glyphicon-plus"></i> Nueva</a>',
                            ],
                        ],
                        [
                            'label' => '<a href="'.Url::toRoute(["matricula/"]).'">Matrículas</a>',
                            'encode'=>false,
                            'content' => [
                                '',
                            ],
                        ],
                        [
                            'label' => 'Indicadores',
                            'encode'=>false,
                            'content' => [
                                '<a href="'.Url::toRoute(["indicadores/dimensiones"]).'"><i class="glyphicon glyphicon-scissors"></i> Dimensiones</a>',
                                '<a href="'.Url::toRoute(["indicadores/"]).'"><i class="glyphicon glyphicon-list-alt"></i> Lista</a>',
                                '<a href="'.Url::toRoute(["indicadores/nuevo"]).'"><i class="glyphicon glyphicon-plus"></i> Nuevo</a>',
                            ],
                        ],
                        [
                            'label' => '<a href="'.Url::toRoute(["usuarios/"]).'">Usuarios</a>',
                            'encode'=>false,
                            'content' => [
                                '',
                            ],
                        ],
                        [
                            'label' => 'Estudiantes',
                            'encode'=>false,
                            'content' => [
                                '<a href="'.Url::toRoute(["estudiantes/"]).'"><i class="glyphicon glyphicon-list-alt"></i> Lista</a>',
                                '<a href="'.Url::toRoute(["estudiantes/nuevo"]).'"><i class="glyphicon glyphicon-plus"></i> Nuevo</a>',
                            ],
                        ],
                        [
                            'label' => '<a href="'.Url::toRoute(["grupos/"]).'">Grupos</a>',
                            'encode'=>false,
                            'content' => [
                                '',
                            ],
                        ],
                        [
                            'label' => '<a href="'.Url::toRoute(["parametros/"]).'">Parametros</a>',
                            'encode'=>false,
                            'content' => [
                                '',
                            ],
                        ],
                        
                     ],
                ]);?>
                <hr><h1>asdasd</h1>

            </div><!-- /span-3 -->
            <div class="col-sm-9 content">

                <?= Breadcrumbs::widget([
                       'homeLink' => [ 
                                       'label' => Yii::t('yii', 'Instituto'),
                                       'url' => Yii::$app->homeUrl,
                                  ],
                       'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) 
                 ?>

                    <?= $content ?>
            </div>
        </div>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Universidad de Cartagena - <?= date('Y') ?></p>

        <p class="pull-right">Proyecto Académico</p>
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

