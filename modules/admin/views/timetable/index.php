<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use \yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TimetableSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Расписание';
$this->params['breadcrumbs'][] = ['label' => 'Группа', 'url' => ['/admin/groups']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="timetable-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="timetable-index">
  
        <?Modal::begin();?>
            <div id="modal-add"></div>
        <?Modal::end(); ?>
     
    </div>

    <?php foreach ($training as $training_value): ?>
        <div class="block-color">
            <?=$training_value->name?> - <div class="block-bg" style="background: <?=$training_value->color?>"></div>
        </div>  
    <?php endforeach;?>
    

    <?= \yii2fullcalendar\yii2fullcalendar::widget([
        'events' => $events,
        'header' => [
           'right' => 'basicWeek, basicDay, month',
           'left' => 'prev,next'
        ],
        'defaultView' => 'month',
        'options' => [
            'lang' => 'ru',
        ],
    ]);
    ?>
</div>