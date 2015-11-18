<?php 
	use yii\helpers\Html;
	use app\models\Tipo;
	use app\models\Opcion;
	use yii\helpers\ArrayHelper;
?>
<div class="row">
<?php foreach ($campos as $campo):?>
	<div class="col-sm-4">
	<?php
		echo Html::hiddenInput ("DOCUMENTO[field_id][]",$campo['id'],[]);
		echo Html::label($campo['ca_nombre'],"",['class'=>'control-label']);

		switch ($campo['tipo_id']) {
		   
		    case 1:

		        if($campo['ca_obligatorio']==1)
	    			echo Html::input('text', 'DOCUMENTO[field][]','',['required'=>'','class'=>'form-control']);
	    		else
	    			echo Html::input("text", "DOCUMENTO[field][]","",['class'=>'form-control']);
		        break;

		    case 2:
		        
		        $opciones = Opcion::find()->where(['tipo_id'=>$campo['tipo_id']])->all();
	    		$listData=ArrayHelper::map($opciones,'id','op_nombre');
	    		if($campo['ca_obligatorio']==1)
	    			echo Html::dropDownList("DOCUMENTO[field][]","",$listData, ['prompt'=>'Seleccione Estado Civil','required','class'=>'form-control'] );
	    		else
	    			echo Html::dropDownList("DOCUMENTO[field][]","",$listData, ['prompt'=>'Seleccione Estado Civil','class'=>'form-control'] );

		        break;

		     case 3:
		    	
	    		$opciones = Opcion::find()->where(['tipo_id'=>$campo['tipo_id']])->all();
	    		$listData=ArrayHelper::map($opciones,'id','op_nombre');
	    		if($campo['ca_obligatorio']==1)
	    			echo Html::dropDownList("DOCUMENTO[field][]","",$listData, ['prompt'=>'Seleccione Tipo Documento','required','class'=>'form-control'] );
	    		else
	    			echo Html::dropDownList("DOCUMENTO[field][]","",$listData, ['prompt'=>'Seleccione Tipo Documento','class'=>'form-control'] );

		        break;

		    case 4:

		        if($campo['ca_obligatorio']==1)
	    			echo Html::input("number", "DOCUMENTO[field][]","",['class'=>'form-control','required']);
	    		else
	    			echo Html::input("number", "DOCUMENTO[field][]","",['class'=>'form-control']);
		        
		        break;

		    case 5:

		        $opciones = Opcion::find()->where(['tipo_id'=>$campo['tipo_id']])->all();
	    		$listData=ArrayHelper::map($opciones,'id','op_nombre');
	    		if($campo['ca_obligatorio']==1)
	    			echo Html::dropDownList("DOCUMENTO[field][]","",$listData, ['prompt'=>'Seleccione Digito','required','class'=>'form-control'] );
	    		else
	    			echo Html::dropDownList("DOCUMENTO[field][]","",$listData, ['prompt'=>'Seleccione Digito','class'=>'form-control'] );

		        break;

		    case 6:
		        
		        $opciones = Opcion::find()->where(['tipo_id'=>$campo['tipo_id']])->all();
	    		$listData=ArrayHelper::map($opciones,'id','op_nombre');
	    		if($campo['ca_obligatorio']==1)
	    			echo Html::dropDownList("DOCUMENTO[field][]","",$listData, ['prompt'=>'Seleccione Sexo','required','class'=>'form-control'] );
	    		else
	    			echo Html::dropDownList("DOCUMENTO[field][]","",$listData, ['prompt'=>'Seleccione Sexo','class'=>'form-control'] );

		        break;

		    case 7:

		        if($campo['ca_obligatorio']==1)
	    			echo Html::input("date", "DOCUMENTO[field][]","",['class'=>'form-control','required']);
	    		else
	    			echo Html::input("date", "DOCUMENTO[field][]","",['class'=>'form-control']);
		        
		        break;

		}


	?>	
	
	
		<?="<br>";?>
		

	</div>

<?php endforeach;?>
</div>
e

