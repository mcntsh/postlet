<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

use yii\db\Expression;
use yii\db\ActiveRecord;

class Post extends ActiveRecord
{

  public static function tableName()
  {
    return '{{%post}}';
  }

  public function behaviors()
  {
    return [
      [
        'class' => TimestampBehavior::className(),
        'createdAtAttribute' => 'created_at',
        'updatedAtAttribute' => 'updated_at',
        'value' => new Expression('NOW()'),
      ],
    ];
  }

  public function attributeLabels()
    {
      return [
        'body' => 'Body',
      ];
    }

}
