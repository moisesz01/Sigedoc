<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Requerimiento;
use app\models\User;
use app\models\DocumentoFlujo;
use app\models\ProcesoFlujo;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Documento */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Procesar';
?>
<div class="documento-view">

    <h1>Datos del Documento</h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'iddocumento',
            'do_referencia',
            'proceso_id',
            'do_nombre',
            'do_descripcion:ntext',
        ],
    ]) ?>

    <h2>Campos del Documento</h2>

    <div class="row">
    <?php foreach ($campos as $campo):?>
        <div class="col-sm-4">
            <?= Html::label($campo['campo'],"",['class'=>'control-label']); ?>
            <?= Html::input('text', 'DOCUMENTO[field][]',$campo['respuesta'],['readonly'=>true,'class'=>'form-control']); ?>    
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
         <?php foreach ($Recaudos as $recaudo):?>
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
   <fieldset>
    <legend>Agregar Observación</legend>
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($modelObservacion, 'ob_observacion')->textarea(['rows' => 4]) ?>

        <?php 
            $id = Yii::$app->getRequest()->getQueryParam('id');

            $docFlujo = DocumentoFlujo::find()->where(['do_estado'=>'a','documento_iddocumento'=>$id])->one();
            $idProcesoFlujo = $docFlujo->proceso_flujo_id;
            $ProcesoFlujo = ProcesoFlujo::find()->where(['id'=>$idProcesoFlujo])->one();
            $orden = $ProcesoFlujo->pf_orden;
            if($orden==0):
        ?>
        <?= Html::hiddenInput ('flujoIni','flujoIni',[]); ?>

        <?else:?>
            <?= Html::checkbox ('aprobar', $checked = false, $options = [] );?>
            <?= Html::label(" Aprobar","",['class'=>'control-label']);?>
        <?endif;?>
        
        <div class="form-group" style="padding-top:20px;">
             <?= Html::submitButton ( 'Aceptar', ['class'=>'btn btn-success'] ); ?> 
        </div>

        <?php ActiveForm::end(); ?>
                
               
                
    </fieldset>
    
  
    
</div>

