<?php
namespace app\modules\v1\controllers;

use Yii;

use app\modules\v1\components\ApiController as ApiController;
use app\modules\v1\enums\ErrorEnum;

use common\models\Post;

class UserController extends ApiController
{

  public function actionIndex()
  {
    $this->addError('token', ErrorEnum::Invalid, 'The auth token is invalid');
    $this->setResponseError(403);
  }

}
