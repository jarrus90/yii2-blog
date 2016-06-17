<?php

use yii\helpers\Html;
use yii\helpers\Url;
$this->beginContent('@jarrus90/Blog/views/_frontLayout.php');
$this->title = $post->title;
$this->params['breadcrumbs'][] = $post->title;
?>
<div class="container-fluid">
    <div class="row">
        <h2><?= $post->title; ?></h2>
        <?= $post->content; ?>
        <hr>
    </div>
    <div class="row">

        <ul class="list-inline">
            <li>
                <div class="btn-group">
                    <?php
                    foreach ($post->tags AS $tag) {
                        echo Html::a($tag->title, Url::toRoute(['posts', 'tag' => $tag->id]), [
                            'class' => 'internal btn btn-default btn-sm'
                        ]);
                    }
                    ?>
                </div>
            </li>
            <li>
                <?= Yii::t('blog', 'Created at {time}', ['time' => date('Y-m-d H:i', $post->created_at)]); ?>
            </li>
        </ul>
    </div>
</div>
<hr>
<?php if ($post->comments_enabled) { ?>
    <?= $this->render('_commentsNested', ['comments' => $post->nestedComments]); ?>
    <?= $this->render('_commentsForm', ['post' => $post, 'model' => $commentForm]); ?>
<?php } else { ?>
    <div class="well">
        <?= Yii::t('blog', 'Comments to this post are disabled'); ?>
    </div>
<?php } ?>
<?php $this->endContent() ?>