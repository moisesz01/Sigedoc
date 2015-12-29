<?php 
  use yii\helpers\Html;
  use yii\widgets\ActiveForm;
  use app\models\Proceso;
  use kartik\select2\Select2;
  use yii\helpers\ArrayHelper;
  use kartik\date\DatePicker;
  use yii\bootstrap\Modal;
?>


<div class="clear">
<fieldset>
    <legend>Reporte de Productividad</legend>
    <div class="productividad-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
      <div class="col-sm-4">
        <?= $form->field($modelProductividad, 'idproceso')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Proceso::find()->all(),'id','pr_nombre'),
                'language' => 'es',
                'options' => ['placeholder' => 'Seleccione Proceso'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
        ]);?>
      </div>
      <div class="col-sm-4">
        <?=$form->field($modelProductividad, 'fechaini')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Introduzca Fecha Inicial ...'],
            'pluginOptions' => [
                'autoclose'=>true
            ]
        ]);?>
      </div>
      <div class="col-sm-4">
        <?=$form->field($modelProductividad, 'fechafin')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Introduzca Fecha Final ...'],
            'pluginOptions' => [
                'autoclose'=>true
            ]
        ]);?>
      </div>

    </div>
    <div class="form-group">
        <?= Html::submitButton('Crear', ['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

  </div>
  <?php if(isset($mensaje)){

      echo $mensaje;
    }?>

    <table class="table table-striped table-bordered" style="text-align:center;">
        <tr>
          <td><strong>Referencia del Documento</strong></td>
          <td><strong>Nombre del Documento</strong></td>
          <td><strong>Descripción del Documento</strong></td>
          <td><strong>Duración del documento</strong></td>
          
          
        </tr>
        <?php if(isset($BuzonDocumento)):?>
         <?php foreach ($BuzonDocumento as $buzon):?>
            <tr>
              <td>
                
                    
              </td>
              <td>
                
              </td>
              <td>
                
              </td>
              <td>
                
              </td>
              <td>
                
              </td>
             
              
            </tr>
        <?php endforeach;?>
      <?php endif;?>
    </table>
    
    </fieldset>
</div>
<?php 
  
?>
