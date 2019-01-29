<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->params['breadcrumbs'][] = ['label' => 'Группа', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Посещение (лекции)';
?>
<?php Pjax::begin(); ?>
    <?= GridView::widget([
            'dataProvider' => $journals,
            'summary' => false,
            'options' => ['class' => 'table table-responsive stat-record'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'students.users.username',
                'timetable.plan.discipline.name',
                'visit.name',
                [
                    'attribute' => 'evaluation.name',
                    'content' => function($data){
                        if ($data->evaluation_id == null) {
                            return '-';
                        }else {
                            return $data->evaluation->name;
                        }
                    }
                ],
                'timetable.users.username',
                'timetable.trainingChoice.typesTraining.name',
                [
                    'label' => 'Дата',
                    'content' => function($data){
                       return $data->date;
                    }
                ],
            ],
        ]); 
    ?>
<?php Pjax::end(); ?>