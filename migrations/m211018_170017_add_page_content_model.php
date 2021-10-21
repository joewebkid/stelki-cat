<?php

use yii\db\Migration;
use app\models\PageContent;

/**
 * Class m211018_170017_add_page_content_model
 */
class m211018_170017_add_page_content_model extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%page_content}}', [
            'id' => $this->primaryKey()->comment('Id'),
            'name' => $this->string(100)->comment('Название блока'),
            'value' => $this->text()->comment('Наполнение блока'),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')
        ]);

        $blocks = [
            [
                'name' => 'О Компании, блок слева',
                'value' => 'Путешествуйте, занимайтесь спортом, посвящайте время любимым делам – мы позаботимся о ваших ощущениях и здоровье при любой активности. А наши специалисты ортопеды проконсультируют вас и помогут принять верное решение.'
            ],
            [
                'name' => 'О Компании, блок справа',
                'value' => 'Жизнь – это движение. Именно поэтому качество нашей жизни напрямую зависит от здоровья наших ног. Наша команда, состоящая из высококвалифицированных специалистов в области ортопедии и медицинской инженерии. Мы используем уникальную немецкую технологию по изготовлению индивидуальных стелек. Наша цель – сделать движение максимально комфортным и эффективным.'
            ],
            [
                'name' => 'Телефон внизу страницы',
                'value' => '8 800 456 23 78'
            ]
        ];

        foreach ($blocks as $block) {
            $object = new PageContent;
            $object->name = $block['name'];
            $object->value = $block['value'];
            $object->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%page_content}}');
        echo "m211018_170017_add_page_content_model cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211018_170017_add_page_content_model cannot be reverted.\n";

        return false;
    }
    */
}
// оплачен, формируется к отправке. ожидает оплаты