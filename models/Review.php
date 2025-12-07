<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $user_id
 * @property int $reviewer_id
 * @property string $review_date
 * @property float $soft_skills_score
 * @property float $hard_skills_score
 * @property string $comment
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 * @property User $reviewer
 */
class Review extends ActiveRecord
{
    public static function tableName()
    {
        return 'reviews';
    }

    public function rules()
    {
        return [
            [['user_id', 'reviewer_id', 'review_date', 'soft_skills_score', 'hard_skills_score'], 'required'],
            [['user_id', 'reviewer_id'], 'integer'],
            [['review_date'], 'date', 'format' => 'php:Y-m-d'],
            [['soft_skills_score', 'hard_skills_score'], 'number', 'min' => 0, 'max' => 10],
            [['comment'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['reviewer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['reviewer_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Сотрудник',
            'reviewer_id' => 'Ревьюер',
            'review_date' => 'Дата оценки',
            'soft_skills_score' => 'Soft Skills',
            'hard_skills_score' => 'Hard Skills',
            'comment' => 'Комментарий',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getReviewer()
    {
        return $this->hasOne(User::class, ['id' => 'reviewer_id']);
    }

    public function getTotalScore()
    {
        return ($this->soft_skills_score + $this->hard_skills_score) / 2;
    }

    public function canEdit()
    {
        $reviewDate = new \DateTime($this->review_date);
        $now = new \DateTime();
        $interval = $now->diff($reviewDate);

        // Можно редактировать только в течение 30 дней после создания
        return $interval->days <= 30;
    }
}