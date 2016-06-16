<?php


namespace jarrus90\Blog\Controllers;

use Yii;
use yii\web\Response;
use jarrus90\Blog\traits\ModuleTrait;

class UploadController extends \yii\web\Controller {

    use ModuleTrait;
    public $enableCsrfValidation = false;

    public function behaviors() {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ],
            ]
        ];
    }

    
    /**
     * List of available upload actions
     * 
     * @return array
     */
    public function actions() {
        return [
            'image' => [
                'class' => '\jarrus90\Redactor\Actions\ImageUploadAction',
                'module' => $this->module->getModule('redactor'),
                'storage' => $this->module->storage
            ],
            'image-json' => [
                'class' => '\jarrus90\Redactor\Actions\ImageManagerJsonAction',
                'module' => $this->module->getModule('redactor'),
                'storage' => $this->module->storage
            ],
        ];
    }
}
