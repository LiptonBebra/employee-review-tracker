<?php
use yii\helpers\Html;
use yii\helpers\Url;

$isManager = Yii::$app->user->identity->isManager();
?>

<div class="flex items-center justify-between">
    <div class="flex-1">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-medium text-gray-900">
                    <?= Html::a($model->user->name, ['view', 'id' => $model->id], [
                        'class' => 'hover:text-blue-600'
                    ]) ?>
                </h3>
                <p class="text-sm text-gray-500">
                    Дата оценки: <?= Yii::$app->formatter->asDate($model->review_date) ?>
                </p>
                <?php if ($isManager): ?>
                    <p class="text-sm text-gray-500">
                        Ревьюер: <?= $model->reviewer->name ?>
                    </p>
                <?php endif; ?>
            </div>
            <div class="text-right">
                <div class="flex space-x-4 text-sm">
                    <div class="text-center">
                        <span class="text-gray-500">Soft Skills</span>
                        <div class="text-2xl font-bold text-blue-600"><?= $model->soft_skills_score ?></div>
                    </div>
                    <div class="text-center">
                        <span class="text-gray-500">Hard Skills</span>
                        <div class="text-2xl font-bold text-green-600"><?= $model->hard_skills_score ?></div>
                    </div>
                    <div class="text-center">
                        <span class="text-gray-500">Общий</span>
                        <div class="text-2xl font-bold text-purple-600"><?= number_format($model->getTotalScore(), 1) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($model->comment): ?>
            <div class="mt-2">
                <p class="text-sm text-gray-600">
                    <span class="font-medium">Комментарий:</span>
                    <?= nl2br(Html::encode($model->comment)) ?>
                </p>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($isManager): ?>
        <div class="ml-4 flex-shrink-0 flex space-x-2">
            <?= Html::a('Просмотр', ['view', 'id' => $model->id], [
                'class' => 'bg-blue-100 hover:bg-blue-200 text-blue-800 px-3 py-1 rounded text-sm font-medium'
            ]) ?>

            <?php if ($model->canEdit()): ?>
                <?= Html::a('Редактировать', ['update', 'id' => $model->id], [
                    'class' => 'bg-yellow-100 hover:bg-yellow-200 text-yellow-800 px-3 py-1 rounded text-sm font-medium'
                ]) ?>
                <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'bg-red-100 hover:bg-red-200 text-red-800 px-3 py-1 rounded text-sm font-medium',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить эту оценку?',
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>