<?php
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\web\View;
use yii\bootstrap\Modal;
use yii\grid\ActionColumn;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */

$this->title = Yii::t('study', 'Results');
$this->params['breadcrumbs'][] = $this->title;

$session = Yii::$app->session;
?>


    <h1><?= Yii::t('study', 'Results') ?></h1>

    <div class="panel panel-info">
        <div class="panel-heading">
            Stan sprawdzianu
        </div>
        <div class="panel-body">

            <dl class="dl-horizontal">
                <dt>Odpowiedziano na:</dt>
                <dd><?= $question_answered_number ?> z <?= $question_number ?></dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>Poprawnych:</dt>
                <dd><?= $number_of_correct_answers ?> (<?= $percent_of_correct_answers ?>%)</dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>Data rozpoczęcia:</dt>
                <dd><?= $session['test']['created_at'] ?></dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>Czas rozwiązywania:</dt>
                <dd><?= $time_spent ?></dd>
            </dl>
        </div>
    </div>

<?php Pjax::begin() ?>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>Question</th>
            <th>Answers</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($questions as $v) : ?>
            <tr class="<?= $v->correct_answer_id == $v->testUserQuestionAnswers[0]->answer_id ? 'success' : '' ?>">
                <td><?= $v->title ?></td>

                <td>
                    <ul>
                        <?php foreach ($v->answers as $v2) : ?>
                            <?php
                            $class = '';
                            if ($v->testUserQuestionAnswers[0]->answer_id == $v2->id) {
                                $class = 'text-danger strong-text';
                            }
                            if ($v->correct_answer_id == $v2->id) {
                                $class = 'text-success strong-text';
                            }
                            ?>
                            <li class="<?= $class ?>">
                                <?= $v2->title ?>
                            </li>
                        <?php endforeach ?>

                    </ul>
                </td>


            </tr>
        <?php endforeach ?>

        </tbody>
    </table>
<?php Pjax::end() ?>