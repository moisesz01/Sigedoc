<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;


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
    <?=$form->field($model, 'proceso_id')->dropDownList(
        ArrayHelper::map($procesos,'id','pr_nombre'),
        ['prompt'=>'Seleccione Tipo...','onChange'=>"prueba()"]); 
    ?>
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

<script type="text/javascript">
function prueba () {
	$.ajax({
       url: '<?php echo Yii::$app->request->baseUrl. '/documento/getcampos' ?>',
       type: 'post',
       data: {idproceso: $("#documento-proceso_id").val()},
       success: function (data) {
       		$(".campos").empty();
       		$(".campos").append(data);	
       		if ($(".hasDatepicker")[0]){
            
    				$(".fecha").removeClass('hasDatepicker').datepicker({"changeYear":true,"changeMonth":true,"yearRange":"1900:2099","dateFormat":"yy-mm-dd"});

    			}
       		
       }
    });
}
	

</script>
