<?php

namespace app\controllers\user;

use dektrium\user\controllers\AdminController as BaseAdminController,
    dektrium\user\models\UserSearch,
    Yii,
    yii\helpers\Url;

class AdminController extends BaseAdminController
{
    public function actionIndex()
    {
        Url::remember('', 'actions-redirect');
        $searchModel = Yii::createObject(UserSearch::className());
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
}