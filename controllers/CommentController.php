<?php

namespace jarrus90\Blog\controllers;

use Yii;
use yii\base\Module as BaseModule;
use jarrus90\Blog\BlogFinder;
use jarrus90\Core\Web\Controllers\AdminCrudAbstract;

class CommentController extends AdminCrudAbstract {

    /**
     * @var BlogFinder 
     */
    protected $finder;
    protected $modelClass = 'jarrus90\Blog\Models\Comment';
    protected $formClass = 'jarrus90\Blog\Models\Comment';
    protected $searchClass = 'jarrus90\Blog\Models\CommentSearch';

    /**
     * @param string  $id
     * @param BaseModule $module
     * @param BlogFinder  $finder
     * @param array   $config
     */
    public function __construct($id, $module, BlogFinder $finder, $config = []) {
        $this->finder = $finder;
        parent::__construct($id, $module, $config);
    }
    
    public function beforeAction($action) {
        Yii::$app->view->params['breadcrumbs'][] = Yii::t('blog', 'Blog');
        if($action->id == 'index') {
            Yii::$app->view->params['breadcrumbs'][] = Yii::t('blog', 'Comments');
        } else {
            Yii::$app->view->params['breadcrumbs'][] = [
                'label' => Yii::t('blog', 'Comments'),
                'url' => ['index']
            ];
        }
        return parent::beforeAction($action);
    }

    public function actionCreate() {
        Yii::$app->view->title = Yii::t('blog', 'Create comment');
        return parent::actionCreate();
    }

    public function actionUpdate($id) {
        Yii::$app->view->title = Yii::t('blog', 'Edit comment');
        return parent::actionUpdate($id);
    }

    public function actionBlock($id) {
        $model = $this->getItem($id);
        if($model->is_blocked) {
            $model->block(Yii::$app->user->id);
        } else {
            $model->unblock(Yii::$app->user->id);
        }
        return $this->redirect(['update', 'id' => $model->id]);
    }

    protected function getItem($id) {
        $item = $this->finder->findComment(['id' => $id])->one();
        if ($item) {
            return $item;
        } else {
            throw new \yii\web\NotFoundHttpException(Yii::t('blog', 'The requested comment does not exist'));
        }
    }

}
