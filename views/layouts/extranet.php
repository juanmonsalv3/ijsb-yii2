<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

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
    NavBar::end();
    ?>

    <div class="container">
        <div id="notify-wrap"></div>
        <div class="row">
            
            <div class="col-sm-offset-3 col-sm-6">

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
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

<script>
    $(document).ready(function(){
        <?php if(Yii::$app->session->hasFlash('error')):  ?>
            $('#notify-wrap').notify({ text: '<?= Yii::$app->session->getFlash('error') ?>', state: 'ui-state-error', timeout: 3000 });
        <?php endif ?>
        <?php if(Yii::$app->session->hasFlash('mensaje')):  ?>
            $('#notify-wrap').notify({ text: '<?= Yii::$app->session->getFlash('mensaje') ?>', state: 'ui-state-success', timeout: 3000 });
        <?php endif ?>
    });
</script>

