<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Semester */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Учебный план', 'url' => ['/admin/plan']];
$this->params['breadcrumbs'][] = ['label' => 'Семестр', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="semester-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
