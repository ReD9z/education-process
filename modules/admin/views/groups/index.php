<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\GroupsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Группы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="groups-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('Добавить группу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => 'Группы {count} из {totalCount}',
        'options' => ['class' => 'table table-responsive'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'direction_id',
                'value' => 'direction.full_name',
                'filter' => $arrDirection,
            ],
            
            'name',
            'price',
            
            [
                'attribute'=>'course_id',
                'value' => 'course.name',
                'filter' => $arrCourse,
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {view} {statistics} {payment} {students} {timetable} {journals} {delete}',
                'buttons' => [
                    'update' => function ($url) {
                        return Html::a(
                            '<i class="fa fa-pencil"></i>',
                            $url, ['class' => 'btn btn-primary btn-xs', 'title' => 'Редактировать']
                        );
                    },
                    'view' => function ($url) {
                        return Html::a(
                            '<i class="fa fa-desktop"></i>',
                            $url, ['class' => 'btn btn-info btn-xs', 'title' => 'Просмотр']
                        );
                    },
                    'payment' => function ($url, $dataProvider) {
                        return Html::a(
                            '<i class="fa fa-credit-card"></i>',
                            [$url = Url::to(['/admin/groups/payment','groups' => $dataProvider->id, 'course' => $dataProvider->course_id])], 
                            ['class' => 'btn btn-success btn-xs', 'title' => 'Оплата за обучение']
                        );
                    },
                    'statistics' => function ($url) {
                        return Html::a(
                            '<i class="fa fa-area-chart"></i>',
                            $url, ['class' => 'btn btn-success btn-xs', 'title' => 'Cтатистика']
                        );
                    },
                    'students' => function ($url) {
                        return Html::a(
                            '<i class="fa fa-users"></i>',
                            $url, ['class' => 'btn btn-success btn-xs', 'title' => 'Список студентов']
                        );
                    },
                    'timetable' => function ($url, $dataProvider) {
                        return Html::a(
                            '<i class="fa fa-calculator"></i>',
                             [$url = Url::to(['/admin/timetable/index','groups' => $dataProvider->id, 'direction' => $dataProvider->direction_id])],
                             ['class' => 'btn btn-success btn-xs', 'title' => 'Расписание']
                        );
                    },
                    'journals' => function ($url, $dataProvider) {
                        return Html::a(
                            '<i class="fa fa-address-book"></i>',
                             [$url = Url::to(['/admin/journals/view','groups' => $dataProvider->id])],
                             ['class' => 'btn btn-success btn-xs', 'title' => 'Журнал']
                        );
                    },
                    'delete' => function ($url) {
                        return Html::a(
                            '<i class="fa fa-times"></i>',
                            $url, [
                                'class' => 'btn btn-danger btn-xs', 
                                'title' => 'Удалить',
                                'data' => [
                                    'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                                    'method' => 'post',
                                ],
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>

</div>
