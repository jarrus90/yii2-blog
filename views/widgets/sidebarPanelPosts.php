<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="panel panel-default">
    <div class="panel-heading"><?= Yii::t('blog', 'Posts'); ?></div>
    <ul  class="list-group">
        <?php foreach ($posts AS $post) { ?>
            <li class="list-group-item">
                <?=
                Html::a($post->title, Url::toRoute(['post', 'key' => $post->key]), [
                    'class' => 'list-group-item-heading bold'
                ]);
                ?>
                <p class="list-group-item-text">
                    <?= $post->shortContent; ?>
                </p>
            </li>
        <?php } ?>
    </ul >
</div>