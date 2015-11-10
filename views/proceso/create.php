<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Proceso */

$this->title = 'Create Proceso';
$this->params['breadcrumbs'][] = ['label' => 'Procesos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proceso-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelProceso' => $modelProceso,
        'modelsCampo' => (empty($modelsCampo)) ? [new Address] : $modelsCampo
    ]) ?>

</div>
