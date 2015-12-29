<?php 
	use yii\helpers\Html;
	use app\models\Tipo;
	use app\models\Opcion;
	use yii\helpers\ArrayHelper;
	use yii\jui\DatePicker;
	use yii\db\Query;
?>
<div class="row">
<?php foreach ($campos as $campo):?>
	<div class="col-sm-4">
	<?php
		echo Html::hiddenInput('DOCUMENTO[field_resp][]',$campo['idrespuesta'],'');
		echo Html::hiddenInput ("DOCUMENTO[field_id][]",$campo['id'],[]);
		echo Html::label($campo['ca_nombre'],"",['class'=>'control-label']);

		switch ($campo['tipo_id']) {
		   
		    case 1:
		    	
		        if($campo['ca_obligatorio']==1)
	    			echo Html::input('text', 'DOCUMENTO[field][]',$campo['respuesta'],['required' => true,'class'=>'form-control']);
	    		else
	    			echo Html::input("text", "DOCUMENTO[field][]",$campo['respuesta'],['class'=>'form-control']);
		        break;

		    case 2:
		        
		        $opciones = Opcion::find()->where(['tipo_id'=>$campo['tipo_id']])->all();
	    		$listData=ArrayHelper::map($opciones,'id','op_nombre');
	    		$defaultOpcion = Opcion::find()->where(['op_nombre'=>$campo['respuesta']])->one();
	    		if($campo['ca_obligatorio']==1)
	    			echo Html::dropDownList("DOCUMENTO[field][]",$defaultOpcion->id,$listData, ['prompt'=>'Seleccione Estado Civil','required' => true,'class'=>'form-control'] );
	    		else
	    			echo Html::dropDownList("DOCUMENTO[field][]",$defaultOpcion->id,$listData, ['prompt'=>'Seleccione Estado Civil','class'=>'form-control'] );

		        break;

		     case 3://tipo de documento
		    	
	    		$opciones = Opcion::find()->where(['tipo_id'=>$campo['tipo_id']])->all();
	    		$listData=ArrayHelper::map($opciones,'id','op_nombre');
	    		$defaultOpcion = Opcion::find()->where(['op_nombre'=>$campo['respuesta']])->one();

	    		if($campo['ca_obligatorio']==1)
	    			echo Html::dropDownList("DOCUMENTO[field][]",$defaultOpcion->id,$listData, ['required' => true,'class'=>'form-control','options'=>['E'=>['selected'=>'selected']]] );
	    		else
	    			echo Html::dropDownList("DOCUMENTO[field][]",$defaultOpcion->id,$listData, ['class'=>'form-control','options'=>['E'=>['selected'=>'selected']]]);

		        break;

		    case 4:

		        if($campo['ca_obligatorio']==1)
	    			echo Html::input("number", "DOCUMENTO[field][]",$campo['respuesta'],['class'=>'form-control','required' => true]);
	    		else
	    			echo Html::input("number", "DOCUMENTO[field][]",$campo['respuesta'],['class'=>'form-control']);
		        
		        break;

		    case 5:

		        $opciones = Opcion::find()->where(['tipo_id'=>$campo['tipo_id']])->all();
	    		$listData=ArrayHelper::map($opciones,'id','op_nombre');
	    		$defaultOpcion = Opcion::find()->where(['op_nombre'=>$campo['respuesta']])->one();
	    		if($campo['ca_obligatorio']==1)
	    			echo Html::dropDownList("DOCUMENTO[field][]",$defaultOpcion->id,$listData, ['required' => true,'class'=>'form-control'] );
	    		else
	    			echo Html::dropDownList("DOCUMENTO[field][]",$defaultOpcion->id,$listData, ['class'=>'form-control'] );

		        break;

		    case 6:
		        
		        $opciones = Opcion::find()->where(['tipo_id'=>$campo['tipo_id']])->all();
	    		$listData=ArrayHelper::map($opciones,'id','op_nombre');
	    		$defaultOpcion = Opcion::find()->where(['op_nombre'=>$campo['respuesta']])->one();
	    		if($campo['ca_obligatorio']==1)
	    			echo Html::dropDownList("DOCUMENTO[field][]",$defaultOpcion->id,$listData, ['prompt'=>'Seleccione Sexo','required' => true,'class'=>'form-control'] );
	    		else
	    			echo Html::dropDownList("DOCUMENTO[field][]",$defaultOpcion->id,$listData, ['prompt'=>'Seleccione Sexo','class'=>'form-control'] );

		        break;

		    case 7:

		        if($campo['ca_obligatorio']==1){
		        	echo DatePicker::widget([
					    'name'  => 'DOCUMENTO[field][]',
					    
					    'language' => 'es',
					    'dateFormat' => 'yyyy-MM-dd',
					    'value'=>$campo['respuesta'],
					    'options'=>[
					    	'class'=>'form-control fecha',
					    	'required' => true,
					    ],
					    'clientOptions' => [
						    'changeYear' => true,
						    'changeMonth' => true,
						    'yearRange' => '1900:2099',
						],
					]);

		        }	    			
	    		else{
	    			echo DatePicker::widget([
					    'name'  => 'DOCUMENTO[field][]',					    
					    'language' => 'es',
					    'dateFormat' => 'yyyy-MM-dd',
					    'changeYear' => true,
					    'value'=>$campo['respuesta'],
					    'clientOptions' => [
							'changeYear' => true,
						    'changeMonth' => true,
						    'yearRange' => '1900:2099',
						],
						'options'=>[
					    	'class'=>'form-control fecha',
					    ],
					]);		        
		        
	    		}
	    		break;

		}


	?>	
	
	
		<?="<br>";?>
		

	</div>

<?php endforeach;?>
</div>
