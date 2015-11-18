<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Tipo;

/* @var $this yii\web\View */
/* @var $model app\models\Proceso */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Procesos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proceso-view">

    <h1>Datos del proceso:</h1>

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
            'pr_referencia',
            'pr_nombre',
            'pr_descripcion:ntext',
            'pr_aprobacion',
            'pr_directorio:ntext',
        ],
    ]) ?>


    <h2>Campos del Proceso</h2>

    <table class="table table-striped table-bordered" style="text-align:center;">
        <tr>
          <td><strong>Nombre del Campo</strong></td>
          <td><strong>Tipo de Dato</strong></td>
          
        </tr>
         <?php foreach ($modelsCampo as $value):?>
            <tr>
              <td><?=$value['ca_nombre']?></td>
              <td>
                  <?php

                    $tipo = Tipo::find()->where(['id'=>$value['tipo_id']])->one();
                    $tipo = $tipo['ti_tipo'];
                    echo $tipo;
                  ?>
              </td>
              
            </tr>
        <?php endforeach;?>
    </table>

    <?= Html::a(' <span class="glyphicon glyphicon-circle-arrow-left"> </span>  Volver', ['proceso-flujo/index'] , ['class'=>'btn btn-success', 'style'=>'margin-top:20px;']) ?>

</div>
