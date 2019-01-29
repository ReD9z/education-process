<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\TrainingChoice */
/* @var $form ActiveForm */

$this->title = 'Добавить тип занятия';
$this->params['breadcrumbs'][] = ['label' => 'Учебный план', 'url' => ['/admin/plan']];
$this->params['breadcrumbs'][] = ['label' => 'Добавить тип занятия'];
?>
<?php if (Yii::$app->session->getFlash('success')): ?>
    <div class="alert alert-danger target-success"><?=Yii::$app->session->getFlash('success')?></div>
<?php endif;?>
<div class="choice">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'types_training_id')->dropDownList(ArrayHelper::map(\app\models\TypesTraining::find()->all(),'id','name'))->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- choice -->
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'options' => ['class' => 'table table-responsive'],
    'summary' => false,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'typesTraining.name',
            [

            'class' => 'yii\grid\ActionColumn',
            'template' => '{files} {delch}',
            'buttons' => [
                'files' => function ($url, $dataProvider) {
                     return Html::a(
                        '<i class="fa fa-files-o"></i>',
                        [$url = Url::to(['/admin/plan/files', 'training' => $dataProvider->id, 'plan' => $dataProvider->plan_id])],
                        ['class' => 'btn btn-success btn-xs', 'title' => 'Добавить файл']
                    );
                },
                'delch' => function ($url, $dataProvider) {
                    return Html::a(
                    '<i class="fa fa-times"></i>',
                    [$url = Url::to(['/admin/plan/delch','id' => $dataProvider->id,'plan' => $dataProvider->plan_id])],
                    ['class' => 'btn btn-danger btn-xs', 'title' => 'Удалить'],
                    [
                        'data' => [
                            'confirm' => 'Вы уверены, что хотите удалить файл?',
                            'method' => 'post',
                        ],
                    ]);
                },
            ], 
        ],
    ],
]); 
?>
  