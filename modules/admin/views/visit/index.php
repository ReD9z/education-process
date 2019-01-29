<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статус посещений';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visit-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => 'Статус посещений {count} из {totalCount}',
        'options' => ['class' => 'table table-responsive'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'name',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {view} {delete}',
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
