<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use app\models\Review;
use app\models\User;

class ReviewController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $currentUser = Yii::$app->user->identity;
        $searchModel = new \app\models\ReviewSearch();

        if ($currentUser->isManager()) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => Review::find()->where(['user_id' => $currentUser->id]),
                'sort' => ['defaultOrder' => ['review_date' => SORT_DESC]]
            ]);
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'isManager' => $currentUser->isManager(),
        ]);
    }

    public function actionView($id)
    {
        $review = $this->findModel($id);
        $currentUser = Yii::$app->user->identity;

        // Проверка прав доступа
        if (!$currentUser->isManager() && $review->user_id != $currentUser->id) {
            throw new \yii\web\ForbiddenHttpException('У вас нет доступа к этой оценке.');
        }

        return $this->render('view', [
            'model' => $review,
        ]);
    }

    public function actionCreate()
    {
        $currentUser = Yii::$app->user->identity;
        if (!$currentUser->isManager()) {
            throw new \yii\web\ForbiddenHttpException('Только руководители могут создавать оценки.');
        }

        $model = new Review();
        $model->reviewer_id = $currentUser->id;
        $model->review_date = date('Y-m-d');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Оценка успешно создана.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $employees = User::find()->where(['role' => User::ROLE_EMPLOYEE])->all();

        return $this->render('create', [
            'model' => $model,
            'employees' => $employees,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $currentUser = Yii::$app->user->identity;

        if (!$currentUser->isManager()) {
            throw new \yii\web\ForbiddenHttpException('Только руководители могут редактировать оценки.');
        }

        if (!$model->canEdit()) {
            Yii::$app->session->setFlash('error', 'Редактирование оценки невозможно после 30 дней с даты создания.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Оценка успешно обновлена.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $employees = User::find()->where(['role' => User::ROLE_EMPLOYEE])->all();

        return $this->render('update', [
            'model' => $model,
            'employees' => $employees,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $currentUser = Yii::$app->user->identity;

        if (!$currentUser->isManager()) {
            throw new \yii\web\ForbiddenHttpException('Только руководители могут удалять оценки.');
        }

        if (!$model->canEdit()) {
            Yii::$app->session->setFlash('error', 'Удаление оценки невозможно после 30 дней с даты создания.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Оценка успешно удалена.');
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Review::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная оценка не найдена.');
    }
}