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

<?php 
	$content1 = '<table class="table table-striped table-bordered" style="text-align:center;">
        <tr>
          <td><strong>Proceso</strong></td>
          <td><strong>Flujo</strong></td>
          <td><strong>Usuario</strong></td>
          <td><strong>Orden</strong></td>
          <td><strong>Fecha de Entrada</strong></td>
          <td><strong>Fecha de Salida</strong></td>
          <td><strong>Duración</strong></td>
          
        </tr>';
     foreach ($DocumentoFlujo as $documento){
     	$content1 .='<tr>';

     	$content1 .='<td>';
		$content1 .= $documento['proceso_flujo_id'];
		$content1 .='</td>';

		$content1 .='<td>';
		$content1 .= $documento['proceso_flujo_id'];
		$content1 .='</td>';

		$content1 .='<td>';
		$content1 .= $documento['usuario_idusuario'];
		$content1 .='</td>';

		$content1 .='<td>';
		$content1 .= $documento['proceso_flujo_id'];
		$content1 .='</td>';

     	$content1 .='<td>';
     	$content1 .= $documento['do_fechaini'];
     	$content1 .='</td>';

		$content1 .='<td>';
		$content1 .= $documento['do_fecha_fin'];
		$content1 .='</td>';

		$content1 .='<td>';
		$content1 .= 'tales minutos';
		$content1 .='</td>';

     	$content1 .='<tr>';

     }
	 $content1 .='</table>';

?>

<?php $contenido="esto es una fockinh mierda!!!"; ?>
<?= Tabs::widget([
    'items' => [
        [
            'label' => 'Estado del Documento',
            'content' => $content1,
        ],
        [
            'label' => 'Flujo del Documento',
            'content' => 'Sed non urna. Phasellus eu ligula. Vestibulum sit amet purus...',
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


        


<?php 
	foreach ($DocumentoFlujo as $key => $documento) {
		
		echo $documento['do_fechaini'].' '.$documento['do_fecha_fin'].' '.$documento['usuario_idusuario'].' '.$documento['documento_iddocumento'];
		echo "<br>";
	}
?>