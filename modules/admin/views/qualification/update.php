<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Qualification */

$this->title = 'Обновить: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Направление обучения', 'url' => ['/admin/direction']];
$this->params['breadcrumbs'][] = ['label' => 'Квалификация обучения', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="qualification-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
