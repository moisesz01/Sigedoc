<? 
	use yii\helpers\Html;
	use yii\helpers\ArrayHelper;
?>

<h2>Requerimientos Obligatorios</h2>

    <table class="table table-striped table-bordered" style="text-align:center;">
        <tr>
          <td><strong>Requerimiento</strong></td>
          <td><strong>Descripción del Requerimiento</strong></td>
          <td><strong>Archivo Adjunto </strong></td>
          
        </tr>
        <?php $recaudos = array(); ?>
         <?php foreach ($requerimientos as $requerimiento):?>
         	<?php if($requerimiento['re_obligatorio']==1): ?>
         	
            <tr>
              <td>
              	<?=$requerimiento['re_nombre']?>
              </td>
              <td>
              	<?=$requerimiento['re_descripcion']?>
              </td>
              <td>	
	  			<?= Html::hiddenInput ("RequerimientoID[]",$requerimiento['id'],[]);?>
	  			<?= Html::fileInput('Requerimiento[]','',['required' => true]);?>	
              </td>
              
            </tr>
        <?php else:?>
        	<?php $recaudos[]= array('id'=>$requerimiento['id'],'recaudo'=>$requerimiento['re_nombre']);?>
        <?php endif;?>

        <?php endforeach;?>
    </table>
<?php if($recaudos):?>
<?php $listData=ArrayHelper::map($recaudos,'id','recaudo');?>

<h2>Requerimientos Opcionales</h2>
<div class="row" style="padding-top:30px;">
	<div class="col-sm-3">
		<?= Html::dropDownList("name","select",$listData, ['prompt'=>'Seleccione un Requerimiento','id'=>'select_recaudos','class'=>'form-control']);?>	
	</div>
	<div class="col-sm-4" >
		<?= Html::button ('<span class="glyphicon glyphicon-plus"></span> Agregar Requerimiento',['id'=>'boton','class'=>'btn btn-success']);?>		
	</div>
</div>
<div class="row" style="padding-top:20px;" >
	<table class="table table-striped table-bordered" style="text-align:center;" id="lista">
        <tr>
          <td><strong>Requerimiento</strong></td>
          <td><strong>Archivo Adjunto</strong></td>
          <td><strong>Operación </strong></td>
          
        </tr>        
	</table>	
</div>

<?endif;?>


<script type="text/javascript">
	
	$("#boton").on('click', function () {




			var recaudo = $("#select_recaudos").val();
			var recaudo_text = $("#select_recaudos option:selected").text();
			
			var tr="";

			tr+="<tr>";
			tr+="<input type='hidden' name='RequerimientoID[]'  value='"+recaudo+"'>";
			tr+="<td>";
			tr+=""+recaudo_text+"";

			tr+="</td>";

			tr+="<td style='padding-left:200px;'>";
			tr+="<input type='file' name='Requerimiento[]' value='' placeholder='' required>";

			tr+="</td>";

			tr+="<td>";
			tr+="<input type='button' value='Eliminar' data-id='"+recaudo+"' data-name='"+recaudo_text+"' class='btn btn-danger delete'>";

			tr+="</td>";

			tr+="</tr>";
			

			if(recaudo != "" ){

			$('#lista').append(tr);
			$("#select_recaudos option[value='"+recaudo+"']").remove();
			 
			$("#select_recaudos").val(0);
			}
			
		});
		$('#lista').on('click', '.delete', function(event) {
			var id = $(this).data('id');
			var name = $(this).data('name');
			$("#select_recaudos").append('<option value="'+id+'">'+name+'</option>');

			$(this).closest('tr').remove();
		});
</script>


