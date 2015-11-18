<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Proceso */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Procesos', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Crear Proceso';
?>
<div class="proceso-create">

    <h1>Crear Proceso</h1>

    <?= $this->render('_form', [
        'modelProceso' => $modelProceso,
        'modelsCampo' => (empty($modelsCampo)) ? [new Address] : $modelsCampo
    ]) ?>

</div>
