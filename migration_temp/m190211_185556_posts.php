<?php

use yii\db\Migration;

/**
 * Class m190211_185556_posts
 */
class m190211_185556_posts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=INNODB';
        }
        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'body' => $this->text()->notNull(),
            'date_created' => $this->timestamp(),//->defaultExpression('CURRENT_TIMESTAMP'), // ТАК НЕ ПИСАТИ
            'avtor_id'=>$this->integer()->unique()
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropTable('{{%post}}');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190211_185556_posts cannot be reverted.\n";

        return false;
    }
    */
}
