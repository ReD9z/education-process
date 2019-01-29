<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\bootstrap\Modal;
use yii\bootstrap\ButtonDropdown;

$this->title = 'Сообщения';
?>

<?Modal::begin([
    'size' => 'modal-lg',
]);?>
<div id="modal-add"></div>
<?Modal::end(); ?>
<div class="row">
    <div class="col-md-7">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php $form = ActiveForm::begin(); ?>
                    <?php if (Yii::$app->user->identity->role_id == 1): ?>
                        <?= $form->field($model, 'groups_id')->dropDownList($arrGroups)->label(false) ?>
                        <?php elseif(Yii::$app->user->identity->role_id == 2): ?>
                        <?= $form->field($model, 'groups_id')->hiddenInput(['value' => $groups_id])->label(false); ?>
                        <?php elseif(Yii::$app->user->identity->role_id == 3): ?>
                        <?= $form->field($model, 'groups_id')->dropDownList($arrGroupsTeachers)->label(false) ?>
                    <?php endif ?>
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
    <div class="col-md-5">
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
                <?php if (Yii::$app->user->identity->role_id == 1): ?>
                    <h3 class="panel-title">Группы</h3>
                <?php else: ?>
                    <h3 class="panel-title">Расписание на сегодня</h3>
                <?php endif ?>
            </div>
            <div class="panel-body">
                <?php if (Yii::$app->user->identity->role_id == 1): ?>
                    <?= ListView::widget([
                            'dataProvider' => $groups,
                            'summary' => false,
                            'options' => ['class' => 'timetable'],
                            'itemOptions' => [
                                'tag' => 'div',
                            ],
                            'itemView' => function ($model, $key, $index, $widget) {
                                $dateToDay = date('Y.m.d');
                                return 
                                ButtonDropdown::widget([
                                    'label' =>  $model->groupsName(),
                                    'options' => ['class' => 'btn btn-default', 'style' => 'margin-bottom:10px; width:100%'],
                                    'containerOptions' => ['style'=> 'width:100%;'],
                                    'dropdown' => [
                                        'items' => [
                                            ['label' => 'Расписание', 'url' => ['timetable/view', 'id' => $model->id]],
                                            ['label' => 'Журнал', 'url' => ['journals/view', 'groups' => $model->id]],
                                            ['label' => 'Статистика', 'url' => ['site/statistics', 'id' => $model->id]],
                                        ],
                                    ],
                                ]);
                            },
                        ]) 
                    ?>
                <?php endif;?>  
                <?php if (Yii::$app->user->identity->role_id == 2 || Yii::$app->user->identity->role_id == 3): ?>
                    <?= ListView::widget([
                            'dataProvider' => $timetable,
                            'summary' => false,
                            'options' => ['class' => 'timetable'],
                            'itemOptions' => [
                                'tag' => 'div',
                            ],
                            'emptyText' => '<div class="well well-lg"><h4>На сегодня занятий нет!</h4></div>',
                            'itemView' => function ($model, $key, $index, $widget) {
                                 return $model->accessList($model, Yii::$app->user->identity->role_id);
                                
                            },
                        ]) 
                    ?>
                <?php endif;?>
                <?php if (Yii::$app->user->identity->role_id == 2): ?>
                    <p style="">
                        <?= Html::a('Расписание подробнее',
                                ['/timetable/view', 'id' => $groups_id],
                                ['class' => 'btn btn-default', 'title' => 'Расписание подробнее', 'style' => 'display: block; margin: auto;']
                            );
                        ?>
                    </p>
                <?php endif;?>
            </div>
        </div> 
        <?php if (Yii::$app->user->identity->role_id == 1): ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                   <h3 class="panel-title">Преподаватели</h3>
                </div>
                <div class="panel-body">
                    <? echo $this->render('_searchteachers.php', ['model' => $teachersSearch]); ?>
                    <?php Pjax::begin(['id' => 'teacher-list']); ?>
                        <?= ListView::widget([
                                'dataProvider' => $teachers,
                                'summary' => false,
                                'options' => ['tag' => 'ul','class' => 'list-group'],
                                'itemOptions' => false,
                                'itemView' => function ($model, $key, $index, $widget) {
                                    return ButtonDropdown::widget([
                                        'label' =>  $model->users->username,
                                        'options' => ['class' => 'btn btn-default', 'style' => 'margin-bottom:10px; width:100%'],
                                        'containerOptions' => ['style'=> 'width:100%;'],
                                        'dropdown' => [
                                            'items' => [
                                                ['label' => 'Расписание', 'url' => ['timetable/view', 'users' => $model->users_id]],
                                                ['label' => 'Журнал', 'url' => ['journals/view', 'users' => $model->users_id]],
                                            ],
                                        ],
                                    ]);
                                },
                            ]) 
                        ?>
                    <?php Pjax::end(); ?>
                </div>
            </div> 
        <?php endif;?>
        <?php if (Yii::$app->user->identity->role_id == 2): ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Статистика</h3>
                </div>
                <div class="panel-body">
                    <h4>Занятия</h4>
                    <?= ListView::widget([
                            'dataProvider' => $statistics,
                            'summary' => false,
                            'options' => ['tag' => 'ul','class' => 'list-group'],
                            'itemOptions' => false,
                            'itemView' => function ($model, $key, $index, $widget) {
                                return $model->journalsStat($model, '/site');
                            },
                        ]) 
                    ?>
                    <h4>Сессия</h4>
                    <?= ListView::widget([
                            'dataProvider' => $statistics,
                            'summary' => false,
                            'options' => ['tag' => 'ul','class' => 'list-group'],
                            'itemOptions' => false,
                            'itemView' => function ($model, $key, $index, $widget) {
                                return $model->recordStat($model, '/site');
                            },
                        ])
                    ?>
                    <h4>Оплата за обучение</h4>
                    <?= ListView::widget([
                            'dataProvider' => $payment,
                            'summary' => false,
                            'options' => ['tag' => 'ul','class' => 'list-group'],
                            'itemOptions' => ['tag' => 'li','class' => 'list-group-item'],
                            'itemView' => function ($model, $key, $index, $widget) {
                                return 
                                    $model->course->name.
                                    $model->paymentGet($model)
                                ;
                            },
                        ]) 
                    ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php if (Yii::$app->user->identity->role_id == 1 || Yii::$app->user->identity->role_id == 3): ?>
                    <h3 class="panel-title">Пользователи</h3>
                <?php endif;?>
                <?php if (Yii::$app->user->identity->role_id == 2): ?>
                    <h3 class="panel-title">Моя группа <?=Html::a($usersGroups, ['site/statistics', 'id' => $groups_id])?></h3>
                <?php endif;?>
            </div>
            <div class="panel-body">
                <?php if (Yii::$app->user->identity->role_id == 1 || Yii::$app->user->identity->role_id == 3): ?>
                    <? echo $this->render('_search', ['model' => $usersSearch]); ?>
                    <?php Pjax::begin(['id' => 'users-list']); ?>
                        <?= ListView::widget([
                                'dataProvider' => $users,
                                'summary' => false,
                                'options' => ['tag' => 'ul','class' => 'list-group'],
                                'itemOptions' => false,
                                'itemView' => function ($model, $key, $index, $widget) {
                                    if ($model->id == Yii::$app->user->identity->id) {
                                        return '';
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
                <?php endif;?>
                <?php if (Yii::$app->user->identity->role_id == 2): ?>
                    <?php Pjax::begin(['id' => 'users-list']); ?>
                        <?= ListView::widget([
                                'dataProvider' => $users,
                                'summary' => false,
                                'options' => ['tag' => 'ul','class' => 'list-group'],
                                'itemOptions' => false,
                                'itemView' => function ($model, $key, $index, $widget) {
                                    if ($model->users_id == Yii::$app->user->identity->id) {

                                    }
                                    else {
                                        return 
                                            '<li class="list-group-item">'.
                                                $model->users->profileIcon($model->users).
                                                $model->users->chatIcon($model->users).
                                                $model->users->username.'<br>'.
                                                $model->users->role->name.
                                            '</li>'
                                        ;
                                  
                                    }
                                },
                            ]) 
                        ?>   
                    <?php Pjax::end(); ?>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>
