<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use common\behaviors\UuidBehavior;

use yii\db\Expression;
use yii\db\ActiveRecord;

class BaseModel extends ActiveRecord
{

  public function behaviors()
  {
    return [
      [
        'class' => TimestampBehavior::className(),
        'createdAtAttribute' => 'created_at',
        'updatedAtAttribute' => 'updated_at',
        'value' => new Expression('NOW()'),
      ],
      ['class' => UuidBehavior::className()],
    ];
  }

}
