<?php $this->beginContent('@jarrus90/Blog/views/_frontLayout.php') ?>
<h2>
    <?= $post->title; ?>
</h2>
<?= $post->content; ?>
<?php $this->endContent() ?>