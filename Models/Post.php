<?php

namespace jarrus90\Blog\Models;

use Yii;
use yii\db\ActiveRecord;
use jarrus90\Redactor\Models\FileUploadModel;

class Post extends ActiveRecord {

    use \jarrus90\Blog\traits\ModuleTrait;
    use \jarrus90\Blog\traits\StorageTrait;
    use \jarrus90\Blog\traits\ShortContentTrait;

    /** @inheritdoc */
    public static function tableName() {
        return '{{%blog_post}}';
    }

    public function scenarios() {
        return [
            'update' => ['key', 'title', 'image', 'content', 'active_from', 'comments_enabled'],
            'create' => ['key', 'title', 'image', 'content', 'active_from', 'comments_enabled'],
            'search' => ['key', 'title', 'content', 'active_from']
        ];
    }

    public function getImageUrl() {
        return $this->image ? Yii::getAlias($this->module->filesUploadUrl . '/' . $this->image) : false;
    }

    public function rules() {
        return [
            'required' => [['key', 'title', 'content', 'comments_enabled'], 'required', 'on' => ['create', 'update']],
            'safeSearch' => [['key', 'title', 'content', 'active_from'], 'safe', 'on' => ['search']],
            'keyExists' => ['key', 'unique', 'when' => function($model) {
                    return $model->key != $model->getOldAttribute('key');
                }],
            [['active_from', 'image'], 'safe']
        ];
    }

    public function getComments() {
        return $this->hasMany(Comment::className(), ['post_id' => 'id']);
    }

    public function getNestedComments(){
        $base = new \stdClass();
        $base->childList = [];
        $comments[0] = $base;
        foreach($this->comments AS $comment) {
            $comments[$comment->id] = $comment;
        }
        foreach ($comments as $id => $node) {
            if (!empty($node->parent_id)) {
                $comments[$node->parent_id]->childList[$id] = & $comments[$id];
            } else {
                $comments[0]->childList[$id] = & $comments[$id];
            }
        }
        unset($comments[0]->childList[0]);
        return $comments[0]->childList;
    }
    
    public function getTags() {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->via('tagRelation');
    }

    public function getTagRelation() {
        return $this->hasMany(TagPost::className(), ['post_id' => 'id']);
    }
    
    public function getShortContent($length = 400){
        return $this->shorten($this->content, $length);
    }

    public function search($params) {
        $query = self::find();
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['like', 'key', $this->key]);
            $query->andFilterWhere(['like', 'title', $this->title]);
            if(($time = strtotime($this->active_from)) > 0) {
                $query->andFilterWhere(['<', 'active_from', $time]);
            }
        }
        return $dataProvider;
    }

    public function addTag($tag) {
        $tagItem = new TagPost();
        $tagItem->setAttributes([
            'post_id' => $this->id,
            'tag_id' => $tag
        ]);
        return $tagItem->save();
    }

    public function beforeSave($insert) {
        if ($insert) {
            $this->created_at = time();
        }
        return parent::beforeSave($insert);
    }

    public function saveImage($image, $override = true) {
        $model = Yii::createObject([
                    'class' => FileUploadModel::className(),
                    'module' => $this->module->getModule('redactor'),
                    'storage' => $this->storage,
                    'file' => $image
        ]);
        if ($model->upload()) {
            if ($override) {
                $this->deleteImage();
            }
            $result = $model->getResponse();
            return $result['filename'];
        } else {
            return false;
        }
    }

    public function deleteImage() {
        if($this->image && $this->storage->has($this->image)) {
            return $this->storage->delete($this->image);
        }
        return false;
    }
    
    public function delete() {
        if(($res = parent::delete())) {
            foreach($this->tagRelation AS $tag) {
                $tag->delete();
            }
            $this->storage->delete($this->image);
            return $res;
        }
        return false;
    }

}
