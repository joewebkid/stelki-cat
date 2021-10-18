<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use \app\models\Messages;

$menu = [];
$i = 0;

foreach ($chats as $chatId => $chat) {

    $menu[$i] = ['label' => (!empty($chat['login']) ? $chat['login'] : $chat['email']), 'active' => $chat['id'] == $chat_id ? 'active' : '', 'url' => ['/cabinet/messages?chat=' . $chatId]];
    if (empty($menu[$i]['label'])) {
        $menu[$i]['label'] = 'User id: ' . $chatId;
    }

    if ($chat['new'] > 0 && $chat_id != $chat['id']) {
        $menu[$i]['label'] .= '<span class="new-messages-icon cabinet-mess">' . $chat['new'] . '</span>';
    }

    // $menu[$i] = ['label' => $label, 'url' => ['/cabinet/messages?chat=' . $chatId]];


    $i++;

}
?>
<div class="chats__users_container">
    <div class="chats__users">
        <?php foreach ($menu as $k => $v): ?>
            <?= Html::a($v['label'], $v['url'], ['class' => 'chats__href ' . $v['active']]) ?>
        <?php endforeach ?>
    </div>
</div>