<?php

namespace jarrus90\Blog\Models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

/**
 * Form for comments saving and updating
 *
 * @property Post $_model Post item
 */
class PostForm extends \jarrus90\Core\Models\Model {

    use \jarrus90\Blog\traits\ModuleTrait;

    public $key;
    public $title;
    public $content;
    public $image;
    public $tags = [];
    public $active_from;
    public $comments_enabled;

    /** @var array */
    public $avatar;

    public function getId() {
        return $this->_model->id;
    }

    public function init() {
        parent::init();
        $this->_model->scenario = $this->scenario;
        if (!$this->_model->getIsNewRecord()) {
            $this->setAttributes($this->_model->getAttributes());
            $this->active_from = date('Y-m-d H:i', $this->active_from);
            $this->setAttributes(['tags' => ArrayHelper::map($this->_model->tagRelation, 'tag_id', 'tag_id')], false);
        } else {
            $this->active_from = date('Y-m-d H:i', time());
        }
    }

    /**
     * Attribute labels
     * @return array
     */
    public function attributeLabels() {
        
    }

    /**
     * Validation rules
     * @return array
     */
    public function rules() {
        $rules = $this->_model->rules();
        $rules[] = ['tags', 'exist', 'targetClass' => Tag::className(), 'targetAttribute' => 'id', 'allowArray' => true];
        $rules['keyExists'] = ['key', 'unique', 'targetClass' => Post::className(), 'targetAttribute' => 'key', 'when' => function($model) {
                return $model->key != $model->item->key;
            }];
        return $rules;
    }

    public function scenarios() {
        $scenarios = $this->_model->scenarios();
        $scenarios['create'][] = 'tags';
        $scenarios['update'][] = 'tags';
        return $scenarios;
    }

    public function save() {
        if ($this->validate()) {
            $this->_model->key = $this->key;
            $this->_model->title = $this->title;
            $this->_model->content = $this->cleanTextarea($this->content);
            $this->_model->active_from = strtotime($this->active_from);
            if(($image = $this->getImage()) && ($result = $this->_model->saveImage($image))) {
                $this->_model->image = $result;
            }
            if ($this->_model->save(false)) {
                foreach ($this->_model->tagRelation AS $tag) {
                    $tag->delete();
                }
                if (is_array($this->tags)) {
                    foreach ($this->tags AS $tag) {
                        $this->_model->addTag($tag);
                    }
                }
                return $this->_model;
            }
        }
        return false;
    }

    protected function getImage() {
        return UploadedFile::getInstance($this, 'image');
    }

}
