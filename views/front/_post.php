<?php

use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="media">
    <?php if ($model->imageUrl) { ?>
        <div class="media-left media-top">
            <a href="<?= Url::toRoute(['post', 'key' => $model->key]); ?>" class="internal">
                <img class="media-object" src="<?= $model->imageUrl; ?>" alt="<?= $model->title; ?>">
            </a>
        </div>
    <?php } ?>
    <div class="media-body">
        <a href="<?= Url::toRoute(['post', 'key' => $model->key]); ?>" class="internal">
            <h4 class="media-heading"><?= $model->title; ?></h4>
        </a>
        <?= $model->shortContent; ?>
    </div>
    <hr>
    <ul class="list-inline">
        <li>
            <div class="btn-group">
                <?php
                foreach ($model->tags AS $tag) {
                    echo Html::a($tag->title, Url::toRoute(['posts', 'tag' => $tag->id]), [
                        'class' => 'internal btn btn-default btn-sm'
                    ]);
                }
                ?>
            </div>
        </li>
        <li>
            <?= Yii::t('blog', 'Created at {time}', ['time' => date('Y-m-d H:i', $model->created_at)]); ?>
        </li>
    </ul>
</div>
<hr>