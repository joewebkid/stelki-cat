<?php

use yii\db\Migration;

/**
 * Class m200304_130210_add_rows_in_users
 */
class m200304_130210_add_rows_in_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'email', $this->string(200));
        $this->addColumn('users', 'email_newsletter', $this->smallInteger(1));
        $this->addColumn('users', 'sms_newsletter', $this->smallInteger(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('users', 'email');
        $this->dropColumn('users', 'email_newsletter');
        $this->dropColumn('users', 'sms_newsletter');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200304_130210_add_rows_in_users cannot be reverted.\n";

        return false;
    }
    */
}
