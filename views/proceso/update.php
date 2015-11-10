<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Proceso */

$this->title = 'Update Proceso: ' . ' ' . $modelProceso->id;
$this->params['breadcrumbs'][] = ['label' => 'Procesos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelProceso->id, 'url' => ['view', 'id' => $modelProceso->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="proceso-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelProceso' => $modelProceso,
        'modelsCampo' => (empty($modelsCampo)) ? [new Address] : $modelsCampo
    ]) ?>

</div>
