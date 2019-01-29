<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Button;
/* @var $this yii\web\View */
/* @var $model app\models\Journals */

$this->title = 'Оплата за обучение';

$this->params['breadcrumbs'][] = 'Оплата за обучение';
?>
<?php if (count($model) == 0): ?>
    <p>
        <?= Html::a('Оплата', ['/admin/groups/price', 'groups' => $groups, 'course' => $course], ['class' => 'btn btn-primary']) ?>
    </p>
<?php endif;?>

<?= GridView::widget([
    'dataProvider' => $payment,
    'summary' => false,
    'options' => ['class' => 'table table-responsive'],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

            'students.users.username',
            [
                'label' => 'Статус оплаты',
                'content' => function($data){
                    if ($data->status == 1) {
                        return '<span class="badge list-group-item-success">Бюджетник</span>';
                    }

                    else if($data->status == 2) {
                        return '<span class="badge list-group-item-success">Оплатил</span>';
                    }

                    else if($data->status == 2) {
                        return '<span class="badge list-group-item-danger">Не оплатил</span>';
                    }
                }
            ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}',
            'buttons' => [
                'update' => function ($url, $data) {
                    return Html::a(
                        '<i class="fa fa-pencil"></i>',
                        [$url = Url::to(['/admin/groups/updateprice', 'id' => $data->id, 'groups' => $data->students->groups_id, 'course' => $data->course_id])],
                        ['class' => 'btn btn-primary btn-xs', 'title' => 'Редактировать']
                    );
                },
            ],
        ],
    ],
]); ?>
