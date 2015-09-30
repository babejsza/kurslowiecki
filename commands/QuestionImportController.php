<?php

namespace app\commands;

use app\models\Answer;
use app\models\Question;
use app\models\User;
use yii\console\Controller;

/**
 * Import start questions
 *
 * @author Marcin Babecki
 */
class QuestionImportController extends Controller
{
    public function actionIndex()
    {
        $file = file_get_contents(__DIR__ . '/QuestionImport.txt');
        $line = explode("\n", $file);

        $array = [];
        foreach ($line as $k => $v) {
            $el = explode("\t", $v);
            $count_el = count($el);

            $array[$k]['title'] = $el[0];
            $array[$k]['occured_number'] = $el[1];
            $array[$k]['correct_answer_key'] = $el[2];
            for ($i = 3; $i < $count_el; $i++) $array[$k]['answer'][$i] = $el[$i];
            $array[$k]['number_of_elements'] = $count_el;
        }

        $user = User::findByUsername('admin');

        foreach ($array as $v) {
            $model_question = new Question();
            $model_question->title = $v['title'];
            $model_question->occured_number = $v['occured_number'];
            $model_question->correct_answer_id = '0';
            $model_question->author_id = $user->id;
            $model_question->save();

            $correct_answer_id = 0;
            foreach ($v['answer'] as $k2 => $v2) {
                $model_answer = new Answer();
                $model_answer->question_id = $model_question->id;
                $model_answer->title = $v2;
                $model_answer->author_id = $user->id;
                $model_answer->save();

                if ($k2 - 3 == $v['correct_answer_key']) $correct_answer_id = $model_answer->id;
            }

            $model_question->correct_answer_id = $correct_answer_id;
            $model_question->save();

        }
    }
}
