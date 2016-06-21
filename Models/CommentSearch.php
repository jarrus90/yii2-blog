<?php

namespace jarrus90\Blog\Models;

use Yii;
use jarrus90\User\models\Profile;

class CommentSearch extends Comment {

    public $userName;
    public $postTitle;

    public function formName() {
        return '';
    }

    public function attributeLabels() {
        $labels = parent::attributeLabels();
        $labels['postTitle'] = Yii::t('blog', 'Post');
        $labels['userName'] = Yii::t('blog', 'User');
        return $labels;
    }
    public function rules() {
        return [
            'safeSearch' => [['content', 'postTitle', 'userName', 'created_at'], 'safe', 'on' => ['search']],
        ];
    }

    public function scenarios() {
        return [
            'search' => ['content', 'postTitle', 'userName', 'created_at']
        ];
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
        $dataProvider->sort->attributes['userName'] = [
            'asc' => ['user_id' => SORT_ASC],
            'desc' => ['user_id' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['postTitle'] = [
            'asc' => ['post_id' => SORT_ASC],
            'desc' => ['post_id' => SORT_DESC],
        ];
        $query->joinWith(['post', 'user']);
        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['post_id' => $this->post_id]);
            $query->andFilterWhere(['like', Post::tableName() . '.title', $this->postTitle]);            
            if (!is_null($this->userName) && $this->userName != '') {
                $userName[] = explode(' ', $this->userName);
                foreach ($userName AS $item) {
                    $query->andFilterWhere(['or',
                        ['like', Profile::tableName() . '.name', $item],
                        //['like', Profile::tableName() . '.surname', $item]
                    ]);
                }
            }
            if(($time = strtotime($this->created_at)) > 0) {
                $query->andFilterWhere(['>', 'created_at', $time]);
                $query->andFilterWhere(['<', 'created_at', $time + 24 * 60 * 60]);
            }
        }
        return $dataProvider;
    }

}
