<?php

namespace jarrus90\Blog\Models;

use yii\db\ActiveRecord;

class Comment extends ActiveRecord {

    /** @inheritdoc */
    public static function tableName() {
        return '{{%blog_comment}}';
    }

}
