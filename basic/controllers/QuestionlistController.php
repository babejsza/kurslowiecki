<?php

namespace app\controllers;

use Yii;
use app\models\Question;
use app\models\QuestionSearch;
use yii\data\ActiveDataProvider;
use yii\data\Sort;
//use app\models\QuestionQuery;

class QuestionlistController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = Question::find()->with('answers')->where(['active' => 1]);

        $searchModel = new QuestionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
