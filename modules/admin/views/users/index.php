<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);?>

    <p>
        <?= Html::a('Роли пользователей', ['/admin/role'], ['class' => 'btn btn-primary btn-sm']) ?>
    </p>
    <p>
        <?= Html::a('Создать пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => 'Пользователи {count} из {totalCount}',
        'options' => ['class' => 'table table-responsive'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'login',
            'username',
            [
                'attribute' => 'role_id',
                'value' => 'role.name',
                'filter' => $arrRole,
            ],
            [
                'attribute' => 'profiles.address',
                'value' => 'profiles.address',
            ],
            [
                'attribute' => 'profiles.phone',
                'value' => 'profiles.phone',
            ],
            [
                'attribute' => 'profiles.email',
                'value' => 'profiles.email',
            ],
            [
                'attribute' => 'profiles.image',
                'content' => function($data){
                    return Html::img(Url::toRoute('/uploads/'.$data->profiles->image),[
                        'width' => '100px',
                    ]);
                }
            ],
            // [
            //     'attribute' => 'password',
            //     'format' => 'html',
            //     'value' => function($data)
            //     {
            //         return '***********';
            //     },
            // ],
            'date',
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
                                'class' => 'btn btn-danger btn-xs', 'title' => 'Удалить',
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


