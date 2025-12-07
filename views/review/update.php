<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редактировать оценку: ' . $model->user->name;
$this->params['breadcrumbs'][] = ['label' => 'Оценки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>

<div class="review-update">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900"><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <?php $form = ActiveForm::begin([
                'options' => ['class' => 'space-y-6']
            ]); ?>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <?= $form->field($model, 'user_id', [
                    'options' => ['class' => '']
                ])->dropDownList(
                    \yii\helpers\ArrayHelper::map($employees, 'id', 'name'),
                    [
                        'class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm'
                    ]
                ) ?>

                <?= $form->field($model, 'review_date', [
                    'options' => ['class' => '']
                ])->input('date', [
                    'class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm'
                ]) ?>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <?= $form->field($model, 'soft_skills_score', [
                    'options' => ['class' => '']
                ])->input('number', [
                    'step' => '0.1',
                    'min' => '0',
                    'max' => '10',
                    'class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm'
                ]) ?>

                <?= $form->field($model, 'hard_skills_score', [
                    'options' => ['class' => '']
                ])->input('number', [
                    'step' => '0.1',
                    'min' => '0',
                    'max' => '10',
                    'class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm'
                ]) ?>
            </div>

            <?= $form->field($model, 'comment', [
                'options' => ['class' => '']
            ])->textarea([
                'rows' => 4,
                'class' => 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm',
                'placeholder' => 'Введите комментарий к оценке...'
            ]) ?>

            <div class="flex justify-end space-x-3">
                <?= Html::a('Отмена', ['view', 'id' => $model->id], [
                    'class' => 'bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500'
                ]) ?>
                <?= Html::submitButton('Обновить', [
                    'class' => 'bg-blue-600 border border-transparent rounded-md shadow-sm py-2 px-4 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500'
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>