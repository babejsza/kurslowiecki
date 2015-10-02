<?php

namespace app\controllers;

use app\models\Question;
use app\models\TestUserQuestionAnswer;
use Yii;
use app\models\Test;

class StudyController extends \yii\web\Controller
{
    public function _construct()
    {

    }

    public function actionIndex()
    {


        return $this->render('index');
    }


    public function actionNew()
    {
        $session = Yii::$app->session;
        $request = Yii::$app->request;
        if (!$session->isActive) {
            $session->open();
        }

        //session_destroy();
        //$session->destroy();
        $session->remove('test');

        if (!Yii::$app->user->isGuest) {
            $test_model = new Test();
            $test_model->user_id = Yii::$app->user->id;
            $test_model->save();
            $session->set('test', [
                    'status' => 'db',
                    'active_test_id' => $test_model->id,
                    'answered' => null
                ]
            );
        } else {
            $session->set('test', [
                    'status' => 'no_db',
                    'active_test_id' => 1,
                    'answered' => null
                ]
            );
        }


        $this->redirect('do');
    }

    public function actionContinue()
    {

        $session = Yii::$app->session;
        $request = Yii::$app->request;
        if (!$session->isActive) {
            $session->open();
        }

        if (!$session->has('test.answered')) {
            if ($session['test']['status'] == 'db') {
                $answered = TestUserQuestionAnswer::find()
                    ->where(['test_id' => $session['test']['active_test_id']])
                    ->all();

                $a = [];
                foreach ($answered as $v) {
                    $a[] = $v->id;
                }

                $session['test'] += ['answered' => implode(',', $a)];
            }
        }
    }

    public function actionNext()
    {

    }


    public function actionDo()
    {
        $session = Yii::$app->session;
        //$request = Yii::$app->request;
        if (!$session->isActive) {
            $session->open();
        }

        $answered = $session['test']['answered'];
        $difference = 0;
        if ($answered == null) {
            $answered = 0;
            $difference = 1;
        }

        $e = explode(',', $answered);
        $question_answered_number = count($e) - $difference;

        $question_number = Question::find()
            ->where(['question.active' => 1])
            ->count();

        if (!$session['test']['actual_question']) {
            $question = Question::find()
                ->joinWith('answers')
                ->where(['question.active' => 1])
                ->andWhere(['NOT IN', 'question.id', [$answered]])
                ->orderBy('RAND()')
                ->one();

            $session['test'] += ['actual_question' => $question->id];

        } else {
            $question = Question::find()
                ->joinWith('answers')
                ->where(['question.active' => 1])
                ->andWhere(['question.id' => $session['test']['actual_question']])
                ->one();
        }


        return $this->render('test', [
            'question' => $question,
            'question_number' => $question_number,
            'question_answered_number' => $question_answered_number
        ]);
    }

}
