<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "application".
 *
 * @property int $id
 * @property int $user_id
 * @property string $coursename
 * @property string $datestart
 * @property string $payment
 * @property string $status
 *
 * @property User $user
 */
class Application extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const PAYMENT_CASH = 'cash';
    const PAYMENT_PHONE = 'phone';
    const STATUS_NEW = 'new';
    const STATUS_STUDYING = 'studying';
    const STATUS_COMPLETED = 'completed';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'coursename', 'datestart', 'payment', 'status'], 'required'],
            [['user_id'], 'integer'],
            [['datestart'], 'safe'],
            [['payment', 'status'], 'string'],
            [['coursename'], 'string', 'max' => 255],
            ['payment', 'in', 'range' => array_keys(self::optsPayment())],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'coursename' => 'Coursename',
            'datestart' => 'Datestart',
            'payment' => 'Payment',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }


    /**
     * column payment ENUM value labels
     * @return string[]
     */
    public static function optsPayment()
    {
        return [
            self::PAYMENT_CASH => 'cash',
            self::PAYMENT_PHONE => 'phone',
        ];
    }

    /**
     * column status ENUM value labels
     * @return string[]
     */
    public static function optsStatus()
    {
        return [
            self::STATUS_NEW => 'new',
            self::STATUS_STUDYING => 'studying',
            self::STATUS_COMPLETED => 'completed',
        ];
    }

    /**
     * @return string
     */
    public function displayPayment()
    {
        return self::optsPayment()[$this->payment];
    }

    /**
     * @return bool
     */
    public function isPaymentCash()
    {
        return $this->payment === self::PAYMENT_CASH;
    }

    public function setPaymentToCash()
    {
        $this->payment = self::PAYMENT_CASH;
    }

    /**
     * @return bool
     */
    public function isPaymentPhone()
    {
        return $this->payment === self::PAYMENT_PHONE;
    }

    public function setPaymentToPhone()
    {
        $this->payment = self::PAYMENT_PHONE;
    }

    /**
     * @return string
     */
    public function displayStatus()
    {
        return self::optsStatus()[$this->status];
    }

    /**
     * @return bool
     */
    public function isStatusNew()
    {
        return $this->status === self::STATUS_NEW;
    }

    public function setStatusToNew()
    {
        $this->status = self::STATUS_NEW;
    }

    /**
     * @return bool
     */
    public function isStatusStudying()
    {
        return $this->status === self::STATUS_STUDYING;
    }

    public function setStatusToStudying()
    {
        $this->status = self::STATUS_STUDYING;
    }

    /**
     * @return bool
     */
    public function isStatusCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function setStatusToCompleted()
    {
        $this->status = self::STATUS_COMPLETED;
    }

    public function getStatuses() {
        return [
            'new'=>'new',
            'studying'=>'studying',
            'completed'=>'completed',
        ];
    }
    public function getPayment() {
        return [
            'cash'=>'cash',
            'phone'=>'phone',
        ];
    }
}
