<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\grid\GridView;

$this->params['breadcrumbs'][] = ['label' => 'Кафедра', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Добавить в кафедру';
?>

<?php if (Yii::$app->session->getFlash('success')): ?>
    <div class="alert alert-danger target-success"><?=Yii::$app->session->getFlash('success')?></div>
<?php endif;?>

<p>
    <?php 
        Modal::begin([
            'header' => '<h2>Добавить в кафедру</h2>',
            'toggleButton' => [
                'label' => 'Добавить',
                'class' => 'btn btn-success',
            ],
        ]);
    ?>
        <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'users_id')->dropDownList($arrUsers)->label(false) ?>
            <div class="form-group">
                <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    <?php Modal::end();?>
</p>

<?= GridView::widget([
        'dataProvider' => $teachers,
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'users.username',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{discipline} {del}',
                'buttons' => [
                    'discipline' => function ($url) {
                        return Html::a(
                            '<i class="fa fa-bars"></i>',
                            $url, ['class' => 'btn btn-info btn-xs', 'title' => 'Преподаваемые дисциплины']
                        );
                    },
                    'del' => function ($url, $dataProvider) {
                        return Html::a(
                        '<i class="fa fa-times"></i>',
                        [$url = Url::to(['/admin/chair/del','id' => $dataProvider->id, 'chair' => $dataProvider->chair_id])],
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