<?php
/* @var $this yii\web\View */

//use Yii;
?>
<h1>study/test</h1>

<?
$session = Yii::$app->session;

echo $session->get('test.status');

echo '<pre>';
print_r($_SESSION);
echo '</pre>';

echo '<pre>';
print_r($question);
echo '</pre>';

echo 'Odpowiedziano na: ' . $question_answered_number . ' z ' . $question_number;

//shuffle($question->answers->toArray());

echo '<pre>';
print_r($question->answers);
echo '</pre>';
?>


<div class="panel panel-default">
    <div class="panel-heading"><?= $question->title ?></div>
    <div class="panel-body">
        <? foreach($question->answers as $v) : ?>
        <div class="checkbox">
            <label>
                <input type="checkbox" value="">
                <?= $v->title ?>
            </label>
        </div>
        <? endforeach; ?>
    </div>
</div>

