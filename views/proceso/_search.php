<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProcesoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proceso-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'pr_referencia') ?>

    <?= $form->field($model, 'pr_nombre') ?>

    <?= $form->field($model, 'pr_descripcion') ?>

    <?= $form->field($model, 'pr_aprobacion') ?>

    <?php // echo $form->field($model, 'pr_directorio') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
