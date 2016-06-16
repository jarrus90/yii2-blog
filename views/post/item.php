<?php

/**
 * @var $this  yii\web\View
 * @var $model jarrus90\User\models\Role
 */
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use kartik\file\FileInput;
use jarrus90\Blog\Models\Tag;
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$form = ActiveForm::begin([
            'layout' => 'horizontal',
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'options' => ['enctype' => 'multipart/form-data'],
            'fieldConfig' => [
                'horizontalCssClasses' => [
                    'label' => 'col-md-2',
                    'wrapper' => 'col-md-10',
                ],
            ],
        ])
?>
<?php $this->beginContent('@jarrus90/Blog/views/_adminLayout.php') ?>
<?php $this->endContent() ?>
<div class="row">
    <div class="col-md-9">
        <div class="box box-default">
            <div class="box-body">
                <?= $form->field($model, 'key') ?>
                <?= $form->field($model, 'title') ?>
                <?=
                $form->field($model, 'content')->widget(\jarrus90\Content\Widgets\Redactor::className(), [
                    'clientOptions' => [
                        'lang' => Yii::$app->language,
                        'minHeight' => 500,
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
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="box box-default">
            <div class="box-header with-border">
                <?= Yii::t('blog', 'Publication options'); ?>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="container-fluid">
                    <?=
                    $form->field($model, 'active_from', [
                        'template' => $model->getAttributeLabel('active_from') . '{input}{hint}{error}'
                    ])->widget(kartik\datetime\DateTimePicker::className(), [
                        'options' => [
                        ]
                    ]);
                    ?>
                </div>
            </div>
            <div class="box-footer">
                <?= $form->field($model, 'comments_enabled')->checkbox() ?>
            </div>
        </div>
        <div class="box box-default">
            <div class="box-header with-border">
                <?= $model->getAttributeLabel('image'); ?>
            </div>
            <div class="box-body">
                <div class="container-fluid">
                    <?=
                    $form->field($model, 'image', [
                        'template' => '{input}{hint}{error}'
                    ])->widget(FileInput::classname(), [
                        'options' => ['accept' => 'image/*'],
                        'pluginOptions' => [
                            'previewTemplates' => [
                                'image' => "<img src='{data}' style='width:{width};'/>"
                             ],
                            'previewSettings' => [
                                'image' => [
                                    'width' => '100%',
                                    'height' => 'auto'
                                ]
                            ],
                            'showClose' => false,
                            'showRemove' => false,
                            'showUpload' => false,
                            'dropZoneEnabled' => false,
                            'defaultPreviewContent' => [Html::img($model->item->imageUrl, ['style' => 'width: 100%;'])],
                            'overwriteInitial' => true
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="box box-default">
            <div class="box-header with-border">
                <?= Yii::t('blog', 'Tags'); ?>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="container-fluid">
                    <?=
                    $form->field($model, 'tags', [
                        'template' => '{input}{hint}{error}'
                    ])->widget(Select2::className(), [
                        'data' => ArrayHelper::map(Tag::find()->orderBy(['title' => SORT_ASC])->asArray()->all(), 'id', 'title'),
                        'options' => [
                            'placeholder' => Yii::t('blog', 'Select tags'),
                            'multiple' => true,
                        ],
                        'theme' => 'default'
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-9">
        <?= Html::submitButton(Yii::t('blog', 'Save'), ['class' => 'btn btn-success btn-block']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>
<style>
    .content-wrapper .content .form-group {
        margin-bottom: 0px;
    }
</style>