<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Button;

/* @var $this yii\web\View */
/* @var $model app\models\Journals */

$this->title = 'Отметить студентов';
?>
<h2>Отметить студентов</h2>
<?php $form = ActiveForm::begin(); ?>
    <?= GridView::widget([
            'dataProvider' => $journals,
            'summary' => false,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label'=>'ФИО',
                    'content' => function($data){
                        return 
                        $data->users->username.
                        $data->journals->formAddStudent($data)
                        ;    
                        
                    }
                ],
                [
                    'label'=>'Оценка',
                    'content' => function($data){
                        return $data->journals->formAddEva();
                    }
                ],
                [
                    'label'=>'Посещение',
                    'content' => function($data){
                        return $data->journals->formAddVisit();
                    }
                ],
            ],
        ]); 
    ?>
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success'])?>
<?php ActiveForm::end(); ?>
