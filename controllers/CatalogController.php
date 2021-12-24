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
        $block4 = PageContent::findOne(7)->value;
        $explodedBlock4String = explode('/', $block4);
        $block4 = [
            $explodedBlock4String[0], 
            ((count($explodedBlock4String) > 1) ? $explodedBlock4String[1] : '')
        ];
        $block5 = PageContent::findOne(8)->value;
        $explodedBlock5String = explode('/', $block5);
        $block5 = [
            $explodedBlock5String[0], 
            ((count($explodedBlock5String) > 1) ? $explodedBlock5String[1] : '')
        ];
        $block6 = PageContent::findOne(9)->value;
        $explodedBlock6String = explode('/', $block6);
        $block6 = [
            $explodedBlock6String[0], 
            ((count($explodedBlock6String) > 1) ? $explodedBlock6String[1] : '')
        ];
        $block7 = PageContent::findOne(10)->value;
        $explodedBlock7String = explode('/', $block7);
        $block7 = [
            $explodedBlock7String[0], 
            ((count($explodedBlock7String) > 1) ? $explodedBlock7String[1] : '')
        ];
        $block8 = PageContent::findOne(11)->value;
        $explodedBlock8String = explode('/', $block8);
        $block8 = [
            $explodedBlock8String[0], 
            ((count($explodedBlock8String) > 1) ? $explodedBlock8String[1] : '')
        ];
        $signFormModel = new BidForm();

        return $this->render('daily', compact(
            'block1',
            'block2',
            'block3',
            'block4',
            'block5',
            'block6',
            'block7',
            'block8',
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