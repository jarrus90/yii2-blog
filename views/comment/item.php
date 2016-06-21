<?php

/**
 * @var $this  yii\web\View
 * @var $model jarrus90\User\models\Role
 */
use yii\bootstrap\Nav;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->params['breadcrumbs'][] = $this->title;
$this->beginContent('@jarrus90/Blog/views/_adminLayout.php');
?>
<div class="nav-tabs-custom">
    <div class="row">
        <div class="col-md-3">
            <?=
            Nav::widget([
                'options' => [
                    'class' => 'nav nav-stacked box box-primary',
                ],
                'items' => [
                    [
                        'label' => Yii::t('user', 'Comment'),
                        'url' => '#update',
                        'options' => ['class' => 'active'],
                        'linkOptions' => ['data-toggle' => 'tab']
                    ],
                    [
                        'label' => Yii::t('user', 'Information'),
                        'url' => '#info',
                        'linkOptions' => ['data-toggle' => 'tab']
                    ],
                    [
                        'label' => Yii::t('blog', 'Block'),
                        'url' => ['block', 'id' => $model->id],
                        'visible' => !$model->is_blocked,
                        'linkOptions' => [
                            'class' => 'text-danger',
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('blog', 'Are you sure you want to block this comment?'),
                        ],
                    ],
                    [
                        'label' => Yii::t('blog', 'Unblock'),
                        'url' => ['block', 'id' => $model->id],
                        'visible' => $model->is_blocked,
                        'linkOptions' => [
                            'class' => 'text-success',
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('blog', 'Are you sure you want to unblock this comment?'),
                        ],
                    ],
                    [
                        'label' => Yii::t('blog', 'Delete'),
                        'url' => ['delete', 'id' => $model->id],
                        'linkOptions' => [
                            'class' => 'text-danger',
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('blog', 'Are you sure you want to delete this comment?'),
                        ],
                    ],
                ],
            ])
            ?>
        </div>
        <div class="col-md-9 tab-content">
            <div class="tab-pane active" id="update">
                <?php
                $form = ActiveForm::begin([
                            'enableAjaxValidation' => true,
                            'enableClientValidation' => false,
                        ])
                ?>
                <?=
                $form->field($model, 'content')->widget(\jarrus90\Blog\Widgets\Redactor::className(), [
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
            </div>
            <div class="tab-pane" id="info">
                <dl class="dl-horizontal">
                    <dt><?= Yii::t('blog', 'Post'); ?></dt>
                    <dd>
                        <?=
                        Html::a($model->post->title, Url::toRoute(['post/update', 'id' => $model->post_id]), [
                            'data-pjax' => 0
                        ]);
                        ?>
                    </dd>
                    <dt><?= Yii::t('blog', 'User'); ?></dt>
                    <dd>
                        <?=
                        Html::a($model->user->name, Url::toRoute(['/user/admin/info', 'id' => $model->created_by]), [
                            'data-pjax' => 0
                        ]);
                        ?>
                    </dd>
                    <dt><?= Yii::t('blog', 'Created at'); ?></dt>
                    <dd>
                        <?=
                        date('Y-m-d H:i', $model->created_at);
                        ?>
                    </dd>
                    <?php if($model->is_blocked) { ?>
                        <hr>
                        <dt><?= Yii::t('blog', 'Blocked by'); ?></dt>
                        <dd>
                            <?=
                            Html::a($model->blocker->name, Url::toRoute(['/user/admin/info', 'id' => $model->blocked_by]), [
                                'data-pjax' => 0
                            ]);
                        ?>
                        </dd>
                        <dt><?= Yii::t('blog', 'Blocked at'); ?></dt>
                        <dd>
                            <?=
                            date('Y-m-d H:i', $model->blocked_at);
                            ?>
                        </dd>
                    <?php } ?>
                </dl>
            </div>
        </div>
    </div>
</div>
<?php $this->endContent() ?>
