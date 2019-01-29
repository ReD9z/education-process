<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ChairSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Кафедра';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chair-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('Добавить кафедру', ['create'], ['class' => 'btn btn-success']) ?>
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
                'attribute'=>'institute_id',
                'value' => 'institute.full_name',
                'filter' => $arrInstitute,
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {view} {teachers} {delete}',
                'buttons' => [
                    'update' => function ($url) {
                        return Html::a(
                            '<i class="fa fa-pencil"></i>',
                            $url, ['class' => 'btn btn-primary btn-xs', 'title' => 'Редактировать']
                        );
                    },
                    'teachers' => function ($url) {
                        return Html::a(
                            '<i class="fa fa-users"></i>',
                            $url, ['class' => 'btn btn-success btn-xs', 'title' => 'Добавить в группу']
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