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
        '' => 'front/posts',
        '<key:[A-Za-z0-9_-]+>' => 'front/post',
        'tag/view/<key:[A-Za-z0-9_-]+>' => 'front/tag',
    ];
    public $filesUploadUrl = '@web/uploads/blog';
    public $filesUploadDir = '@webroot/uploads/blog';
    public $redactorConfig = [];
    public $useCommonStorage = false;

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
        if(!$this->get('storage', false)) {
            if($this->useCommonStorage && ($storage = Yii::$app->get('storage', false))) {
                $this->set('storage', $storage);
            } else {
                $this->set('storage', [
                    'class' => 'creocoder\flysystem\LocalFilesystem',
                    'path' => $this->filesUploadDir
                ]);
            }
        }
    }

}
