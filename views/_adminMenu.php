<?php

/**
 * @var $this yii\web\View
 */
use yii\bootstrap\Nav;
?>
<?=
Nav::widget([
    'options' => [
        'class' => 'nav-tabs'
    ],
    'items' => [
        [
            'label' => Yii::t('blog', 'Posts'),
            'url' => ['/blog/post/index'],
            'active' => (Yii::$app->controller instanceof jarrus90\Blog\Controllers\PostController)
        ],
        [
            'label' => Yii::t('blog', 'Tags'),
            'url' => ['/blog/tag/index'],
            'active' => (Yii::$app->controller instanceof jarrus90\Blog\Controllers\TagController)
        ],
        [
            'label' => Yii::t('blog', 'Comments'),
            'url' => ['/blog/comment/index'],
            'active' => (Yii::$app->controller instanceof jarrus90\Blog\Controllers\CommentController)
        ]
    ],
]);
?>