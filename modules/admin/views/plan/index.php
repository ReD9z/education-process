<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PlanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Учебный план';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => 'Учебный план {count} из {totalCount}',
        'options' => ['class' => 'table table-responsive'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute'=>'discipline_id',
                    'value' => 'discipline.name',
                ],
                [
                    'attribute'=>'direction_id',
                    'value' => 'direction.full_name',
                    'filter' => $arrDirection,
                ],
                [
                    'attribute'=>'course_id',
                    'value' => 'course.name',
                ],
                [
                    'attribute'=>'semester_id',
                    'value' => 'semester.name',
                ],
                'time',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {view} {choice} {delete}',
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
                    'choice' => function ($url) {
                        return Html::a(
                            '<i class="fa fa-book"></i>',
                            $url, ['class' => 'btn btn-success btn-xs', 'title' => 'Добавить тип занятия']
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

