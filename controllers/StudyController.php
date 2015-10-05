<?php

namespace app\controllers;

use app\models\Answer;
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
            $test_model->created_at = date('Y-m-d H:i:s');
            $test_model->save();

            $number_of_all_tests = Test::find()->where(['user_id' => Yii::$app->user->id])->count();

            $session->set('test', [
                    'status' => 'db',
                    'active_test_id' => $test_model->id,
                    'answered' => null,
                    'test_data' => $test_model,
                    'created_at' => $test_model->created_at,
                    'number_of_all_tests' => $number_of_all_tests
                ]
            );
        } else {
            $session->set('test', [
                    'status' => 'no_db',
                    'active_test_id' => 1,
                    'answered' => null,
                    'created_at' => date('Y-m-d H:i:s')
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

    public function actionNextquestion()
    {
        $session = Yii::$app->session;
        if (!$session->isActive) {
            $session->open();
        }

        unset($_SESSION['test']['actual_question']);
        $this->redirect('do');
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

        if (!isset($session['test'])) {
            $this->redirect('new');
            exit;
        }

        $answered = $session['test']['answered'];
        $difference = 0;
        if ($answered == null) {
            $answered = 0;
            $difference = 1;
        }

        $e = explode(',', $answered);
        if ($request->post('check')) {
            $actual_question = array_search($session['test']['actual_question'], $e);
            unset($e[$actual_question]);
        }

        $question_answered_number = count($e) - $difference;

        $question_number = Question::find()
            ->where(['question.active' => 1])
            ->count();

        if ($question_answered_number == $question_number) {
            if (!Yii::$app->user->isGuest) {
                $test_model = Test::findOne($session['test']['active_test_id']);
                $test_model->ended_at = date('y-m-d H:i:s');
                $test_model->update();

                $this->redirect(['results', 'id' => 2]);
            } else $this->redirect(['results', 'id' => 0]);
        }

        $question = $this->getQuestion();


        if ($request->post('do')) {
            $post = $request->post();

            if (!$request->post('answer')) {
                $errors['answer'] = 'Musisz wprowadzić odpowiedź!';
            } else {
                if ($request->post('answer') != $question->correct_answer_id) {
                    $errors['bad_answer'] = $request->post('answer');
                }
                $ea = explode(',', $session['test']['answered']);
                $ea[] = $question->id;
                $ea = array_filter($ea);
                $ea = array_unique($ea);
                $_SESSION['test']['answered'] = implode(',', $ea);

                if ($request->post('answer') == $question->correct_answer_id) {
                    $ec = [];
                    if (isset($session['test']['answered_correctly'])) {
                        $ec = explode(',', $session['test']['answered_correctly']);
                    }
                    $ec[] = $question->id;
                    $ec = array_filter($ec);
                    $ec = array_unique($ec);
                    $_SESSION['test']['answered_correctly'] = implode(',', $ec);
                }

                $_SESSION['test']['answers'][$question->id] = $request->post('answer');

                if (!Yii::$app->user->isGuest) {
                    $model_tuqa = new TestUserQuestionAnswer();
                    $model_tuqa->test_id = $session['test']['active_test_id'];
                    $model_tuqa->user_id = Yii::$app->user->id;
                    $model_tuqa->question_id = $question->id;
                    $model_tuqa->answer_id = $request->post('answer');
                    $model_tuqa->save();
                }
            }
        }

        if ($request->post('do') == 'next') {
            $this->redirect('nextquestion');
        }

        $datetime1 = new DateTime($session['test']['created_at']);
        $datetime2 = new DateTime(date('Y-m-d H:i:s'));
        $interval = $datetime1->diff($datetime2);
        $diff = $interval->format('%adni %hh %Im');

        $answered_correctly = isset($session['test']['answered_correctly']) ? $session['test']['answered_correctly'] : 0;

        if ($answered_correctly != 0) {
            $number_of_correct_answers = count(explode(',', $answered_correctly));
        } else {
            $number_of_correct_answers = 0;
        }
        $percent_of_correct_answers = $answered_correctly > 0 ? (count(explode(',',
                    $answered_correctly)) / count(explode(',', $session['test']['answered']))) * 100 : 0;
        $percent_of_correct_answers = Yii::$app->formatter->asDecimal($percent_of_correct_answers, 1);

        return $this->render('test', [
            'question' => $question,
            'question_number' => $question_number,
            'question_answered_number' => $question_answered_number,
            'time_spent' => $diff,
            'errors' => $errors,
            'post' => $post,
            'number_of_correct_answers' => $number_of_correct_answers,
            'percent_of_correct_answers' => $percent_of_correct_answers
        ]);
    }

    public function actionResults()
    {
        return $this->render('results');
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

            $_SESSION['test']['actual_question'] = $question->id;

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
