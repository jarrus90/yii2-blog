<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$form = ActiveForm::begin([
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'id' => 'comment-form',
            'options' => [
                'class' => 'blog-comment-form'
            ]
        ]);
?>
<?= $form->field($model, 'parent_id')->hiddenInput(['value' => $model->parent_id])->label(false); ?>

<div class="alert alert-success reply-block"> 
    <button type="button" class="close">
        <span aria-hidden="true">×</span>
    </button>
    <strong><?= Yii::t('blog', 'Reply to'); ?> <span class="username"></span></strong>
    <p class="message"></p>
</div>
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
<?= Html::submitButton(Yii::t('content', 'Save'), ['class' => 'btn btn-success btn-block']) ?>
<?php ActiveForm::end() ?>