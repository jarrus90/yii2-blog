<?php foreach ($comments AS $comment) { ?>
    <div class="media" id="comment<?= $comment->id; ?>">
        <div class="media-left">
            <img src="http://icons.iconarchive.com/icons/guillendesign/variations-3/256/Default-Icon-icon.png" style="width: 64px;"/>
        </div>
        <div class="media-body">
            <div class="media-heading">
                <?= $comment->user->name ?>
                <small class="pull-right">
                    <?= Yii::t('blog', 'Created at {time}', ['time' => date('Y-m-d H:i', $comment->created_at)]); ?>
                </small>
            </div>
            <?= $comment->is_blocked ? Yii::t('blog', 'Comment is blocked') : $comment->content; ?>
            <?= $this->render('_commentsNested', ['comments' => $comment->childList]); ?>
        </div>
    </div>
    <?php
}