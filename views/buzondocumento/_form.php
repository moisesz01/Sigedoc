<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Buzondocumento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="buzondocumento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'bd_fechaentrada')->textInput() ?>

    <?= $form->field($model, 'bd_fechasalida')->textInput() ?>

    <?= $form->field($model, 'bd_estado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bd_userorigen')->textInput() ?>

    <?= $form->field($model, 'bd_userdestino')->textInput() ?>

    <?= $form->field($model, 'documento_iddocumento')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
