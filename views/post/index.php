<?php

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 */
$this->beginContent('@jarrus90/Blog/views/_adminLayout.php');
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $filterModel,
    'pjax' => true,
    'hover' => true,
    'export' => false,
    'id' => 'list-table',
    'toolbar' => [
        ['content' =>
            Html::a('<i class="glyphicon glyphicon-plus"></i>', Url::toRoute(['create']), [
                'data-pjax' => 0,
                'class' => 'btn btn-default',
                'title' => \Yii::t('content', 'New block')]
            )
            . ' ' .
            Html::a('<i class="glyphicon glyphicon-repeat"></i>', Url::toRoute(['index']), [
                'data-pjax' => 0,
                'class' => 'btn btn-default',
                'title' => Yii::t('content', 'Reset filter')]
            )
        ],
    ],
    'panel' => [
        'type' => \kartik\grid\GridView::TYPE_DEFAULT
    ],
    'layout' => "{toolbar}{items}{pager}",
    'pager' => ['options' => ['class' => 'pagination pagination-sm no-margin']],
    'columns' => [
        [
            'attribute' => 'key',
            'width' => '25%'
        ],
        [
            'attribute' => 'title',
            'width' => '50%'
        ],
        [
            'attribute' => 'active_from',
            'class' => '\kartik\grid\DataColumn',
            'width' => '15%',
            'filterType' => GridView::FILTER_DATE,
            'filterWidgetOptions' => [
                'pickerButton' => false,
                'type' => kartik\date\DatePicker::TYPE_COMPONENT_APPEND,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-mm-yyyy'
                ]
            ],
            'format' => ['date', 'php:Y-m-d H:i']
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
        ],
    ],
]);
$this->endContent();