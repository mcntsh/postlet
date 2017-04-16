<?php

namespace common\models;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\RateLimitInterface;

use common\models\BaseModel;

use yii\web\IdentityInterface;

class Account extends BaseModel implements RateLimitInterface, IdentityInterface
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

  // Rate limiting

  public function getRateLimit($request, $action)
  {
    return [1, 5]; // One request every 5 seconds
  }

  public function loadAllowance($request, $action)
  {
    return [$this->rate_limit_allowance, $this->rate_limit_allowance_updated];
  }

  public function saveAllowance($request, $action, $allowance, $timestamp)
  {
    $this->rate_limit_allowance = $allowance;
    $this->rate_limit_allowance_updated = $timestamp;
    $this->save();
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
