<?php

namespace jarrus90\Blog\Models;

use Yii;

class PostSearch extends Post {
    
    public $tag;
    public $search;
    
    public function formName(){
        return '';
    }

    public function rules() {
        return [
            'safeSearch' => [['key', 'search', 'tag', 'active_from'], 'safe', 'on' => ['search']],
        ];
    }

    public function scenarios() {
        return [
            'search' => ['key', 'search', 'tag', 'active_from']
        ];
    }
    
    public function search($params) {
        $query = self::find()->with('tags');
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'active_from' => SORT_DESC
                ]
            ]
        ]);
        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['like', 'key', $this->key]);
            $query->andFilterWhere(['like', 'title', $this->search]);
            $query->andFilterWhere(['like', 'content', $this->search]);
            $query->andFilterWhere(['<', 'active_from', $this->active_from]);
            if($this->tag) {
                $query->joinWith('tagRelation')->andFilterWhere(['tag_id' => $this->tag]);
            }
        }
        return $dataProvider;
    }
}