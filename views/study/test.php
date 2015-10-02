<?php
/* @var $this yii\web\View */

$session = Yii::$app->session;
?>


<?


//echo $session->get('test.status');

//echo '<pre>';
//print_r($_SESSION);
//echo '</pre>';
//
//echo '<pre>';
//print_r($question);
//echo '</pre>';


//shuffle($question->answers->toArray());

//echo '<pre>';
//print_r($question->answers);
//echo '</pre>';
?>

<h1>Test</h1>

<?php if ($errors['answer']) : ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-danger">
                <?= $errors['answer'] ?>
            </div>
        </div>
    </div>
<?php endif ?>

<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default question">
            <div class="panel-heading">Pytanie #<?= $question_answered_number + 1 ?></div>
            <div class="panel-body">
                <p><?= $question->title ?>:</p>

                <form action="" method="post">
                    <? foreach ($question->answers as $v) : ?>
                        <div class="form-group form-group-radio
                            <?php if ($errors['bad_answer'] == $v->id) : ?>bg-danger has-error strong-text<?php endif ?>
                            <?php if ($question->correct_answer_id == $v->id && $post) : ?>bg-success has-success strong-text<?php endif ?>
                            ">
                            <div class="radio">
                                <input type="radio"
                                       name="answer"
                                       id="radio<?= $v->id ?>"
                                       value="<?= $v->id ?>"
                                    <?= $post['answer'] != $v->id ?: 'checked' ?>
                                    >
                                <label for="radio<?= $v->id ?>"><?= $v->title ?></label>
                            </div>
                        </div>
                    <? endforeach; ?>
                    <div class="form-group form-group-submit">
                        <button type="submit" name="do" value="check" class="btn btn-primary">Sprawdź odpowiedź</button>
                    </div>
                    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading">
                Stan testu
            </div>
            <div class="panel-body">

                <dl class="dl-horizontal">
                    <dt>Odpowiedziano na:</dt>
                    <dd><?= $question_answered_number ?> z <?= $question_number ?></dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Data rozpoczęcia:</dt>
                    <dd><?= $question->created_at ?></dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Czas rozwiązywania:</dt>
                    <dd><?= $time_spent ?></dd>
                </dl>
            </div>
        </div>
    </div>
</div>




