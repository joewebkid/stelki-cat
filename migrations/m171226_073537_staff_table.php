<?php

use yii\db\Migration;

/**
 * Class m171226_073537_staff_table
 */
class m171226_073537_staff_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(\app\modules\staff\models\Staff::tableName(), [
            'id' => $this->string(36)->notNull(),
            'login' => $this->string()->notNull()->unique(),
            'pwhash' => $this->string(),
            'status' => $this->boolean()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull()->unsigned(),
            'updated_at' => $this->integer()->notNull()->unsigned(),
        ]);
        $this->addPrimaryKey('PK_id', \app\modules\staff\models\Staff::tableName(), 'id');
        $this->createIndex('IDX_status', \app\modules\staff\models\Staff::tableName(), 'status');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable(\app\modules\staff\models\Staff::tableName());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171226_073537_staff_table cannot be reverted.\n";

        return false;
    }
    */
}
