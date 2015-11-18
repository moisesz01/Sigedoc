<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Flujo */

$this->title = $model->idflujo;
$this->params['breadcrumbs'][] = ['label' => 'Flujos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flujo-view">

    <h1>Datos del Flujo</h1>

    <p style="padding-bottom:30px;">
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Actualizar', ['update', 'id' => $model->idflujo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Borrar', ['delete', 'id' => $model->idflujo], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Esta seguro de eliminar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fl_nombre',
            'fl_descripcion:ntext',
        ],
    ]) ?>
    <?= Html::a(' <span class="glyphicon glyphicon-circle-arrow-left"> </span>  Volver', ['flujo/index'] , ['class'=>'btn btn-success', 'style'=>'margin-top:20px;']) ?>

</div>
