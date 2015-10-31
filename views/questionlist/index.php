<?php
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\web\View;
use yii\bootstrap\Modal;
use yii\grid\ActionColumn;

/* @var $this yii\web\View */

$this->title = Yii::t('questions', 'Question list');
$this->params['breadcrumbs'][] = $this->title;
?>



<h1><?= Yii::t('questions', 'Question list') ?></h1>

<?php Pjax::begin() ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  	=> $searchModel,
    'layout'  		=> "{items}\n{pager}",
    'columns' => [
        'title',
        [
            'attribute' => 'answers',
            'format' => 'raw',
            'value' => function ($model) {

                $cont = '';
                $cont .= '<ul>';
                foreach ($model->answers as $value) {
                    $cont .= '<li style="' . ($model->correct_answer_id == $value->id ? 'color: ForestGreen; font-weight: bold' : '') . '">' . $value->title . '</li>';
                }
                $cont .= '</ul>';

                return $cont;
            }
        ],
        /*[
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
            'headerOptions' => ['width' => '20%', 'class' => 'activity-view-link',],
            'contentOptions' => ['class' => 'padding-left-5px'],

            'buttons' => [
                'update' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-star-empty"></span>','/branches/update?id='.$key.'', [
                        'class' => 'activity-view-link',
                        'title' => Yii::t('yii', 'Update'),
                        'data-toggle' => 'modal',
                        'data-target' => '#activity-modal',
                        'data-id' => $key,
                        'data-pjax' => '0',

                    ]);
                },
            ],


        ],
        */
    ],
]) ?>

<?php Pjax::end() ?>

