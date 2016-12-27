<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap\NavBar;
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
       
        'brandLabel' =>  Html::img('@web/images/logo.png', ['alt'=>Yii::$app->name, 'class'=>'img-logo'])." ".Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    
    NavBar::end();
    ?>

    <div class="container">
        <div id="notify-wrap"></div>
        <div class="row">
            <div class="col-md-3 side-left">
                <!-- left -->
                <div class="navside-left">
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle perfil-actions" type="button" data-toggle="dropdown">
                          <?=Yii::$app->user->identity->nombres?>
                          <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu drop-perfil-actions">
                          <li><a href="<?=Url::toRoute(["usuarios/mi-perfil"])?>">Mi Perfil</a></li>
                          <li role="separator" class="divider"></li>
                          <li><a href="<?=Url::toRoute(["usuarios/logout"])?>">Cerrar Sesión</a></li>
                        </ul>
                    </div>
                </div>
                <br/>
                <div class="list-group">
                    <a href="<?=Url::toRoute(["acudiente/seleccionar"])?>" class="list-group-item">Estudiantes</a>
                </div>
                <hr/>

            </div><!-- /span-3 -->
            <div class="col-sm-12 col-md-9 content">

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

