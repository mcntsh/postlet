<?php
namespace common\behaviors;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;

class KeystampBehavior extends AttributeBehavior
{

  public $keystampAttribute = 'auth_key_stamp';

  public $value;

  public function init()
  {
    parent::init();

    if(empty($this->attributes)) {
      $this->attributes = [
        BaseActiveRecord::EVENT_BEFORE_INSERT => $this->keystampAttribute,
      ];
    }
  }

  protected function getValue($event)
  {
    $account = Yii::$app->user->identity;

    if($this->value === null) {
      return $account ? $account->auth_key : null;
    }

    return parent::getValue($event);
  }

}
