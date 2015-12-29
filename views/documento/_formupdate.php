

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use app\models\Requerimiento;
use app\models\User;

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
    <?= $this->render('_camposupdate', [
            'campos'=>$campos,
    ]) ?>
    

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
                echo Html::hiddenInput('recaudos[]',$recaudo->iddocumentodigital,['class'=>'idrecaudo']);
                echo Html::hiddenInput('nombre_recaudo[]',$Requerimiento->re_nombre,['class'=>'nombre_recaudo']);
                echo Html::hiddenInput('descripcion_recaudo[]',$Requerimiento->re_descripcion,['class'=>'descripcion_recaudo']);
                ?> 
              </td>
              <td>
                <?= $recaudo->dd_nombre;?>  
              </td>
              <td>
                <?= Html::a('<span class="glyphicon glyphicon-download-alt"></span> Descargar', ['/documento/descargar','id'=>$recaudo->iddocumentodigital], ['class'=>'btn btn-warning']) ?>
                <?= Html::button('<span class="glyphicon glyphicon-pencil"></span> Editar', ['class'=>'btn btn-warning editar']) ?>    
              </td>
              
            </tr>
        <?php endforeach;?>
    </table>
    <div class="adjuntos">
      
    </div>
     <?php if($observaciones):?>
    <h2>Observaciones</h2>
    
    <table class="table table-striped table-bordered" style="text-align:center;">
        <tr>
          <td><strong>Usuario</strong></td>
          <td><strong>Comentario</strong></td>
          
          
        </tr>
         <?php foreach ($observaciones as $observacion):?>
            <tr>
              <td>
              <?php                
                $user = User::find()->where(['id'=>$observacion['usuario']])->one();
                echo $user->username;
              ?>
                
              </td>
              <td>
                <?= $observacion['observacion']?>
              </td>
              
              
            </tr>
        <?php endforeach;?>
    </table>
   <?php endif;?> 
   <div class="clear">
    <fieldset>
    <legend>Agregar Observación</legend>
        <?= $form->field($modelObservacion, 'ob_observacion')->textarea(['rows' => 4]) ?>
        <?= Html::hiddenInput ('aprobar','aprobar',[]); ?>
    </fieldset>
   </div>
   


 <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">

$('.editar').on('click', function(event){
    var id_recaudo;
    var nombre_recaudo;
    var descripcion_recaudo;

    $(this).closest('tr').find("input.idrecaudo").each(function() {
        id_recaudo=this.value;
    });
    $(this).closest('tr').find("input.nombre_recaudo").each(function() {
        nombre_recaudo=this.value;
    });
    $(this).closest('tr').find("input.descripcion_recaudo").each(function() {
        descripcion_recaudo=this.value;
    });

    var tabla = "<div class='tabla'>";
    tabla+="<h2>Adjuntar Recaudos Actualizados</h2>"
    tabla+="<table class='table table-striped table-bordered' id='lista' style='text-align:center;'>"
    tabla+="<tr>";
      tabla+="<td>";
        tabla+="<strong>";
          tabla+="Requerimiento";
        tabla+="</strong>";
      tabla+="</td>";
      tabla+="<td>";
        tabla+="<strong>";
          tabla+="Descripción del Requerimiento";
        tabla+="</strong>";
      tabla+="</td>";
      tabla+="<td>";

        tabla+="<strong>";
          tabla+="Archivo Adjunto";
        tabla+="</strong>";
      tabla+="</td>";
    tabla+="</tr>";
    tabla+="</table>";
    tabla+="</div>";

    var trnew ="<tr>";
      trnew +="<td>";
        trnew +=nombre_recaudo;
      trnew +="</td>";
      trnew +="<td>";
        trnew +=descripcion_recaudo;
      trnew +="</td>";
      trnew +="<td>";
        trnew +="<input type='hidden' name='idrecaudo[]'  value='"+id_recaudo+"'>";
        trnew +="<input type='file' name='recaudo[]' value='' placeholder='' required>";    
      trnew +="</td>";
      trnew +="</tr>";
    
    if (!$('.tabla').length) {
      $('.adjuntos').append(tabla);
    }
    $('#lista').append(trnew);

    var tr = $(this).closest('tr');
    tr.fadeOut(400, function(){
        tr.remove();
    });
    return false;

})
  
  
</script>

