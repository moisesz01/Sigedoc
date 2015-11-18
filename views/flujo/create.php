<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Flujo */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Flujos', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Crear Flujo';
?>
<div class="flujo-create">

    <h1>Crear Flujo</h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
