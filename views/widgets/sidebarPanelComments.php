<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="panel panel-default">
    <div class="panel-heading"><?= Yii::t('blog', 'Comments'); ?></div>
    <ul  class="list-group">
        <?php foreach ($comments AS $comment) { ?>
            <li class="list-group-item">
                <div class="media">
                    <div class="media-body">
                        <?=
                        Html::a($comment->post->title, Url::toRoute(['post', 'key' => $comment->post->key]), [
                            'class' => 'media-heading'
                        ]);
                        ?>
                        <br>
                        <?= $comment->shortContent; ?>
                    </div>
                </div>
            </li>
        <?php } ?>
    </ul >
</div>