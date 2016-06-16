<?php

/**
 * @var $this  yii\web\View
 * @var $model jarrus90\User\models\Role
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginContent('@jarrus90/Blog/views/_adminLayout.php') ?>
<?php
$form = ActiveForm::begin([
            'layout' => 'horizontal',
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'fieldConfig' => [
                'horizontalCssClasses' => [
                    'wrapper' => 'col-sm-9',
                ],
            ],
        ])
?>
<?= $form->field($model, 'key') ?>
<?= $form->field($model, 'title') ?>
<?= $form->field($model, 'content')->widget(\jarrus90\Content\Widgets\Redactor::className(), [
    'clientOptions' => [
        'lang' => Yii::$app->language,
        'minHeight' => 200,
        'plugins' => [
            'fontsize',
            'fontcolor',
            'fontfamily',
            'table',
            'counter',
            'fullscreen',
            'imagemanager'
        ],
    ]
])
?>
<?= Html::submitButton(Yii::t('content', 'Save'), ['class' => 'btn btn-success btn-block']) ?>
<?php ActiveForm::end() ?>
<?php $this->endContent() ?>
