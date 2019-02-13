<?php

use yii\db\Migration;

/**
 * Class m190213_174952_alterposts
 */
class m190213_174952_alterposts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('{{%users}}', 'email', $this->text());

        $this->dropColumn('{{%users}}', 'body');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%users}}', 'body', $this->text());
        $this->dropColumn('{{%users}}', 'email');

        return true;
//        echo "m190213_174952_alterposts cannot be reverted.\n";

//        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190213_174952_alterposts cannot be reverted.\n";

        return false;
    }
    */
}
