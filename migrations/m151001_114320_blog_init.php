<?php
namespace jarrus90\Blog\migrations;

use Yii;

class m151001_114320_blog_init extends \yii\db\Migration {

    /**
     * Create tables.
     */
    public function up() {

        $tableOptions = null;
        if (Yii::$app->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%blog_post}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string(255)->notNull(),
            'title' => $this->string(255)->notNull(),
            'image' => $this->string(255)->notNull(),
            'content' => $this->text()->notNull(),
            'active_from' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'comments_count' => $this->integer()->defaultValue(0),
            'comments_enabled' => $this->boolean()->defaultValue(true),
        ], $tableOptions);
        $this->createIndex('idx-blog_post-key', '{{%blog_post}}', 'key');
        $this->createIndex('idx-blog_post-title', '{{%blog_post}}', 'title');
        $this->createIndex('idx-blog_post-active_from', '{{%blog_post}}', 'active_from');
        $this->createIndex('idx-blog_post-created_by', '{{%blog_post}}', 'created_by');

        $this->createTable('{{%blog_tag}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string(255)->notNull(),
            'title' => $this->string(255)->notNull(),
            'content' => $this->text()->notNull()
        ], $tableOptions);
        $this->createIndex('idx-blog_tag-key', '{{%blog_tag}}', 'key');
        
        $this->createTable('{{%blog_tag_post}}', [
            'post_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addPrimaryKey('blog_tag', '{{%blog_tag_post}}', ['tag_id', 'post_id']);
        $this->addForeignKey('fk-blog_tag_post-tag', '{{%blog_tag_post}}', 'tag_id', '{{%blog_tag}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-blog_tag_post-post', '{{%blog_tag_post}}', 'post_id', '{{%blog_post}}', 'id', 'CASCADE', 'RESTRICT');
        

        $this->createTable('{{%blog_comment}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->notNull(),
            'parent_id' => $this->integer(),
            'content' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'is_blocked' => $this->boolean()->defaultValue(false),
            'blocked_by' => $this->integer(),
            'blocked_at' => $this->integer()
        ], $tableOptions);
        $this->createIndex('idx-blog_comment-post_id', '{{%blog_comment}}', 'post_id');
        $this->createIndex('idx-blog_comment-parent_id', '{{%blog_comment}}', 'parent_id');
        $this->createIndex('idx-blog_comment-created_by', '{{%blog_comment}}', 'created_by');
        $this->createIndex('idx-blog_comment-blocked_by', '{{%blog_comment}}', 'blocked_by');
        $this->addForeignKey('fk-blog_comment-post', '{{%blog_comment}}', 'post_id', '{{%blog_post}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-blog_comment-parent', '{{%blog_comment}}', 'parent_id', '{{%blog_comment}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * Drop tables.
     */
    public function down() {
        $this->dropTable('{{%blog_comment}}');
        $this->dropTable('{{%blog_tag_post}}');
        $this->dropTable('{{%blog_post}}');
        $this->dropTable('{{%blog_tag}}');
    }

}
