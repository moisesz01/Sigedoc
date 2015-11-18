<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\actividad */

$this->title = $model->idactividad;
$this->params['breadcrumbs'][] = ['label' => 'Actividades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="actividad-view">

    <h1>Datos de la Actividad</h1>

    <p style="padding-bottom:30px;">
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Actualizar', ['update', 'id' => $model->idactividad], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Borrar', ['delete', 'id' => $model->idactividad], [
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
            'idactividad',
            'ac_nombre',
            'ac_descripcion:ntext',
        ],
    ]) ?>
    <?= Html::a(' <span class="glyphicon glyphicon-circle-arrow-left"> </span>  Volver', ['actividad/index'] , ['class'=>'btn btn-success', 'style'=>'margin-top:20px;']) ?>

</div>

