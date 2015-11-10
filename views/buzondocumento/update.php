<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Buzondocumento */

$this->title = 'Update Buzondocumento: ' . ' ' . $model->idbuzondocumento;
$this->params['breadcrumbs'][] = ['label' => 'Buzondocumentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idbuzondocumento, 'url' => ['view', 'id' => $model->idbuzondocumento]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="buzondocumento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
