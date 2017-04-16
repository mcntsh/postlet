<?php
namespace api\modules\v1\filters;

use Yii;
use yii\base\ActionFilter;

class RequestFilter extends ActionFilter
{

  public function beforeAction($action)
  {
    Yii::$app->request->setBodyParams((object)Yii::$app->request->getBodyParams());

    return parent::beforeAction($action);
  }

}
