<?php

namespace jarrus90\Blog\Models;

use yii\db\ActiveRecord;

class Post extends ActiveRecord {

    use \jarrus90\Blog\traits\ModuleTrait;
        
    /** @inheritdoc */
    public static function tableName() {
        return '{{%blog_post}}';
    }

    public function scenarios() {
        return [
            'update' => ['key', 'title', 'image', 'content', 'active_from', 'comments_enabled'],
            'create' => ['key', 'title', 'image', 'content', 'active_from', 'comments_enabled'],
            'search' => ['key', 'title', 'content']
        ];
    }
    
    public function getImageUrl(){
        return 'https://pp.vk.me/c630316/v630316876/40330/jEkvv9Db_Xo.jpg';
    }

    public function rules() {
        return [
            'required' => [['key', 'title', 'content', 'comments_enabled'], 'required', 'on' => ['create', 'update']],
            'safeSearch' => [['key', 'title', 'content'], 'safe', 'on' => ['search']],
            [['active_from', 'image'], 'safe']
        ];
    }
    
    public function getComments(){
        return $this->hasOne(Comment::className(), ['post_id' => 'id']);
    }
    
    public function getTags(){
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->via('tagRelation');
    }
    
    public function getTagRelation(){
        return $this->hasMany(TagPost::className(), ['post_id' => 'id']);
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
        }
        return $dataProvider;
    }

    public function addTag($tag){
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

}
