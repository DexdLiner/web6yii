<?php

use yii\db\Migration;

/**
 * Class m190213_184158_comments
 */
class m190213_184158_comments extends Migration
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
        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'post_id' => $this->integer()->notNull(),
            'body' => $this->text()->notNull(),
            'date_created' => $this->timestamp()->defaultValue(null),
            'date_updated' => $this->timestamp()->defaultValue(null)

        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%comments}}');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190213_184158_comments cannot be reverted.\n";

        return false;
    }
    */
}
