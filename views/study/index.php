<?php
/* @var $this yii\web\View */

use yii\helpers\Url;

?>
<h1>Twoje </h1>

<p>
    <?php if (Yii::$app->user->isGuest) : ?>
        może byś się zalogował?
    <?php endif ?>
</p>

<p class="text-right">
    <a class="btn btn-primary" href="<?= Url::toRoute(['study/new']) ?>"><span class="glyphicon glyphicon-plus"></span> Rozpocznij nowy test</a>
</p>

<?php if (!Yii::$app->user->isGuest) : ?>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>Test</th>
            <th>Data rozpoczęcia</th>
            <th>Data zakończenia</th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($tests as $v) : ?>
            <tr>
                <td>test #<?= $v->id ?></td>
                <td><?= $v->created_at ?></td>
                <td><?= $v->ended_at ?></td>
                <td>
                    <a class="btn btn-info btn-xs" href="<?= Url::toRoute(['study/results/' . $v->id]) ?>">wyniki</a>
                    <?php if ($v->id == $last->id) : ?>
                        <a class="btn btn-warning btn-xs" href="<?= Url::toRoute(['study/do/']) ?>">kontynuuj</a>
                    <?php endif ?>
                </td>
            </tr>
        <?php endforeach ?>

        </tbody>
    </table>
<?php endif ?>
