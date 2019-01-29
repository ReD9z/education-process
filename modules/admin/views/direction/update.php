<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Direction */

$this->title = 'Обновить: ' . $model->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Направление обучения', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->full_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="direction-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
