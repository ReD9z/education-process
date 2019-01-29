<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Visit */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Статус посещений', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
