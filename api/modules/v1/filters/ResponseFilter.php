<?php
namespace api\modules\v1\filters;

use Yii;
use yii\base\ActionFilter;

class ResponseFilter extends ActionFilter
{

  private $_errors = [];

  public function init()
  {
    Yii::$app->response->on(Yii::$app->response::EVENT_BEFORE_SEND, [$this, 'handleExceptions']);
  }

  public function handleExceptions($event)
  {
    $responseData = (object)$event->sender->data;
    
    if(!isset($responseData->code)) {
      return;
    }

    $responseData = [
      'status' => [
        'code' => $responseData->status,
        'message' => $responseData->name,
      ],
      'body' => $responseData->message
    ];

    $event->sender->data = $responseData;
  }

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
