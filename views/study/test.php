<?php
$session = Yii::$app->session;
?>


<h1 class="page-header">
    Sprawdzian
    <?php if ($session['test']['status'] == 'db') : ?>
        <small>nr #<?= $session['test']['number_of_all_tests'] ?>
            (<?= Yii::$app->formatter->asDate($session['test']['created_at'], 'yyyy-MM-dd') ?>)
        </small>
    <?php endif ?>
</h1>

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
                <p><strong><?= $question->title ?>:</strong></p>
                <hr>
                <form action="" method="post">
                    <?php foreach ($question->answers as $v) : ?>
                        <div
                            class="
                            form-group form-group-radio
                            <?php if ($errors['bad_answer'] == $v->id) : ?>bg-danger has-error strong-text<?php endif ?>
                            <?php if ($question->correct_answer_id == $v->id && $post && empty($errors['answer'])) : ?>bg-success has-success strong-text<?php endif ?>
                            ">
                            <div class="radio">
                                <input type="radio"
                                       name="answer"
                                       id="radio<?= $v->id ?>"
                                       value="<?= $v->id ?>"
                                    <?php if (isset($post['answer'])) : ?>
                                        <?= $post['answer'] != $v->id ?: 'checked' ?>
                                    <?php endif; ?>
                                    <?php if ($post['do'] == 'check' && empty($errors['answer'])) : ?>
                                        disabled
                                    <?php endif; ?>>
                                <label for="radio<?= $v->id ?>"><?= $v->title ?></label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <hr>
                    <div class="form-group form-group-submit">
                        <button
                            type="submit"
                            name="do"
                            value="check"
                            class="btn btn-primary"
                            <?php if ($post['do'] == 'check' && empty($errors['answer'])) : ?>
                                disabled
                            <?php endif; ?>>
                            Sprawdź odpowiedź
                        </button>

                        <button
                            type="submit"
                            name="do"
                            value="next"
                            class="btn btn-success"
                            <?php if (!isset($post['answer'])) : ?>
                                disabled
                            <?php endif; ?>>
                            Przejdź dalej
                            <span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="true" style="top: 2px"></span>
                        </button>
                    </div>

                    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
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
    </div>
</div>