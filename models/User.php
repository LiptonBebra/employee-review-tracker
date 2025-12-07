<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string $created_at
 * @property string $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    const ROLE_EMPLOYEE = 'employee';
    const ROLE_MANAGER = 'manager';
    const ROLE_ADMIN = 'admin';

    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['name', 'email', 'password'], 'required'],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['role'], 'in', 'range' => [self::ROLE_EMPLOYEE, self::ROLE_MANAGER, self::ROLE_ADMIN]],
            [['name'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'ФИО',
            'email' => 'Email',
            'password' => 'Пароль',
            'role' => 'Роль',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->password = Yii::$app->security->generatePasswordHash($this->password);
            }
            return true;
        }
        return false;
    }

    // IdentityInterface methods
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    public function isManager()
    {
        return in_array($this->role, [self::ROLE_MANAGER, self::ROLE_ADMIN]);
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function getReviews()
    {
        return $this->hasMany(Review::class, ['user_id' => 'id']);
    }

    public function getAuthoredReviews()
    {
        return $this->hasMany(Review::class, ['reviewer_id' => 'id']);
    }
}