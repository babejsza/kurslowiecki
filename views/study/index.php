<?php
/* @var $this yii\web\View */

use yii\helpers\Url;

?>
<h1>Twoja nauka</h1>

<p>
    <?php if (Yii::$app->user->isGuest) : ?>
    <p class="bg-info info">Jeżeli się zarejestrujesz i zalogujesz dostaniesz dostęp do swoich wczesniejszych wyników i
        mozliwość kontunuacji wcześniej rozpoczętego kursu!</p>
<?php endif ?>
</p>

<p class="text-right">
    <a class="btn btn-primary" href="<?= Url::toRoute(['study/new']) ?>"><span class="glyphicon glyphicon-plus"></span>
        Rozpocznij nowy test</a>
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

                        <a class="btn btn-warning btn-xs" href="<?= Url::toRoute(['study/continue/' . $v->id]) ?>">kontynuuj</a>

                </td>
            </tr>
        <?php endforeach ?>

        </tbody>
    </table>
<?php endif ?>
