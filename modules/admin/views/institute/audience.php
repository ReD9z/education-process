<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\grid\GridView;

$this->params['breadcrumbs'][] = ['label' => 'Институт', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Добавить аудиторию';
?>

<?php if (Yii::$app->session->getFlash('success')): ?>
    <div class="alert alert-danger target-success"><?=Yii::$app->session->getFlash('success')?></div>
<?php endif;?>

<p>
    <?php 
        Modal::begin([
            'header' => '<h2>Добавить аудиторию</h2>',
            'toggleButton' => [
                'label' => 'Добавить',
                'class' => 'btn btn-success',
            ],
        ]);
    ?>
        <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'name')->textInput()->label(false) ?>
            <div class="form-group">
                <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    <?php Modal::end();?>
</p>

<?= GridView::widget([
        'dataProvider' => $audience,
        'summary' => false,
        'options' => ['class' => 'table table-responsive'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{del}',
                'buttons' => [
                    'del' => function ($url, $dataProvider) {
                        return Html::a(
                        '<i class="fa fa-times"></i>',
                        [$url = Url::to(['/admin/institute/del','id' => $dataProvider->id, 'institute' => $dataProvider->institute_id])],
                        ['class' => 'btn btn-danger btn-xs', 'title' => 'Удалить'],
                        [
                            'data' => [
                                'confirm' => 'Вы уверены, что хотите удалить аудиторию?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]); 
?>