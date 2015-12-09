<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use app\models\Requerimiento;


/* @var $this yii\web\View */
/* @var $model app\models\Documento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="documento-form">
	
    <?php $form = ActiveForm::begin([
	    'id' => 'documento-form',
	    'options' => ['enctype'=>'multipart/form-data']
	    //'enableClientValidation' => true,
	    //'enableAjaxValidation' => false, 
	]);?>
    
    <div class="row">
    	<div class="col-sm-6">
    		<?= $form->field($model, 'do_referencia')->textInput(['maxlength' => true]) ?>		
    	</div>
    	<div class="col-sm-6">
    		<?= $form->field($model, 'do_nombre')->textInput(['maxlength' => true]) ?>		
    	</div>
    </div>
    <?= $form->field($model, 'do_descripcion')->textarea(['rows' => 3]) ?>
   
    <div class="campos">
    	
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<h2>Campos del Documento</h2>

    <div class="row">
    <?php foreach ($campos as $campo):?>
        <div class="col-sm-4">
            <?= Html::label($campo['campo'],"",['class'=>'control-label']); ?>
            <?= Html::input('text', 'DOCUMENTO[field][]',$campo['respuesta'],['class'=>'form-control']); ?>    
        </div>
    <?php endforeach; ?>
    </div>
    <h2>Recaudos</h2>



    <table class="table table-striped table-bordered" style="text-align:center;">
        <tr>
          <td><strong>Requerimiento</strong></td>
          <td><strong>Archivo</strong></td>
          <td><strong>Acción</strong></td>
          
        </tr>
         <?php foreach ($recaudos as $recaudo):?>
            <tr>
              <td>
                <?php 
                $Requerimiento = Requerimiento::find()->where(['id'=>$recaudo->requerimiento_id])->one();
                echo $Requerimiento->re_nombre;
                ?> 
              </td>
              <td>
                <?= $recaudo->dd_nombre;?>  
              </td>
              <td>
                <?= Html::a(' <span class="glyphicon glyphicon-download-alt"></span> Descargar', ['/documento/descargar','id'=>$recaudo->iddocumentodigital], ['class'=>'btn btn-warning']) ?>    
              </td>
              
            </tr>
        <?php endforeach;?>
    </table>


