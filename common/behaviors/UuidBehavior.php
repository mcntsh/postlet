<?php
namespace common\behaviors;

use Yii;

use yii\behaviors\AttributeBehavior;

use yii\base\InvalidCallException;
use yii\db\BaseActiveRecord;

use yii\validators\UniqueValidator;

class UuidBehavior extends AttributeBehavior
{

  public $uuidAttribute = 'uuid';
  public $length = 15;
  public $uniqueValidator = [];

  public function init()
  {
    parent::init();

    if (empty($this->attributes)) {
      $this->attributes = [
        BaseActiveRecord::EVENT_BEFORE_INSERT => $this->uuidAttribute,
      ];
    }
  }


  protected function getValue($event)
  {
    return $this->generateUniqueUuid();
  }


  protected function generateUniqueUuid()
  {
    $uniqueUuid = $this->generateUuid();

    while (!$this->validateUuid($uniqueUuid)) {
      $uniqueUuid = $this->generateUuid();
    }

    return $uniqueUuid;
  }

  protected function generateUuid()
  {
    return md5(Yii::$app->getSecurity()->generateRandomString($this->length));
  }

  protected function validateUuid($uuid)
  {
    $validator = Yii::createObject(array_merge(
      [
        'class' => UniqueValidator::className(),
      ],
      $this->uniqueValidator
    ));

    $model = clone $this->owner;
    $model->clearErrors();
    $model->{$this->uuidAttribute} = $uuid;

    $validator->validateAttribute($model, $this->uuidAttribute);

    return !$model->hasErrors();
  }

}
