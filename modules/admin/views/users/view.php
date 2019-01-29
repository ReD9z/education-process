<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'login',
            'username',
            'date',
            [
                'attribute' => 'role.name',
                'content' => function($data){
                    return $data->role->name;
                }
            ],
            [
                'attribute' => 'profiles.address',
                'label'=>'Адрес',
                'content' => function($data){
                    return $data->profiles->address;
                }
            ],
            [
                'attribute' => 'profiles.phone',
                'label'=>'Телефон',
                'content' => function($data){
                    return $data->profiles->phone;
                }
            ],
            [
                'attribute' => 'profiles.email',
                'label'=>'Email',
                'content' => function($data){
                    return $data->profiles->email;
                }
            ],
            [
                'attribute' => 'profiles.image',
                'format' => 'html',
                'value' => function($data){
                    return Html::img(Url::toRoute('/uploads/'.$data->profiles->image),[
                        'alt'=>'Аватар',
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
        ],
    ]) ?>
</div>
