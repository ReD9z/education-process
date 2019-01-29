<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TypesTraining */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Учебный план', 'url' => ['/admin/plan']];
$this->params['breadcrumbs'][] = ['label' => 'Типы занятий', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="types-training-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
