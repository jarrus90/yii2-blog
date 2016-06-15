<?php

namespace jarrus90\Blog\Controllers;

use Yii;
use yii\base\Module as BaseModule;
use jarrus90\Blog\BlogFinder;
use jarrus90\Core\Web\Controllers\AdminCrudAbstract;

class TagController extends AdminCrudAbstract {

    /**
     * @var BlogFinder 
     */
    protected $finder;
    protected $modelClass = 'jarrus90\Blog\Models\Tag';
    protected $formClass = 'jarrus90\Blog\Models\Tag';
    protected $searchClass = 'jarrus90\Blog\Models\Tag';

    /**
     * @param string  $id
     * @param BaseModule $module
     * @param BlogFinder  $finder
     * @param array   $config
     */
    public function __construct($id, $module, BlogFinder $finder, $config = []) {
        $this->finder = $finder;
        Yii::$app->view->params['breadcrumbs'][] = Yii::t('blog', 'Blog');
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'Tags'), 'url' => ['index']];
        parent::__construct($id, $module, $config);
    }

    public function actionCreate() {
        Yii::$app->view->title = Yii::t('blog', 'Create tag');
        return parent::actionCreate();
    }

    public function actionUpdate($id) {
        $item = $this->getItem($id);
        Yii::$app->view->title = Yii::t('blog', 'Edit tag {title}', ['title' => $item->title]);
        return parent::actionUpdate($id);
    }

    protected function getItem($id) {
        $item = $this->finder->findTag(['id' => $id])->one();
        if ($item) {
            return $item;
        } else {
            throw new \yii\web\NotFoundHttpException(Yii::t('blog', 'The requested tag does not exist'));
        }
    }

}
