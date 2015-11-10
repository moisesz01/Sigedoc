<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProcesoFlujo */

$this->title = 'Create Proceso Flujo';
$this->params['breadcrumbs'][] = ['label' => 'Proceso Flujos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proceso-flujo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
