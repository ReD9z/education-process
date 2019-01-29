<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\grid\GridView;

$this->params['breadcrumbs'][] = ['label' => 'Группа', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Добавить в группу';
?>

<?php if (Yii::$app->session->getFlash('success')): ?>
    <div class="alert alert-danger target-success"><?=Yii::$app->session->getFlash('success')?></div>
<?php endif;?>

<p>
    <?php 
        Modal::begin([
            'header' => '<h2>Добавить студента в группу</h2>',
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
        'dataProvider' => $students,
        'summary' => false,
        'options' => ['class' => 'table table-responsive'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'users.username',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{del}',
                'buttons' => [
                    'del' => function ($url, $dataProvider) {
                        return Html::a(
                        '<i class="fa fa-times"></i>',
                        [$url = Url::to(['/admin/groups/del','id' => $dataProvider->id, 'groups' => $dataProvider->groups_id])],
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


