<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
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
<div class="wrap">
    <?php
        NavBar::begin([
            'brandLabel' => 'Учебный процесс',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-default navbar-fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                Yii::$app->user->isGuest ? (
                    ''
                ) : (
                       
                    ['label' => 'Сообщения', 'url' => ['/site/index']]
                    
                ),

                Yii::$app->user->identity->role_id == 1 ? (
                   ['label' => 'Админка', 'url' => ['/admin']]
                ) : (
                    ''
                ),

                Yii::$app->user->identity->role_id == 3 ? (
                   ['label' => 'Расписание', 'url' => ['/timetable/view', 'users' => Yii::$app->user->identity->id]]
                ) : (
                    ''
                ),

                Yii::$app->user->identity->role_id == 3 ? (
                   ['label' => 'Журнал', 'url' => ['/journals/view', 'users' => Yii::$app->user->identity->id]]
                ) : (
                    ''
                ),

                Yii::$app->user->isGuest ? (
                    ['label' => 'Войти', 'url' => ['/site/login']]
                ) : (
                    [   
                        'label' => Yii::$app->user->identity->username,
                        'items' => [
                            ['label' => 'Профиль', 'url' => ['/site/profile', 'id' => Yii::$app->user->identity->id]],
                            ['label' => 'Выйти', 'url' => '/site/logout', ['class' => 'btn btn-link logout'], 'linkOptions' => ['data-method' => 'post']],
                        ],
                    ]
                ),
            ],
        ]);
        NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Учебный процесс 2017</p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
