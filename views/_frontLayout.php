<?php

use yii\widgets\Pjax;
?>

<div class="row blog-front">
    <div class="col-md-9">
        <?php
        /* Pjax::begin([
          'linkSelector' => '.blog-front a.internal, .blog-front .pagination a',
          'formSelector' => '.blog-front form',
          'id' => 'blog-container'
          ]); */
        echo $content;
        //Pjax::end();
        ?>
    </div>
    <div class="col-md-3">
        <?= \jarrus90\Blog\Widgets\Sidebar::widget(); ?>
        <h5>
            Tags
        </h5>
    </div>
</div>