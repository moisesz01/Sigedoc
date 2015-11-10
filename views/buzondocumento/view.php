<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Buzondocumento */

$this->title = $model->idbuzondocumento;
$this->params['breadcrumbs'][] = ['label' => 'Buzondocumentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="buzondocumento-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idbuzondocumento], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idbuzondocumento], [
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
            'idbuzondocumento',
            'bd_fechaentrada',
            'bd_fechasalida',
            'bd_estado',
            'bd_userorigen',
            'bd_userdestino',
            'documento_iddocumento',
        ],
    ]) ?>

</div>
