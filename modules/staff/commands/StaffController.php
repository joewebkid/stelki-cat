<?php

namespace app\modules\staff\commands;

use app\modules\staff\models\Staff;
use yii\console\Controller;
use yii\console\widgets\Table;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
use yii\helpers\VarDumper;

class StaffController extends Controller
{
    public $defaultAction = 'list';

    public function actionList()
    {
        $staff = Staff::find()
            ->all();

        $this->stdout(Table::widget([
            'headers' => ['ID', 'Login', 'Created At', 'Updated At'],
            'rows' => ArrayHelper::getColumn($staff,
                function (Staff $item) {
                    return array_values($item->toArray(['id', 'login', 'created_at', 'updated_at']));
                }),
        ]));

        return 0;
    }

    public function actionAdd(string $login, string $password = null)
    {
        $staff = new Staff([
            'login' => $login,
            'password' => $password,
            'status' => Staff::STATUS_ENABLED,
        ]);

        if (!$staff->save()) {
            $this->stderr(VarDumper::dumpAsString($staff->firstErrors) . PHP_EOL,
                Console::BOLD,
                Console::FG_RED);
            return 1;
        }

        $staff->refresh();

        $this->stdout(sprintf('Staff with login %s created', $this->ansiFormat($staff->login, Console::BOLD)) . PHP_EOL);
        return 0;
    }

    public function actionSetPassword(string $login, string $password)
    {
        if (!$staff = Staff::findOne(['login' => $login])) {
            return $this->stderr("User not found in DB");
        }

        $staff->setPassword($password);
        if (!$staff->save()) {
            $this->stderr(VarDumper::dumpAsString($staff->firstErrors) . PHP_EOL,
                Console::BOLD,
                Console::FG_RED);
            return 1;
        }

        $this->stdout("Password set!" . PHP_EOL, Console::BOLD);
        return 0;
    }
}
