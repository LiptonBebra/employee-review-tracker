<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class ReviewSearch extends Review
{
    public $employeeName;
    public $date_from;
    public $date_to;

    public function rules()
    {
        return [
            [['employeeName', 'date_from', 'date_to'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Review::find()->joinWith(['user']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['review_date' => SORT_DESC],
                'attributes' => [
                    'review_date',
                    'soft_skills_score',
                    'hard_skills_score',
                    'employeeName' => [
                        'asc' => ['users.name' => SORT_ASC],  // Исправлено: users.name вместо user.name
                        'desc' => ['users.name' => SORT_DESC], // Исправлено: users.name вместо user.name
                    ]
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Фильтр по имени сотрудника
        if (!empty($this->employeeName)) {
            $query->andWhere(['like', 'users.name', $this->employeeName]); // Исправлено: users.name вместо user.name
        }

        // Фильтр по дате от
        if (!empty($this->date_from)) {
            $query->andWhere(['>=', 'review_date', $this->date_from]);
        }

        // Фильтр по дате до
        if (!empty($this->date_to)) {
            $query->andWhere(['<=', 'review_date', $this->date_to]);
        }

        return $dataProvider;
    }
}