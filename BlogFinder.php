<?php

namespace jarrus90\Blog;

use yii\base\Object;
use yii\db\ActiveQuery;

/**
 * ContentFinder provides some useful methods for finding active record models.
 */
class BlogFinder extends Object {

    /** @var ActiveQuery */
    protected $tagQuery;

    /** @var ActiveQuery */
    protected $postQuery;

    /** @var ActiveQuery */
    protected $commentQuery;

    /**
     * @return ActiveQuery
     */
    public function getTagQuery() {
        return $this->tagQuery;
    }

    /**
     * @return ActiveQuery
     */
    public function getPostQuery() {
        return $this->postQuery;
    }

    /**
     * @return ActiveQuery
     */
    public function getCommentQuery() {
        return $this->commentQuery;
    }

    /** @param ActiveQuery $tagQuery */
    public function setTagQuery(ActiveQuery $tagQuery) {
        $this->tagQuery = $tagQuery;
    }

    /** @param ActiveQuery $postQuery */
    public function setPostQuery(ActiveQuery $postQuery) {
        $this->postQuery = $postQuery;
    }

    /** @param ActiveQuery $commentQuery */
    public function setCommentQuery(ActiveQuery $commentQuery) {
        $this->commentQuery = $commentQuery;
    }

    /**
     * Finds a tag by the given condition.
     *
     * @param mixed $condition Condition to be used on search.
     *
     * @return \yii\db\ActiveQuery
     */
    public function findTag($condition) {
        return $this->tagQuery->where($condition);
    }

    /**
     * Finds a post by the given condition.
     *
     * @param mixed $condition Condition to be used on search.
     *
     * @return \yii\db\ActiveQuery
     */
    public function findPost($condition) {
        return $this->postQuery->where($condition);
    }

    /**
     * Finds a post by the given condition.
     *
     * @param mixed $condition Condition to be used on search.
     *
     * @return \yii\db\ActiveQuery
     */
    public function findComment($condition) {
        return $this->commentQuery->where($condition);
    }

}
