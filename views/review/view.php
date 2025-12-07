<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Оценка сотрудника: ' . $model->user->name;
$this->params['breadcrumbs'][] = ['label' => 'Оценки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$isManager = Yii::$app->user->identity->isManager();
?>

<div class="review-view">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900"><?= Html::encode($this->title) ?></h1>

        <div class="flex space-x-2">
            <?php if ($isManager && $model->canEdit()): ?>
                <?= Html::a('Редактировать', ['update', 'id' => $model->id], [
                    'class' => 'bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md text-sm font-medium'
                ]) ?>
                <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить эту оценку?',
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>
            <?= Html::a('Назад', ['index'], ['class' => 'bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium']) ?>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Информация об оценке
            </h3>
        </div>
        <div class="border-t border-gray-200">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'user_id',
                        'label' => 'Сотрудник',
                        'value' => function($model) {
                            return $model->user->name;
                        }
                    ],
                    [
                        'attribute' => 'reviewer_id',
                        'label' => 'Ревьюер',
                        'value' => function($model) {
                            return $model->reviewer->name;
                        }
                    ],
                    'review_date:date',
                    [
                        'attribute' => 'soft_skills_score',
                        'value' => function($model) {
                            return $model->soft_skills_score . '/10';
                        }
                    ],
                    [
                        'attribute' => 'hard_skills_score',
                        'value' => function($model) {
                            return $model->hard_skills_score . '/10';
                        }
                    ],
                    [
                        'label' => 'Общий балл',
                        'value' => function($model) {
                            return number_format($model->getTotalScore(), 1) . '/10';
                        }
                    ],
                    [
                        'attribute' => 'comment',
                        'format' => 'ntext',
                        'visible' => !empty($model->comment)
                    ],
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
                'options' => ['class' => 'min-w-full divide-y divide-gray-200'],
            ]) ?>
        </div>
    </div>

    <!-- Визуализация оценок -->
    <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Soft Skills</h3>
            <div class="w-full bg-gray-200 rounded-full h-4">
                <div class="bg-blue-600 h-4 rounded-full" style="width: <?= $model->soft_skills_score * 10 ?>%"></div>
            </div>
            <div class="mt-2 text-sm text-gray-600 text-right"><?= $model->soft_skills_score ?>/10</div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Hard Skills</h3>
            <div class="w-full bg-gray-200 rounded-full h-4">
                <div class="bg-green-600 h-4 rounded-full" style="width: <?= $model->hard_skills_score * 10 ?>%"></div>
            </div>
            <div class="mt-2 text-sm text-gray-600 text-right"><?= $model->hard_skills_score ?>/10</div>
        </div>
    </div>
</div>