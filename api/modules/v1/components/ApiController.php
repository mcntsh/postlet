<?php
namespace api\modules\v1\components;

use Yii;
use yii\web\Controller as YiiController;
use yii\web\Response as YiiResponse;

use api\modules\v1\enums\HttpEnum;
use api\modules\v1\filters\ResponseFilter;

class ApiController extends YiiController
{

  private $_errors = [];
  protected static $errorStatuses = [
    'INVALID'
  ];

  public function behaviors()
  {
    $behaviors = parent::behaviors();

    $behaviors['responseFilter'] = [
      'class' => ResponseFilter::className(),
      // 'only' => ['create', 'update'],
    ];

    return $behaviors;
  }

  public function getErrors()
  {
    return $this->_errors;
  }

  public function addModelErrors($errors)
  {
    return $this->_errors[$key] = array_push($this->_errors[$key], $errors);
  }

  public function addError($key, $code, $message = '')
  {
    $this->_errors[$key] = [
      'code' => $code,
    ];

    if(!empty($message)) {
      $this->_errors[$key]['message'] = $message;
    }

    return $this->_errors;
  }

  public function returnAndRespond($code = HttpEnum::ServerError, $message = '')
  {
    $this->setResponseCode($code);
    return $message;
  }

  public function setResponseCode($code = HttpEnum::ServerError)
  {
    Yii::$app->response->setStatusCode($code);
  }

}
