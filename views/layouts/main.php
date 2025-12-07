<?php
use yii\helpers\Html;
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
    <body class="bg-gray-100">
    <?php $this->beginBody() ?>

    <nav class="bg-blue-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <h1 class="text-white text-xl font-bold">Employee Review Tracker</h1>
                    <?php if (!Yii::$app->user->isGuest): ?>
                        <a href="<?= Yii::$app->homeUrl ?>" class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">Главная</a>
                    <?php endif; ?>
                </div>
                <div class="flex items-center space-x-4">
                    <?php if (!Yii::$app->user->isGuest): ?>
                        <span class="text-white"><?= Yii::$app->user->identity->name ?></span>
                        <span class="text-blue-200">(<?= Yii::$app->user->identity->role ?>)</span>
                        <?= Html::a('Выход', ['site/logout'], [
                            'class' => 'bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-md text-sm font-medium',
                            'data' => ['method' => 'post']
                        ]) ?>
                    <?php else: ?>
                        <?= Html::a('Вход', ['site/login'], ['class' => 'text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium']) ?>
                        <?= Html::a('Регистрация', ['site/register'], ['class' => 'bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-md text-sm font-medium']) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <?= $content ?>
    </main>

    <footer class="bg-white shadow-inner mt-8">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-500 text-sm">
                &copy; <?= date('Y') ?> Employee Review Tracker. Все права защищены.
            </p>
        </div>
    </footer>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>