<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Couple */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Группа', 'url' => ['/admin/groups']];
$this->params['breadcrumbs'][] = ['label' => 'Номер занятия', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="couple-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
