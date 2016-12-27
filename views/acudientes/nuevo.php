<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Parentesco;

/* @var $this yii\web\View */
/* @var $model app\models\forms\FormNuevoAcudiente */
/* @var $form ActiveForm */
?>
<div class="acudientes-nuevo">

    <?php $form = ActiveForm::begin([
        'id' => $model->formName(), 
        'action' => ['acudientes/nuevo-acudiente'],
    ]); ?>
        <?= $form->field($model, 'id_estudiante')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'parentesco')->dropDownList(ArrayHelper::map(Parentesco::find()->orderBy('id_parentesco')->all(), 'id_parentesco', 'nombre'))?>
        <?= $form->field($model, 'nombres') ?>
        <?= $form->field($model, 'apellidos') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'telefono') ?>
    <?php ActiveForm::end(); ?>

</div><!-- acudientes-nuevo -->

<?php
$js = <<<JS
$('body').on('beforeSubmit', 'form#{$model->formName()}', function () {
    var form = $(this);
 
    if (form.find('.has-error').length) {
        return false;
    }
    $.post(
        form.attr('action'),
        form.serialize()    
    ).done(function(response){
        
        if(response.result)
        {
            form.parents('.modal').modal('hide');
            location.reload();
        }
        else{
            mostrarError(response.message);
        }

    }).fail( function(){
        mostrarError('Ocurrió un error procesando la solicitud');
    });
    return false;
})
JS;
 
$this->registerJs($js);

?>