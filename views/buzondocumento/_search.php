<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BuzondocumentoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="buzondocumento-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idbuzondocumento') ?>

    <?= $form->field($model, 'bd_fechaentrada') ?>

    <?= $form->field($model, 'bd_fechasalida') ?>

    <?= $form->field($model, 'bd_estado') ?>

    <?= $form->field($model, 'bd_userorigen') ?>

    <?php // echo $form->field($model, 'bd_userdestino') ?>

    <?php // echo $form->field($model, 'documento_iddocumento') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
