<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Timetable */

$this->title = 'Обновить расписание';
?>
<div class="timetable-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'arrPlan' => $arrPlan,
        'arrChoice' => $arrChoice,
        'groups' => $groups,
        'direction' => $direction,
        'arrUsers' => $arrUsers,
        'instituteArr' => $instituteArr,
        'institutes' => $institutes,
        'arrAudiences' => $arrAudiences,
    ]) ?>
    
    <?= Html::a('Удалить', ['/admin/timetable/delete', 'id' => $model->id, 'groups' => $groups, 'direction' => $direction], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
            'method' => 'post',
        ],
    ]) ?>

</div>
