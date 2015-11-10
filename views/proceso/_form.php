<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Proceso */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proceso-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pr_referencia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pr_nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pr_descripcion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'pr_aprobacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pr_directorio')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
