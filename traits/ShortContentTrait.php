<?php

namespace jarrus90\Blog\traits;

use jarrus90\Blog\Module;

/**
 * Trait ModuleTrait
 * @property-read Module $module
 * @package jarrus90\Content\traits
 */
trait ShortContentTrait {

    public function shorten($string, $length = 400){
        $temp = strip_tags($string);
        if(strlen($temp) > $length){
            $temp = substr($temp, 0, strrpos(substr($temp, 0, $length), ' '));
        }
        return $temp;
    }

}
