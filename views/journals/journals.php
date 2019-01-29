<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $model app\models\Journals */

$this->title = 'Студенты' . $timetable->groups->groupsName();
$this->params['breadcrumbs'][] = 'Студенты '. $timetable->groups->groupsName();
?>
<?Modal::begin([
    'size' => 'modal-lg',
]);?>
<div id="modal-add"></div>
<?Modal::end(); ?>
<h1><?=$timetable->groups->groupsName()?></h1>
<div class="panel panel-default">
    <div class="panel-heading"><?=$timetable->plan->discipline->name?> (<?=$timetable->trainingChoice->typesTraining->name?>) <?=$timetable->couple->name?></div>
    <div class="panel-body">
        <?= GridView::widget([
            'emptyText' => Html::tag('p', 'Отметить студентов', ['data-target'=> '/journals/create?groups='.$groups.'&timetable='.$timetable->id, 'class' => 'btn btn-primary form-action']),
            'dataProvider' => $dataProvider,
            'summary' => false,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                    'students.users.username',
                [
                    'label'=>'Оценка',
                    'content' => function($data){
                        return $data->evaluation->name;
                    }
                ],

                [
                    'label'=>'Посещение',
                    'content' => function($data){
                        return $data->visit->name;
                    }
                ],
                
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update}',
                    'buttons' => [
                        'update' => function ($url, $data) {
                            return Html::tag('p', '<i class="fa fa-pencil"></i>', 
                            ['data-target' => '/journals/update?id='.$data->id, 'class' => 'btn btn-primary btn-xs form-action', 'title' => 'Редактировать']);
                        },
                    ],
                ],
            ],
        ]); ?>
    </div>
</div>