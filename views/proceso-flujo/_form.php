<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Proceso;
use app\models\Flujo;
use app\models\Actividad;
use app\models\User;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model app\models\ProcesoFlujo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proceso-flujo-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'proceso_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Proceso::find()->all(),'id','pr_nombre'),
                'language' => 'es',
                'options' => ['placeholder' => 'Seleccione Proceso'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'flujo_idflujo')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Flujo::find()->all(),'idflujo','fl_nombre'),
                'language' => 'es',
                'options' => ['placeholder' => 'Seleccione Flujo'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);?>  
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'actividad_idactividad')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Actividad::find()->all(),'idactividad','ac_nombre'),
                'language' => 'es',
                'options' => ['placeholder' => 'Seleccione Flujo'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);?>   
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'usuario_idusuario')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(User::find()->all(),'id','username'),
                'language' => 'es',
                'options' => ['placeholder' => 'Seleccione Flujo'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);?>     
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'pf_orden')->textInput() ?>            
        </div>

    </div>
    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 20, // the maximum times, an element can be added (default 999)
        'min' => 0, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelsRequerimiento[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            're_nombre',
            're_descripcion',
            're_obligatorio',
        ],
    ]); ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>
                <i class="glyphicon glyphicon-envelope"></i> Requerimientos
                <button type="button" class="add-item btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Agregar</button>
            </h4>
        </div>
        <div class="panel-body">
            <div class="container-items"><!-- widgetBody -->
            <?php foreach ($modelsRequerimiento as $i => $modelRequerimiento): ?>
                <div class="item panel panel-default"><!-- widgetItem -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Requerimiento:</h3>
                        <div class="pull-right">
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelRequerimiento->isNewRecord) {
                                echo Html::activeHiddenInput($modelRequerimiento, "[{$i}]id");
                            }
                        ?>
                        <div class="row">
                            <div class="col-sm-5">
                                <?= $form->field($modelRequerimiento, "[{$i}]re_nombre")->textInput(['maxlength' => true]) ?>        
                            </div>
                            <div class="col-sm-5">
                                <?= $form->field($modelRequerimiento, "[{$i}]re_descripcion")->textInput(['maxlength' => true]) ?>        
                            </div>
                            <div class="col-sm-2" style="padding-top:30px;">
                                <?= $form->field($modelRequerimiento, "[{$i}]re_obligatorio")->checkbox() ?> 
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div><!-- .panel -->
    <?php DynamicFormWidget::end(); ?>

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
