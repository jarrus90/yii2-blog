<?php foreach ($comments AS $comment) { ?>
    <div class="comment media" id="comment<?= $comment->id; ?>">
        <div class="media-left">
            <img src="<?= $comment->user->avatarUrl; ?>" style="width: 64px;"/>
        </div>
        <div class="media-body">
            <div class="media-heading">
                <span class="comment-user">
                    <?= $comment->user->name ?>
                </span>
                <small class="pull-right">
                    <?= Yii::t('blog', 'Created at {time}', ['time' => date('Y-m-d H:i', $comment->created_at)]); ?>
                </small>
            </div>
            <div class="comment-text">
                <?= $comment->is_blocked ? Yii::t('blog', 'Comment is blocked') : $comment->content; ?>
            </div>
            <?php if (!$comment->is_blocked) { ?>
                <div class="media-footer">
                    <div class="btn btn-default btn-sm comment-reply" data-id="<?= $comment->id; ?>">
                        <?= Yii::t('blog', 'reply'); ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="comment-nested">
            <?= $this->render('_commentsNested', ['comments' => $comment->childList]); ?>
        </div>
    </div>
    <?php
}