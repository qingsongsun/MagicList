<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $id
 * @property string $username 用户名
 * @property string $password 密码
 * @property string $access_token 登录令牌
 * @property string $qq_account qq账号
 * @property string $created_time 创建时间
 * @property string $updated_time 更新时间
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['created_time', 'updated_time'], 'safe'],
            [['username', 'password', 'access_token', 'qq_account'], 'string', 'max' => 255],
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException("findIdentityByAccessToken is not implemented.");
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->access_token;
    }

    public function validateAuthKey($access_token)
    {
        return $this->getAccessToken() === $access_token;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'password' => '密码',
            'access_token' => '登录令牌',
            'qq_account' => 'qq账号',
            'created_time' => '创建时间',
            'updated_time' => '更新时间',
        ];
    }
}
