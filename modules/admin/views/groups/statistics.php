<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\ListView;
use yii\bootstrap\ButtonDropdown;
use yii\widgets\Pjax;

$this->title = 'Статистика';
$this->params['breadcrumbs'][] = ['label' => 'Группы', 'url' => ['groups/index']];
$this->params['breadcrumbs'][] = 'Статистика ' . $groups->groupsName();
?>
<?Modal::begin([
    'size' => 'modal-lg',
]);?>
<div id="modal-add"></div>
<?Modal::end(); ?>

<h2>Группа <?=$groups->groupsName();?></h2>
<div class="row">
<?php Pjax::begin(); ?>
    <?= ListView::widget([
            'dataProvider' => $students,
            'summary' => false,
            'options' => false,
            'itemOptions' => ['tag' => 'ul','class' => 'list-group'],
            'itemView' => function ($model, $key, $index, $widget) {
                return
                    '<div class="col-md-4">'.
                        '<div class="thumbnail">'.
                            '<div class="caption">'.
                                '<li class="list-group-item">'.
                                    '<div class="text-center">'.
                                    Html::img('/uploads/'.$model->users->profiles->image, ['style' => 'width: 100px; display: block; margin:auto;']).
                                    ButtonDropdown::widget([
                                        'label' =>  $model->users->username,
                                        'options' => ['class' => 'btn btn-default'],
                                        'dropdown' => [
                                            'items' => [
                                                ['label' => 'Профиль', 'url' => ['default/profile', 'id' => $model->users_id]],
                                                ['label' => 'Чат', 'url' => ['default/chat', 'id' => $model->users_id]],
                                            ],
                                        ],
                                    ]).
                                    '</div>'.
                                    '<li class="list-group-item"><b>Отзывы: </b>'.$model->users->recommend($model->users).'</li>'.
                                '</li>'.
                                '<div class="alert alert-success">Студент</div>'.
                                $model->journalsStat($model, 'groups').
                                '<div class="alert alert-info">Лекции</div>'.
                                $model->recordStat($model, 'groups').
                                '<div class="alert alert-warning">Сессия</div>'.
                                $model->paymentStat($model).
                            '</div>'.
                        '</div>'.
                    '</div>'
                ;
            },
        ]) 
    ?>
<?php Pjax::end(); ?> 
</div>
