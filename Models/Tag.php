<?php

namespace jarrus90\Blog\Models;

use yii\db\ActiveRecord;

class Tag extends ActiveRecord {

    /** @inheritdoc */
    public static function tableName() {
        return '{{%blog_tag}}';
    }

}
