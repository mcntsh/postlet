<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Post extends ActiveRecord
{

  public function behaviors()
  {
    return [
      TimestampBehavior::className(),
    ];
  }

  public static function tableName()
  {
    return 'post';
  }

  public function test()
  {
    
  }

}
