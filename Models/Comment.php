<?php

namespace jarrus90\Blog\Models;

use yii\db\ActiveRecord;
use jarrus90\User\models\User;
use jarrus90\User\models\Profile;
class Comment extends ActiveRecord {

    use \jarrus90\Blog\traits\ShortContentTrait;
    /**
     * @var Comment 
     */
    public $item;
    public $childList = [];

    /** @inheritdoc */
    public static function tableName() {
        return '{{%blog_comment}}';
    }

    public function scenarios() {
        return [
            'update' => ['content'],
            'create' => ['content', 'post_id']
        ];
    }

    public function rules() {
        return [
            'required' => [['content', 'created_by'], 'required', 'on' => ['create', 'update']],
            'safeSearch' => [['content'], 'safe', 'on' => ['search']],
            'postExists' => ['post_id', 'exist', 'targetClass' => Post::className(), 'targetAttribute' => 'id'],
            'parentExists' => ['parent_id', 'exist', 'targetClass' => self::className(), 'targetAttribute' => 'id'],
            'creatorExists' => ['created_by', 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id'],
            'blockerExists' => ['blocked_by', 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id'],
        ];
    }
    
    public function getPost(){
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }
    
    public function getUser(){
        return $this->hasOne(Profile::className(), ['user_id' => 'created_by']);
    }

    public function getParent(){
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }
    
    public function getShortContent($length = 150){
        return $this->shorten($this->content, $length);
    }
    
    public function init() {
        parent::init();
        if ($this->item instanceof Comment) {
            $this->id = $this->item->id;
            $this->setAttributes($this->item->getAttributes());
            $this->setIsNewRecord($this->item->getIsNewRecord());
        }
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
            $query->andFilterWhere(['post_id' => $this->post_id]);
            $query->andFilterWhere(['user_id' => $this->user_id]);
        }
        return $dataProvider;
    }
    
    public function block() {
        $this->setAttributes([
            'is_blocked' => true,
            'blocked_by' => Yii::$app->user->id,
            'blocked_at' => time()
        ])->save();
        return $this;
    }
    
    public function unblock() {
        $this->setAttributes([
            'is_blocked' => false,
            'blocked_by' => Yii::$app->user->id,
            'blocked_at' => time()
        ])->save();
        return $this;
    }

    public function beforeSave($insert) {
        if ($insert) {
            $this->created_at = time();
        }
        return parent::beforeSave($insert);
    }

}

