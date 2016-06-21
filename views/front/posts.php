<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;
$this->title = Yii::t('blog', 'Posts');
$this->beginContent('@jarrus90/Blog/views/_frontLayout.php');
if ($filterModel->tag) {
    $tag = $finder->findTag(['id' => $filterModel->tag])->one();
    ?>
    <div class="btn-group">
        <span class="btn btn-default btn-sm">
            <?= $tag->title; ?>
        </span>
        <?= Html::a('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>', Url::toRoute(['posts']), [
                'class' => 'internal btn btn-default btn-sm'
            ]); ?>
    </div>
    <hr>
    <?php
}
?>

<?php
echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_post',
    'id' => 'posts-list',
    'layout' => "{items}{pager}",
]);
$this->endContent();
?>