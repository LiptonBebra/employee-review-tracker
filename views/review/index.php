<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = 'Оценки сотрудников';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="review-index">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900"><?= Html::encode($this->title) ?></h1>

        <?php if ($isManager): ?>
            <?= Html::a('Добавить оценку', ['create'], ['class' => 'bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium']) ?>
        <?php endif; ?>
    </div>

    <?php if ($isManager): ?>
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Фильтры и поиск</h3>
                <?php $form = \yii\widgets\ActiveForm::begin([
                    'method' => 'get',
                    'action' => ['index'],
                    'options' => ['class' => 'grid grid-cols-1 gap-4 sm:grid-cols-3']
                ]); ?>

                <?= $form->field($searchModel, 'employeeName', [
                    'options' => ['class' => '']
                ])->textInput([
                    'placeholder' => 'Поиск по имени сотрудника',
                    'class' => 'mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md'
                ])->label('Имя сотрудника') ?>

                <?= $form->field($searchModel, 'date_from', [
                    'options' => ['class' => '']
                ])->input('date', [
                    'class' => 'mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md'
                ])->label('Дата от') ?>

                <?= $form->field($searchModel, 'date_to', [
                    'options' => ['class' => '']
                ])->input('date', [
                    'class' => 'mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md'
                ])->label('Дата до') ?>

                <div class="sm:col-span-3">
                    <?= Html::submitButton('Применить фильтры', ['class' => 'bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium']) ?>
                    <?= Html::a('Сбросить', ['index'], ['class' => 'ml-2 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium']) ?>
                </div>

                <?php \yii\widgets\ActiveForm::end(); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php Pjax::begin(); ?>
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_review_item',
            'layout' => "{items}\n{pager}",
            'emptyText' => 'Оценки не найдены.',
            'emptyTextOptions' => ['class' => 'text-center py-8 text-gray-500'],
            'options' => ['class' => 'divide-y divide-gray-200'],
            'itemOptions' => ['class' => 'px-4 py-4 sm:px-6 hover:bg-gray-50'],
        ]) ?>
    </div>
    <?php Pjax::end(); ?>
</div>