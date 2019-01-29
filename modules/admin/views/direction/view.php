<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Direction */

$this->title = $model->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Направление обучения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="direction-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            'full_name',
            'small_name',
            'chair.full_name',
            'study.name',
            'period',
        ],
    ]) ?>

</div>