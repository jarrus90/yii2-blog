<?php

namespace jarrus90\Blog\Widgets;

use yii\base\InvalidConfigException;
use Yii;

class Redactor extends \yii\redactor\widgets\Redactor {

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

}
