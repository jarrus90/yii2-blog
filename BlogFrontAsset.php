<?php

/**
 * Class AppAsset
 *
 * Asset for frontend
 * 
 * @package app\modules\core\Assets
 */

namespace jarrus90\Blog;

use yii\web\AssetBundle;

/**
 * AppAsset
 * 
 * Basic application asset
 */
class BlogFrontAsset extends AssetBundle {

    /**
     * Default path
     * @var string
     */
    public $sourcePath = '@jarrus90/Blog/assets/front/';

    /**
     * List of available js files
     * @var array
     */
    public $js = [
        'js/blog.js',
    ];

    /**
     * List of available css files
     * @var array
     */
    public $css = [
        'css/blog.css',
    ];

    /**
     * Dependent packages
     * @var array
     */
    public $depends = [
        'yii' => 'yii\web\YiiAsset'
    ];

}
