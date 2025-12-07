<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Регистрация
            </h2>
        </div>

        <?php $form = ActiveForm::begin([
            'id' => 'register-form',
            'options' => ['class' => 'mt-8 space-y-6']
        ]); ?>

        <div class="rounded-md shadow-sm -space-y-px">
            <div>
                <?= $form->field($model, 'name')
                    ->textInput([
                        'autofocus' => true,
                        'class' => 'appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm',
                        'placeholder' => 'ФИО'
                    ])
                    ->label(false) ?>
            </div>
            <div>
                <?= $form->field($model, 'email')
                    ->textInput([
                        'class' => 'appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm',
                        'placeholder' => 'Email'
                    ])
                    ->label(false) ?>
            </div>
            <div>
                <?= $form->field($model, 'password')
                    ->passwordInput([
                        'class' => 'appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm',
                        'placeholder' => 'Пароль'
                    ])
                    ->label(false) ?>
            </div>
        </div>

        <div>
            <?= Html::submitButton('Зарегистрироваться', [
                'class' => 'group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500'
            ]) ?>
        </div>

        <div class="text-center">
            <?= Html::a('Уже есть аккаунт? Войдите', ['site/login'], [
                'class' => 'font-medium text-blue-600 hover:text-blue-500'
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>