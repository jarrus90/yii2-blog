<?php

namespace jarrus90\Blog;

use Yii;
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
        '<key:[A-Za-z0-9_-]+>' => 'front/post',
        'tag/view/<key:[A-Za-z0-9_-]+>' => 'front/tag',
    ];
    
    public $filesUploadUrl = '@web/uploads/blog';
    public $filesUploadDir = '@webroot/uploads/blog';
            
    public $storageConfig = [];
    public $redactorConfig = [];
        
    public function init() {
        parent::init();
        $this->modules = [
            'redactor' => ArrayHelper::merge([
                'class' => 'jarrus90\Redactor\Module',
                'imageUploadRoute' => '/blog/upload/image',
                'imageManagerJsonRoute' => '/blog/upload/image-json'
            ], $this->redactorConfig, [
                'uploadUrl' => $this->filesUploadUrl,
                'uploadDir' => $this->filesUploadDir,
            ]),
        ];
        $this->components = [
            'storage' => ArrayHelper::merge(
                [
                    'class' => 'creocoder\flysystem\LocalFilesystem',
                    'path' => $this->filesUploadDir
                ], 
                ISSET(Yii::$app->params['storage']) ? Yii::$app->params['storage'] : [],
                $this->storageConfig
            ),
        ];
    }

}
