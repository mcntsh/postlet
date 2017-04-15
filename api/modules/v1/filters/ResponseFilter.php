<?php
namespace app\modules\v1\filters;

use Yii;
use yii\base\ActionFilter;

class ResponseFilter extends ActionFilter
{

  private $_errors = [];

  public function beforeAction($action)
  {
    Yii::$app->response->format = Yii::$app->response::FORMAT_JSON;

    return parent::beforeAction($action);
  }

  public function afterAction($action, $body)
  {
    $response = [
      'status' => [
        'code' => Yii::$app->response->getStatusCode(),
        'message' => Yii::$app->response->statusText
      ],
    ];

    if(!empty($action->controller->getErrors())) {
      $response['errors'] = $action->controller->getErrors();
    }

    if(!empty($body)) {
      $response['body'] = $body;
    }

    return parent::afterAction($action, $response);
  }

}
