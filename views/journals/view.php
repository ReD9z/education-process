<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Journals */

$this->title = 'Журнал';
$this->params['breadcrumbs'][] = 'Журнал';
?>
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

