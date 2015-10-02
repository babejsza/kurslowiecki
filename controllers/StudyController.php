<?php

namespace app\controllers;

use app\models\Question;
use app\models\TestUserQuestionAnswer;
use Yii;
use app\models\Test;
use DateTime;

class StudyController extends \yii\web\Controller
{
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
        $errors = [];
        $errors['answer'] = null;
        $errors['bad_answer'] = null;
        $post = null;

        $session = Yii::$app->session;
        $request = Yii::$app->request;
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

        $question = $this->getQuestion();


        if ($request->post('do')) {

            $post = $request->post();

            if (!$request->post('answer')) {
                $errors['answer'] = 'Musisz wprowadzić odpowiedź!';
            } else {

                if ($request->post('answer') != $question->correct_answer_id) {
                    $errors['bad_answer'] = $request->post('answer');
                } else {

                }
            }
        }

        $datetime1 = new DateTime($question->created_at);
        $datetime2 = new DateTime(date('Y-m-d H:i:s'));
        $interval = $datetime1->diff($datetime2);
        $diff = $interval->format('%adni %hh %Im');


        return $this->render('test', [
            'question' => $question,
            'question_number' => $question_number,
            'question_answered_number' => $question_answered_number,
            'time_spent' => $diff,
            'errors' => $errors,
            'post' => $post
        ]);
    }

    private function getQuestion()
    {
        $session = Yii::$app->session;

        $answered = $session['test']['answered'];
        if ($answered == null) {
            $answered = 0;
        }

        if (!isset($session['test']['actual_question'])) {
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

        return $question;
    }

}
