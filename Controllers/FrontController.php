<?php

namespace jarrus90\Blog\Controllers;

use Yii;
use yii\helpers\Url;
use jarrus90\Blog\BlogFinder;
use jarrus90\Blog\Models\Tag;
use jarrus90\Blog\Models\Post;
use jarrus90\Blog\Models\Comment;
use jarrus90\Blog\Models\PostSearch;
use jarrus90\Core\Web\Controllers\FrontController as Controller;

class FrontController extends Controller {

    use \jarrus90\Core\Traits\AjaxValidationTrait;

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
    
    public function beforeAction($action) {
        if($action->id == 'posts') {
            Yii::$app->view->params['breadcrumbs'][] = Yii::t('blog', 'Blog');
        } else {
            Yii::$app->view->params['breadcrumbs'][] = [
                'label' => Yii::t('blog', 'Blog'),
                'url' => Url::toRoute(['/blog/front/posts'])
            ];
        }
        return parent::beforeAction($action);
    }

    public function actionPosts() {
        $filterModel = Yii::createObject([
                    'class' => PostSearch::className(),
                    'scenario' => 'search'
        ]);
        $request = Yii::$app->request->get();
        $request['active_from'] = time();
        return $this->render('posts', [
                    'finder' => $this->finder,
                    'filterModel' => $filterModel,
                    'dataProvider' => $filterModel->search($request),
        ]);
    }

    public function actionPost($key) {
        $post = $this->getPost($key);
        $commentForm = null;
        if ($post->comments_enabled) {
            $item = Yii::createObject([
                        'class' => Comment::className()
            ]);
            $commentForm = Yii::createObject([
                        'class' => Comment::className(),
                        'scenario' => 'create',
                        'item' => $item,
            ]);
            $commentForm->setAttributes([
                'created_by' => Yii::$app->user->id,
                'post_id' => $post->id
            ], false);
            $this->performAjaxValidation($commentForm);
            if ($commentForm->load(Yii::$app->request->post()) && $commentForm->save()) {
                return $this->refresh();
            }
        }
        return $this->render('post', [
                    'post' => $post,
                    'commentForm' => $commentForm
        ]);
    }

    protected function getPost($key) {
        $item = $this->finder->findPost(['key' => $key])->one();
        if ($item) {
            return $item;
        } else {
            throw new \yii\web\NotFoundHttpException(Yii::t('blog', 'The requested post does not exist'));
        }
    }

}
