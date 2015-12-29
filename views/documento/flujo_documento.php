<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DocumentoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = 'Flujo de Documentos';
?>
<div class="documento-flujo">

    <h1>Flujo de Documentos</h1>
    


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'do_referencia',            
            [
                'attribute'=>'proceso_id',
                'value'=>'proceso.pr_nombre'
            ],
            'do_nombre',
            'do_descripcion:ntext',

            //['class' => 'yii\grid\ActionColumn'],
            

            [
              'class' => 'yii\grid\ActionColumn',
              'template' => '{flujo}',
              'buttons' => [
                'flujo' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                'title' => Yii::t('app', 'Ver'),
                    ]);
                }
              ],
              'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'flujo') {

                    $url = Url::toRoute(['documento/flujo','id'=>$model->iddocumento]);
                    return $url;
                }
              }
            ],
            


        ],
    ]); ?>

</div>
