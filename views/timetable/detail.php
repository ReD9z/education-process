<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ListView;

$this->title = 'Расписание';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= ListView::widget([
    'dataProvider' => $timetable,
    'summary' => false,
    'options' => ['class' => 'list-group'],
    'itemOptions' => false,
    'itemView' => function ($model, $key, $index, $widget) {
        return $model->listArr($model);
    },
]) 
?>

<?= ListView::widget([
    'dataProvider' => $timetable,
    'summary' => false,
    'options' => ['class' => 'list-group'],
    'itemOptions' => false,
    'itemView' => function ($model, $key, $index, $widget) {
        return $model->listFiles($model);
    },
]) 
?>