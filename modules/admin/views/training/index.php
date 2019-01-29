<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TrainingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Типы занятий';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="types-training-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => 'Типы занятий {count} из {totalCount}',
        'options' => ['class' => 'table table-responsive'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute'=>'color',
                'content' => function($data){
                    return '<div style="background:'. $data->color .'; height:30px; text-align:center;border:1px solid #000;color:#fff">'.$data->color.'</div>';
                }
            ],
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
