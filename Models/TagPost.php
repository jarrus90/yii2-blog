<?php

namespace jarrus90\Blog\Models;

use yii\db\ActiveRecord;

class TagPost extends ActiveRecord {

    /** @inheritdoc */
    public static function tableName() {
        return '{{%blog_tag_post}}';
    }

    public function rules(){
        return [
            'required' => [['tag_id', 'post_id'], 'required']
        ];
    }
}
