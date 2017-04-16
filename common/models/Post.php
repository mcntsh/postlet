<?php

namespace common\models;

use common\models\BaseModel;
use common\behaviors\KeystampBehavior;

class Post extends BaseModel
{

  public static function tableName()
  {
    return '{{%posts}}';
  }

  public function behaviors()
  {
    $behaviors = parent::behaviors();

    $behaviors[] = ['class' => KeystampBehavior::className()];

    return $behaviors;
  }

}
