<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Discipline */

$this->title = 'Добавить дисциплину';
$this->params['breadcrumbs'][] = ['label' => 'Учебный план', 'url' => ['/admin/plan']];
$this->params['breadcrumbs'][] = ['label' => 'Дисциплина', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discipline-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
