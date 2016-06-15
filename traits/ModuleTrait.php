<?php

namespace jarrus90\Blog\traits;

use jarrus90\Blog\Module;

/**
 * Trait ModuleTrait
 * @property-read Module $module
 * @package jarrus90\Content\traits
 */
trait ModuleTrait {

    /**
     * @return Module
     */
    public function getModule() {
        return \Yii::$app->getModule('blog');
    }

}
