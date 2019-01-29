<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\grid\GridView;
$this->params['breadcrumbs'][] = ['label' => 'Кафедра', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Добавить преподаваемую дисциплину';
?>

<?php if (Yii::$app->session->getFlash('success')): ?>
    <div class="alert alert-danger target-success"><?=Yii::$app->session->getFlash('success')?></div>
<?php endif;?>

<p>
    <?php 
        Modal::begin([
            'header' => '<h2>Добавить преподаваемую дисциплину</h2>',
            'toggleButton' => [
                'label' => 'Добавить',
                'class' => 'btn btn-success',
            ],
        ]);
    ?>
        <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'discipline_id')->dropDownList(ArrayHelper::map(\app\models\Discipline::find()->all(),'id','name'))->label(false) ?>
            <div class="form-group">
                <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    <?php Modal::end();?>
</p>

<?= GridView::widget([
        'dataProvider' => $TeachersDiscipline,
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'discipline.name',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{deld}',
                'buttons' => [
                    'deld' => function ($url, $dataProvider) {
                        return Html::a(
                        '<i class="fa fa-times"></i>',
                        [$url = Url::to(['/admin/chair/deld','id' => $dataProvider->id, 'chair' => $dataProvider->teachers_chair])],
                        ['class' => 'btn btn-danger btn-xs', 'title' => 'Удалить'],
                        [
                            'data' => [
                                'confirm' => 'Вы уверены, что хотите удалить студента из группы?',
                                'method' => 'post',
                            ],
                        ]);
                    },

                ],
            ],
        ],
    ]); 
?>