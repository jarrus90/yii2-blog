<?php

namespace jarrus90\Blog\Widgets;

use yii\base\InvalidConfigException;
use Yii;

class RedactorComment extends Redactor {

    /**
     * @return RedactorModule
     * @throws InvalidConfigException
     */
    public function getModule() {
        if (($baseModule = Yii::$app->getModule('blog'))) {
            if (($module = $baseModule->getModule('redactor'))) {
                return $module;
            }
        }
        throw new InvalidConfigException('Invalid config Redactor module with "$moduleId"');
    }

    /**
     * Sets default options
     */
    protected function defaultOptions() {
        parent::defaultOptions();
        unset($this->clientOptions['imageUpload']);
        unset($this->clientOptions['fileUpload']);
        unset($this->clientOptions['imageManagerJson']);
        unset($this->clientOptions['fileManagerJson']);

        if (isset($this->clientOptions['plugins']) && array_search('imagemanager', $this->clientOptions['plugins']) !== false) {
            $this->setOptionsKey('imageUpload', $this->module->imageUploadRoute);
            $this->clientOptions['imageUploadErrorCallback'] = ArrayHelper::getValue($this->clientOptions, 'imageUploadErrorCallback', new JsExpression("function(json){alert(json.error);}"));
            $this->setOptionsKey('imageManagerJson', $this->module->imageManagerJsonRoute);
        }
        if (isset($this->clientOptions['plugins']) && array_search('filemanager', $this->clientOptions['plugins']) !== false) {
            $this->setOptionsKey('fileUpload', $this->module->fileUploadRoute);
            $this->clientOptions['fileUploadErrorCallback'] = ArrayHelper::getValue($this->clientOptions, 'fileUploadErrorCallback', new JsExpression("function(json){alert(json.error);}"));
            $this->setOptionsKey('fileManagerJson', $this->module->fileManagerJsonRoute);
        }
    }

}
