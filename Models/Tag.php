<?php

namespace jarrus90\Blog\Models;

use yii\db\ActiveRecord;

class Tag extends ActiveRecord {

    /**
     * @var Tag 
     */
    public $item;

    /** @inheritdoc */
    public static function tableName() {
        return '{{%blog_tag}}';
    }

    public function scenarios() {
        return [
            'update' => ['key', 'title', 'content'],
            'create' => ['key', 'title', 'content'],
            'search' => ['key', 'title']
        ];
    }

    public function rules() {
        return [
            'required' => [['key', 'title', 'content'], 'required', 'on' => ['create', 'update']],
            'safeSearch' => [['key', 'title', 'content'], 'safe', 'on' => ['search']]
        ];
    }

    public function init() {
        parent::init();
        if ($this->item instanceof Tag) {
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
            $query->andFilterWhere(['like', 'key', $this->key]);
            $query->andFilterWhere(['like', 'title', $this->title]);
        }
        return $dataProvider;
    }

}
