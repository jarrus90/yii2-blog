<?php

namespace jarrus90\Blog;

use yii\base\Module as BaseModule;
use yii\helpers\ArrayHelper;

class Module extends BaseModule {

    /**
     * @var string The prefix for user module URL.
     *
     * @See [[GroupUrlRule::prefix]]
     */
    public $urlPrefix = 'blog';

    /** @var array The rules to be used in URL management. */
    public $urlRules = [
        'post/<key:[A-Za-z0-9_-]+>' => 'front/post',
        'tag/<key:[A-Za-z0-9_-]+>' => 'front/tag',
    ];
    
    public $redactor = [];
    
    public function init() {
        parent::init();
        $this->modules = [
            'redactor' => ArrayHelper::merge([
                'class' => 'yii\redactor\RedactorModule',
                'imageUploadRoute' => '/blog/upload/image',
                'fileUploadRoute' => '/blog/upload/file',
                'imageManagerJsonRoute' => '/blog/upload/image-json',
                'fileManagerJsonRoute' => '/blog/upload/file-json'
            ], $this->redactor),
        ];
    }

}
