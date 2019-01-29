<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Chair */

$this->title = 'Обновить кафедру: ' . $model->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Кафедра', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->full_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="chair-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
