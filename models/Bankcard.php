<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace yuncms\wallet\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * 银行卡模型
 * @property int $id
 * @property int $user_id
 * @property string $bank 银行名称
 * @property string $city 开户城市
 * @property string $username 开户名
 * @property string $name 开户行
 * @property string $number 银行卡号
 * @property integer $created_at
 * @property integer $updated_at
 * @package yuncms\user\models
 */
class Bankcard extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%bankcard}}';
    }

    /**
     * 定义行为
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior'
            ],
            'blameable' => [
                'class' => 'yii\behaviors\BlameableBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'user_id',
                ],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bank', 'city', 'username', 'name', 'number'], 'required'],
            [['bank', 'city', 'username', 'name', 'number'], 'filter', 'filter' => 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bank' => Yii::t('wallet', 'Bank'),
            'city' => Yii::t('wallet', 'Bank City'),
            'username' => Yii::t('wallet', 'Bank Username'),
            'name' => Yii::t('wallet', 'Bank Name'),
            'number' => Yii::t('wallet', 'BankCard Number'),
            'created_at' => Yii::t('wallet', 'Created At'),
            'updated_at' => Yii::t('wallet', 'Updated At'),
        ];
    }

    /**
     * 用户关系定义
     * @return \yii\db\ActiveQueryInterface
     */
    public function getUser()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'user_id']);
    }
}