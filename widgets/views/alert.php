<?php
foreach ($flashes as $type => $flash) {
    // if (!isset($this->alertTypes[$type])) {
    //     continue;
    // }

    foreach ((array) $flash as $i => $message) {

$script = <<< JS
new Noty({
    type: "$type",
    text: "$message",
    animation: {
        open: 'animated bounceInRight', // Animate.css class names
        close: 'animated bounceOutRight' // Animate.css class names
    },
    timeout: 5500
}).show();
JS;
$this->registerJs($script);
        // echo \yii\bootstrap\Alert::widget([
        //     'body' => $message,
        //     'closeButton' => $this->closeButton,
        //     'options' => array_merge($this->options, [
        //         'id' => $this->getId() . '-' . $type . '-' . $i,
        //         'class' => $this->alertTypes[$type] . $appendClass,
        //     ]),
        // ]);
    }

    $session->removeFlash($type);
}