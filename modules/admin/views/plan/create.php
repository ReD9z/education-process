<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Plan */

$this->params['breadcrumbs'][] = ['label' => 'Учебный план', 'url' => ['index']];

?>
<div class="plan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
