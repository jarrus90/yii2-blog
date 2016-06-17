<?php

namespace jarrus90\Blog\traits;

use jarrus90\Blog\Module;

/**
 * Trait ModuleTrait
 * @property-read Module $module
 * @package jarrus90\Content\traits
 */
trait StorageTrait {

    /**
     * @return Module
     */
    public function getStorage() {
        return $this->module->storage;
    }

}
