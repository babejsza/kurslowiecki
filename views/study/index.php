<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
?>
<h1>study/index</h1>

<p>
    <?php if(Yii::$app->user->isGuest) : ?>
    może byś się zalogował?
    <?php endif ?>
</p>

<p>kliknij <a href="<?= Url::toRoute(['study/new']) ?>">link</a> jeżeli chcesz rozpocząć nowy test</p>
