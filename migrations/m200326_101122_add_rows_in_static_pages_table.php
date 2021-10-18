<?php

use yii\db\Migration;

/**
 * Class m200326_101122_add_rows_in_static_pages_table
 */
class m200326_101122_add_rows_in_static_pages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('static_pages', 'position', $this->smallInteger(2)->after('url'));
        $this->addColumn('static_pages', 'active', $this->smallInteger(1)->after('url'));
        $this->addColumn('static_pages', 'priority', $this->smallInteger(1)->after('url'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('static_pages', 'position');
        $this->dropColumn('static_pages', 'active');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200326_101122_add_rows_in_static_pages_table cannot be reverted.\n";

        return false;
    }
    */
}
