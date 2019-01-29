<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AdminAsset;

AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    
    <?php
    NavBar::begin([
        'brandLabel' => 'Панель администратора',
        'brandUrl' => '/admin',
        'options' => [
            'class' => 'navbar-default navbar-fixed-top',
        ],
        'innerContainerOptions' => ['class' => 'container-fluid'],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Перейти на сайт', 'url' => ['/site/index']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Войти', 'url' => ['/site/login']]
            ) : (
                [    
                    'label' => Yii::$app->user->identity->username,
                    'items' => [
                        ['label' => 'Профиль', 'url' => ['/admin/default/profile', 'id' => Yii::$app->user->identity->id]],
                        ['label' => 'Выйти', 'url' => '/site/logout', ['class' => 'btn btn-link logout'], 'linkOptions' => ['data-method' => 'post']],
                    ],
                ]
            )
        ],
    ]);
    NavBar::end(); 
    ?>
    <div class="left-nav">
        <?php
            echo Nav::widget([
                'options' => ['class' => 'nav nav-pills nav-stacked'],
                'items' => [
                    ['label' => 'Сообщения', 'url' => ['/admin/default/index']],
                    ['label' => 'Пользователи', 'url' => ['/admin/users/index']],
                    ['label' => 'Институт', 'url' => ['/admin/institute/index']],
                    ['label' => 'Кафедра', 'url' => ['/admin/chair/index']],
                    ['label' => 'Направление', 'url' => ['/admin/direction/index']],
                    ['label' => 'Группы', 'url' => ['/admin/groups/index']],
                    ['label' => 'Учебный план', 'url' => ['/admin/plan/index']],
                    [
                        'label' => 'Настройки',
                        'items' => [
                            ['label' => 'Курс', 'url' => '/admin/course/index'],
                            ['label' => 'Семестр', 'url' => '/admin/semester/index'],
                            ['label' => 'Типы занятий', 'url' => '/admin/training/index'],
                            ['label' => 'Дисциплина', 'url' => '/admin/discipline/index'],
                            ['label' => 'Номер занятия', 'url' => '/admin/couple/index'],
                            ['label' => 'Формы обучения', 'url' => '/admin/study/index'],
                            ['label' => 'Квалификация обучения', 'url' => '/admin/qualification/index'],
                            ['label' => 'Оценки', 'url' => '/admin/evaluation/index'],    
                            ['label' => 'Статус посещений', 'url' => '/admin/visit/index'],   
                        ],
                    ],
                ],
            ]);
        ?>
    </div>
    <div class="wrap">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
