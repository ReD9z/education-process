<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InstituteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Институты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="institute-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('Создать институт', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['class' => 'table table-responsive'],
        'summary' => 'Институты {count} из {totalCount}',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'full_name',
            'small_name',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {view} {audience} {delete}',
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
                    'audience' => function ($url) {
                        return Html::a(
                            '<i class="fa fa-university"></i>',
                            $url, ['class' => 'btn btn-success btn-xs', 'title' => 'Аудитории']
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
