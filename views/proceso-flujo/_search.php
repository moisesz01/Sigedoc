<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProcesoFlujoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proceso-flujo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'usuario_idusuario') ?>

    <?= $form->field($model, 'actividad_idactividad') ?>

    <?= $form->field($model, 'proceso_id') ?>

    <?= $form->field($model, 'flujo_idflujo') ?>

    <?php // echo $form->field($model, 'pf_orden') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
