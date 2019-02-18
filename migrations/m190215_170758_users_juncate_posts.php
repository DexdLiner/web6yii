<?php

use yii\db\Migration;

/**
 * Class m190215_170758_users_juncate_posts
 */
class m190215_170758_users_juncate_posts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //one-to-many(many-to-one)
        $this->createIndex(
            'idx-posts_users-user_id',
            '{{%posts}}',
            'user_id'
        );
        $this->addForeignKey('fk-post_user-user_id',
            '{{%posts}}',
            'user_id',
            '{{%users}}',
            'id'
//            ,'CASCADE'
//            ,'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-post_user-user_id', '{{%posts}}');
        $this->dropIndex('idx-posts_users-post_id', '{{%posts}}');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190215_170758_users_juncate_posts cannot be reverted.\n";

        return false;
    }
    */
}
