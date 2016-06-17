<?php

namespace jarrus90\Blog\Widgets;

use jarrus90\Blog\BlogFinder;

class Sidebar extends \yii\base\Widget {

    protected $finder;
    public $panelsList = [
        'tags',
        'posts',
        'comments'
    ];
    protected $_availablePanels = [
        'tags',
        'posts',
        'comments'
    ];

    public function __construct(BlogFinder $finder, $config = []) {
        $this->finder = $finder;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function init() {
        foreach ($this->panelsList AS $key => $item) {
            if (!in_array($item, $this->_availablePanels)) {
                unset($this->panelsList[$key]);
            }
        }
    }

    public function getPanels() {
        $panels = [];
        foreach ($this->panelsList AS $item) {
            $name = 'get' . ucfirst($item) . 'Panel';
            $panels[$item] = $this->$name();
        }
        return $panels;
    }

    /**
     * @inheritdoc
     */
    public function run() {
        return $this->render('@jarrus90/Blog/views/widgets/sidebar', ['widget' => $this]);
    }

    public function getTagsPanel() {
        //$tags = $this->finder->tagQuery
        return;
    }

    public function getPostsPanel() {
        $posts = $this->finder->postQuery->orderBy(['id' => SORT_DESC])->where([])->limit(2)->all();
        return $this->render('@jarrus90/Blog/views/widgets/sidebarPanelPosts', ['posts' => $posts]);
    }

    public function getCommentsPanel() {
        $comments = $this->finder->commentQuery->with(['user', 'post'])->where([])->orderBy(['id' => SORT_DESC])->limit(2)->all();
        return $this->render('@jarrus90/Blog/views/widgets/sidebarPanelComments', ['comments' => $comments]);
    }

}
