<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

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
<div class="container-fluid">
    <?=
    $form->field($model, 'content', [
        'template' => '{input}{hint}{error}'
    ])->widget(\jarrus90\Blog\Widgets\RedactorComment::className(), [
        'clientOptions' => [
            'lang' => Yii::$app->language,
            'minHeight' => 200,
            'plugins' => [
                'fontsize',
                'fontcolor'
            ],
        ]
    ])
    ?>
</div>
<?= $form->field($model, 'post_id')->hiddenInput(['value' => $post->id])->label(false); ?>
<?= Html::submitButton(Yii::t('content', 'Save'), ['class' => 'btn btn-success btn-block']) ?>
<?php ActiveForm::end() ?>