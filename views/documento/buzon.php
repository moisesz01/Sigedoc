<?php
    use yii\helpers\Html;
    use yii\grid\GridView;
    use app\models\Documento;
    use app\models\DocumentoFlujo;
    use app\models\ProcesoFlujo;
    use yii\widgets\LinkPager;
?>
<?php $this->title = ''; ?>
<div class="clear">
<fieldset>
    <legend>Buzón de Documento</legend>
    <table class="table table-striped table-bordered" style="text-align:center;">
        <tr>
          <td><strong>Referencia del Documento</strong></td>
          <td><strong>Nombre del Documento</strong></td>
          <td><strong>Descripción del Documento</strong></td>
          <td><strong>Fecha de Entrada</strong></td>
          <td><strong>Operación</strong></td>
          
        </tr>
         <?php foreach ($BuzonDocumento as $buzon):?>
            <tr>
              <td>
                <?php 
                    $documento = Documento::find()->where(['iddocumento'=>$buzon->documento_iddocumento])->one();  
                    echo $documento->do_referencia;                           
                    
                ?> 
                    
              </td>
              <td>
                <?= $documento->do_nombre; ?>
              </td>
              <td>
                <?= $documento->do_descripcion; ?>
              </td>
              <td>
                  <small><i class="fa fa-clock-o"></i> <?= $buzon->bd_fechaentrada; ?></small>
              </td>
              <td>
                <?php
                    $docFlujo = DocumentoFlujo::find()->where(['do_estado'=>'a','documento_iddocumento'=>$documento->iddocumento])->one();
                    $idProcesoFlujo = $docFlujo->proceso_flujo_id;
                    $ProcesoFlujo = ProcesoFlujo::find()->where(['id'=>$idProcesoFlujo])->one();
                    $orden = $ProcesoFlujo->pf_orden;
                    if($orden==0){
                        echo Html::a(' <span class="glyphicon glyphicon-cog"></span> procesar', ['/documento/actualizar','id'=>$documento->iddocumento], ['class'=>'btn btn-warning']);
                    }else{
                        echo Html::a(' <span class="glyphicon glyphicon-cog"></span> procesar', ['/documento/procesar','id'=>$documento->iddocumento], ['class'=>'btn btn-warning']);
                    }
                ?> 

              </td>
             
              
            </tr>
        <?php endforeach;?>
    </table>
    <?php echo LinkPager::widget(["pagination" => $pagination]);?>
    </fieldset>
</div>
