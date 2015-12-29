<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Requerimiento;
use yii\jui\Tabs;

/* @var $this yii\web\View */
/* @var $model app\models\Documento */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Flujo de Documento', 'url' => ['flujo']];
$this->params['breadcrumbs'][] = $model->iddocumento;
?>
<div class="documento-view">
	<h1>Flujo del documento: <?=$model->iddocumento?></h1>
	<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'do_referencia',
            'do_nombre',
            'do_descripcion:ntext',
        ],
    ]) ?>
</div>
<div class="clear">
<fieldset>
    <legend>Estado del documento</legend>

      <?php $estado= $flujo->do_estado;
        if($estado=='f'):
      ?>
        <p><span class="glyphicon glyphicon-ok"></span><strong> El Documento se encuentra procesado </strong></p>
      <?php else:?>                 
        <p><span class="glyphicon glyphicon-sort"></span><strong> El Documento se encuentra en transito </strong></p>
      <?php endif;?>
    <p><span class="glyphicon glyphicon-info-sign"></span> El transitar del documento se puede verificar en la pestaña <strong>Transitar del Documento.</strong></p>
    <p><span class="glyphicon glyphicon-info-sign"></span> El flujo del documento a través del cual debe transitar se puede ver en la pestaña <strong>Flujo del Documento.</strong></p>
    </fieldset>
</div>



<?php 
	$content1 = '<table class="table table-striped table-bordered" style="text-align:center;">
        <tr>
          <td><strong>Proceso</strong></td>
          <td><strong>Flujo</strong></td>
          <td><strong>Actividad</strong></td>
          <td><strong>Usuario</strong></td>
          <td><strong>Fecha de Entrada</strong></td>
          <td><strong>Fecha de Salida</strong></td>
          <td><strong>Duración</strong></td>
          
        </tr>';
     foreach ($DocumentoFlujo as $documento){
     	$content1 .='<tr>';

     	$content1 .='<td>';
		$content1 .= $documento['proceso'];
		$content1 .='</td>';

		$content1 .='<td>';
		$content1 .= $documento['flujo'];
		$content1 .='</td>';

		$content1 .='<td>';
		$content1 .= $documento['actividad'];
		$content1 .='</td>';

    $content1 .='<td>';
    $content1 .= $documento['usuario'];
    $content1 .='</td>';

		

   	$content1 .='<td>';
   	$content1 .= $documento['fechaini'];//$documento['do_fechaini'];
   	$content1 .='</td>';

		$content1 .='<td>';
		$content1 .= $documento['fechafin'];//$documento['do_fecha_fin'];
		$content1 .='</td>';

		$content1 .='<td>';
    $connection = Yii::$app->getDb();
    
    if($documento['fechafin']){
      $sql="select retornarminutos('".$documento['fechaini']."','".$documento['fechafin']."') AS duracion";
      $command = $connection->createCommand($sql);
      $result = $command->queryOne();
      $content1 .= $result['duracion'].' Min.';
    }else{
      $content1 .= '';
    }
		$content1 .='</td>';

     	$content1 .='<tr>';

    }
	 $content1 .='</table>';

?>
<?php 
  
  $idFlujo = $flujo->proceso_flujo_id;
  $content2 = '<table class="table table-striped table-bordered" style="text-align:center;">
        <tr>
          <td><strong>Proceso</strong></td>
          <td><strong>Flujo</strong></td>
          <td><strong>Actividad</strong></td>
          <td><strong>Usuario</strong></td>
          
        </tr>';

    foreach ($transitar as $documento){

        if($documento['id']==$idFlujo){
          $content2 .='<tr style="border-style: solid;border-color: #F39C12 #F39C12;">';
        }
        else{
          $content2 .='<tr>';
        }
        $content2 .='<td>';
        $content2 .= $documento['proceso'];
        $content2 .='</td>';

        $content2 .='<td>';
        $content2 .= $documento['flujo'];
        $content2 .='</td>';

        $content2 .='<td>';
        $content2 .= $documento['actividad'];
        $content2 .='</td>';

        $content2 .='<td>';
       
        $content2 .= $documento['usuario'];  
        
        $content2 .='</td>';

      $content2 .='<tr>';

    }
   $content2 .='</table>';

?>

<?= Tabs::widget([
    'items' => [
        [
            'label' => 'Transitar del Documento',
            'content' => $content1,
        ],
        [
            'label' => 'Flujo del Documento',
            'content' => $content2,
           // 'options' => ['tag' => 'div'],
            //'headerOptions' => ['class' => 'my-class'],
        ],
        
    ],
    //'options' => ['tag' => 'div'],
    //'itemOptions' => ['tag' => 'div'],
   // 'headerOptions' => ['class' => 'my-class'],
    //'clientOptions' => ['collapsible' => false],
]);
?>


        


