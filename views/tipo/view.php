<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tipo */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tipos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Borrar', ['delete', 'id' => $model->id], [
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
            'id',
            'ti_tipo',
        ],
    ]) ?>

   <?php if($opciones):?>
        <h2>Valores</h2>

        <table class="table table-striped table-bordered" style="text-align:center;">
            <tr>
              <td><strong>Opción</strong></td>
              
            </tr>
             <?php foreach ($opciones as $opcion):?>
                <tr>
                  <td><?=$opcion['op_nombre']?></td>               
                  
                </tr>
            <?php endforeach;?>
        </table> 

    <?php endif; ?>
    
<?= Html::a(' <span class="glyphicon glyphicon-circle-arrow-left"> </span>  Volver', ['tipo/index'] , ['class'=>'btn btn-success', 'style'=>'margin-top:20px;']) ?>


</div>
