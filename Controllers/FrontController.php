<?php

namespace jarrus90\Blog\Controllers;

use Yii;
use jarrus90\Blog\BlogFinder;
use jarrus90\Core\Web\Controllers\FrontController as Controller;

class FrontController extends Controller {

    /**
     * @var ContentFinder 
     */
    protected $finder;

    /**
     * @param string  $id
     * @param BaseModule $module
     * @param ContentFinder  $finder
     * @param array   $config
     */
    public function __construct($id, $module, BlogFinder $finder, $config = []) {
        $this->finder = $finder;
        parent::__construct($id, $module, $config);
    }

    public function actionPosts() {
        
    }

    public function actionTags() {
        
    }

    public function actionPost($key) {
        $post = $this->finder->findPost(['key' => $key])->one();
        return $this->render('post', [
            'post' => $post
        ]);
    }

}
