<?php

namespace app\controllers;

use Yii;
use app\controllers\SiteController;
use app\models\BidForm;
use app\models\PageContent;
use yii\web\Controller;

class CatalogController extends SiteController
{
    public function actionIndex()
    {
        $signFormModel = new BidForm();

        return $this->render('index', compact(
            'signFormModel'
        ));
    }

    public function actionDaily()
    {
        $block1 = PageContent::findOne(4)->value;
        $explodedBlock1String = explode('/', $block1);
        $block1 = [
            $explodedBlock1String[0], 
            ((count($explodedBlock1String) > 1) ? $explodedBlock1String[1] : '')
        ];
        $block2 = PageContent::findOne(5)->value;
        $block3 = PageContent::findOne(6)->value;
        $signFormModel = new BidForm();

        return $this->render('daily', compact(
            'signFormModel'
        ));
    }

    public function actionSport()
    {
        $signFormModel = new BidForm();

        return $this->render('sport', compact(
            'signFormModel'
        ));
    }

    public function actionChildren()
    {
        $signFormModel = new BidForm();

        return $this->render('children', compact(
            'signFormModel'
        ));
    }

    public function actionDiabetics()
    {
        $signFormModel = new BidForm();

        return $this->render('diabetics', compact(
            'signFormModel'
        ));
    }
}