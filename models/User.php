<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $fio
 * @property string $phone
 * @property string $email
 * @property string $role
 *
 * @property Application[] $applications
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    /**
     * ENUM field values
     */
    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'fio', 'phone', 'email'], 'required'],
            [['role'], 'string'],
            [['username', 'password', 'fio', 'phone', 'email'], 'string', 'max' => 255],
            ['role', 'in', 'range' => array_keys(self::optsRole())],
            [['username'], 'unique'],
            [['email'], 'unique'],
            ['role', 'default', 'value'=>'user'],
            ['role', 'in', 'range'=>['user', 'admin']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'fio' => 'Fio',
            'phone' => 'Phone',
            'email' => 'Email',
            'role' => 'Role',
        ];
    }

    /**
     * Gets query for [[Applications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Application::class, ['user_id' => 'id']);
    }


    /**
     * column role ENUM value labels
     * @return string[]
     */
    public static function optsRole()
    {
        return [
            self::ROLE_USER => 'user',
            self::ROLE_ADMIN => 'admin',
        ];
    }

    /**
     * @return string
     */
    public function displayRole()
    {
        return self::optsRole()[$this->role];
    }

    /**
     * @return bool
     */
    public function isRoleUser()
    {
        return $this->role === self::ROLE_USER;
    }

    public function setRoleToUser()
    {
        $this->role = self::ROLE_USER;
    }

    /**
     * @return bool
     */
    public function isRoleAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function setRoleToAdmin()
    {
        $this->role = self::ROLE_ADMIN;
    }


    public function beforeSave($insert) {
        if(parent::beforeSave($insert)) {
            if($this->isNewRecord && $this->password) {
                $this->password = Yii::$app->security->generatePasswordHash($this->password);
            }
            return true;
        }
        return false;
    }
    public function isAdmin() {
        return $this->role === 'admin';
    }
    public static function findByUsername($username) {
        return static::findOne(['username'=>$username]);
    }
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password);
    }
    public static function findIdentity($id) {
        return static::findOne($id);
    }
    public static function findIdentityByAccessToken($token, $type=null) {
        return null;
    }
    public function getAuthKey() {
        return null;
    }
    public function validateAuthKey($authkey) {
        return false;
    }
    public function getId() {
        return $this->id;
    }
}
