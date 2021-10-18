<?php
namespace app\widgets;

use Yii;

/**
 * Alert widget renders a message from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * ```php
 * Yii::$app->session->setFlash('error', 'This is the message');
 * Yii::$app->session->setFlash('success', 'This is the message');
 * Yii::$app->session->setFlash('info', 'This is the message');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * Yii::$app->session->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 *
 * @author 
 * @author 
 */
class Alert extends \yii\base\Widget
{

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        parent::run();
        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();        

        return $this->render('alert',compact('flashes','session'));
    }
}
