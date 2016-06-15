<?php

namespace jarrus90\Blog;

use Yii;
use yii\i18n\PhpMessageSource;
use yii\base\BootstrapInterface;
use yii\console\Application as ConsoleApplication;

/**
 * Bootstrap class registers module and user application component. It also creates some url rules which will be applied
 * when UrlManager.enablePrettyUrl is enabled.
 */
class Bootstrap implements BootstrapInterface {


    /** @inheritdoc */
    public function bootstrap($app) {
        /** @var Module $module */
        /** @var \yii\db\ActiveRecord $modelName */
        if ($app->hasModule('blog') && ($module = $app->getModule('blog')) instanceof Module) {
            Yii::$container->setSingleton(BlogFinder::className(), [
                'tagQuery' => \jarrus90\Blog\Models\Tag::find(),
                'postQuery' => \jarrus90\Blog\Models\Post::find(),
                'commentQuery' => \jarrus90\Blog\Models\Comment::find(),
            ]);

            if (!$app instanceof ConsoleApplication) {
                $module->controllerNamespace = 'jarrus90\Blog\Controllers';
                $configUrlRule = [
                    'prefix' => $module->urlPrefix,
                    'rules' => $module->urlRules,
                ];
                if ($module->urlPrefix != 'blog') {
                    $configUrlRule['routePrefix'] = 'blog';
                }
                $configUrlRule['class'] = 'yii\web\GroupUrlRule';
                $rule = Yii::createObject($configUrlRule);
                $app->urlManager->addRules([$rule], false);
            }
            if (!isset($app->get('i18n')->translations['blog*'])) {
                $app->get('i18n')->translations['blog*'] = [
                    'class' => PhpMessageSource::className(),
                    'basePath' => __DIR__ . '/messages',
                    'sourceLanguage' => 'en-US'
                ];
            }

            $app->params['yii.migrations'][] = '@jarrus90/Blog/migrations/';
        }
    }

}
