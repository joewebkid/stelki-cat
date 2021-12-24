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
                'name' => 'Главная, первый блок',
                'value' => 'Индивидуальные ортопедические стельки/Изготавливаются на заказ с выездом на дом'
            ],
            [
                'name' => 'Телефон внизу страницы',
                'value' => '8 495 669 39 91'
            ],
            [
                'name' => 'E-mail внизу страницы',
                'value' => 'info@stepfuture.ru'
            ],
            [
                'name' => 'Повседневные стельки, блок 1',
                'value' => 'Повседневные стельки/Для тех, кто весь день проводит на ногах'
            ],
            [
                'name' => 'Повседневные стельки, блок 2',
                'value' => 'Наши стельки изготавливаются индивидуально для вас с использованием самых современных технологий. Мы используем только сертифицированные и проверенные на качество материалы, которые имеют различную степень твердости'
            ],
            [
                'name' => 'Повседневные стельки, блок 3',
                'value' => 'Испытывая любой дискомфорт в ногах во время работы или в повседневной жизни, никогда не терпите неудобство!'
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