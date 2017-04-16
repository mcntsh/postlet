<?php

namespace common\models;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\filters\auth\HttpBearerAuth;

use common\models\BaseModel;

use yii\web\IdentityInterface;

class Account extends BaseModel implements IdentityInterface
{

  public static function tableName()
  {
    return '{{%accounts}}';
  }

  public function getId()
  {
    return $this->getPrimaryKey();
  }

  public static function findIdentity($id)
  {
    return static::findOne($id);
  }

  public static function findIdentityByAccessToken($token, $type = null)
  {
    return static::findOne(['auth_key' => $token]);
  }

  public static function findByEmail($email)
  {
    return static::findOne(['email' => $email]);
  }

  public static function findByPasswordResetToken($token)
  {
    if(!static::isPasswordResetTokenValid($token)) {
      return null;
    }
    return static::findOne([
      'password_reset_token' => $token,
    ]);
  }

  public static function isPasswordResetTokenValid($token)
  {
    if(empty($token)) {
      return false;
    }

    $timestamp = (int) substr($token, strrpos($token, '_') + 1);
    $expire = Yii::$app->params['user.passwordResetTokenExpire'];

    return $timestamp + $expire >= time();
  }

  public function setPassword($password)
  {
    $this->password_hash = Yii::$app->security->generatePasswordHash($password);
  }

  public function validatePassword($password)
  {
    return Yii::$app->security->validatePassword($password, $this->password_hash);
  }

  public function generatePasswordResetToken()
  {
    $this->password_reset_token = md5(Yii::$app->security->generateRandomString()) . '_' . time();
  }

  public function removePasswordResetToken()
  {
    $this->password_reset_token = null;
  }

  // Auth Key

  public function generateAuthKey()
  {
    return md5($this->email . $this->password_hash . time());
  }

  public function getAuthKey()
  {
    return $this->auth_key;
  }

  public function validateAuthKey($authKey)
  {
    return $this->getAuthKey() === $authKey;
  }

}
