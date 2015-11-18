<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Flujo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="flujo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fl_nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fl_descripcion')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
