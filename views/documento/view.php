<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Requerimiento;

/* @var $this yii\web\View */
/* @var $model app\models\Documento */

$this->title = $model->iddocumento;
$this->params['breadcrumbs'][] = ['label' => 'Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documento-view">

    <h1>Datos del Documento</h1>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Actualizar', ['update', 'id' => $model->iddocumento], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Borrar', ['delete', 'id' => $model->iddocumento], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

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
    
    <?php foreach ($Recaudos as $recaudo):?>
        <div class="row" style="padding-top:5px;">
            <div class="col-sm-8">
            <?php 
                $Requerimiento = Requerimiento::find()->where(['id'=>$recaudo->requerimiento_id])->one();
                echo Html::label($Requerimiento->re_nombre,"",['class'=>'control-label']); 
                echo Html::input('text', 'DOCUMENTO[field][]',$recaudo->dd_nombre,['readonly'=>true,'class'=>'form-control']); 
            ?> 
            </div>    
            <div class="col-sm-4" style="padding-top:24px;">
                <?= Html::a(' <span class="glyphicon glyphicon-download-alt"></span> Descargar', ['/documento/descargar','id'=>$recaudo->iddocumentodigital], ['class'=>'btn btn-warning']) ?>                
            </div>  
        </div>    
    <? endforeach; ?>    
  
    
</div>
