<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $model app\models\Timetable */

$this->title = 'Расписание';
$this->params['breadcrumbs'][] = 'Расписание';
?>
<div class="timetable-view">
    
    <h1><?= Html::encode($this->title) ?></h1>
    
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
    <?Modal::begin();?>
        <div id="modal-add"></div>
    <?Modal::end(); ?>
</div>
