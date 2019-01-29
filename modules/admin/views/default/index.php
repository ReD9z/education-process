<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\ListView;

$this->title = 'Сообщения';
?>
<div class="row">
	<div class="col-md-8">
	    <div class="panel panel-default">
	        <div class="panel-body">
	            <?php $form = ActiveForm::begin(); ?>
	                <?= $form->field($model, 'groups_id')->dropDownList($arrGroups)->label(false) ?>
	                <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Заголовок'])->label(false) ?>
	                <?= $form->field($model, 'text')->textarea(['rows' => 2, 'placeholder' => 'Сообщение'])->label(false) ?>
	                <div class="form-group">
	                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
	                </div>
	            <?php ActiveForm::end(); ?>
	        </div>
	    </div>  
	    <?= ListView::widget([
	            'dataProvider' => $messages,
	            'summary' => false,
	            'options' => false,
	            'itemOptions' => ['class' => 'panel panel-default'],
	            'emptyText' => '<div class="list-group-item">Сообщения отсутствуют!</div>',
	            'itemView' => function ($model, $key, $index, $widget) {
	                return 
	                    $model->panelBody($model).
	                    $model->panelFooter($model)
	                ;
	            },
	        ]) 
	    ?>
	</div>

	<div class="col-md-4">
	    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Профиль</h3>
        </div>
        <div class="panel-body">
            <?= ListView::widget([
                    'dataProvider' => $profile,
                    'summary' => false,
                    'options' => false,
                    'itemOptions' => ['class' => 'thumbnail'],
                    'itemView' => function ($model, $key, $index, $widget) {
                        return $model->profileGet($model);
                    },
                ]) 
            ?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Пользователи</h3>
        </div>
        <div class="panel-body">
            <? echo $this->render('_search', ['model' => $usersSearch]); ?>
            <?php Pjax::begin(['id' => 'users-list']); ?>
                <?= ListView::widget([
                        'dataProvider' => $users,
                        'summary' => false,
                        'options' => ['tag' => 'ul','class' => 'list-group'],
                        'itemOptions' => false,
                        'itemView' => function ($model, $key, $index, $widget) {
                         	if ($model->id == Yii::$app->user->identity->id) {
                                return ' ';
                            }
                            else {
                                return 
                                	'<li class="list-group-item">'.
	                                    $model->profileIcon($model).
	                                    $model->chatIcon($model).
	                                    $model->username.'<br>'.
	                                    $model->role->name.
                                    '</li>'
                                ;
                            }
                        },
                    ]) 
                ?>   
            <?php Pjax::end(); ?>
        </div>
	</div>
</div>